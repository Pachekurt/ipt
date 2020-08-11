<?php
session_start();
$ruta="../../../../../";
include_once($ruta."class/titular.php");
$titular=new titular;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."funciones/funciones.php");
extract($_POST);
$dtitular=$titular->mostrarUltimo("idpersona=".$idpersona);
if (count($dtitular)>0) {
	$idtitular=$dtitular['idtitular'];
}
else{
	$data=array(
		"idpersona"=>"'$idpersona'"
	);	
	if($titular->insertar($data)){
		$dtitular=$titular->mostrarUltimo("idpersona=".$idpersona);
		$idtitular=$dtitular['idtitular'];
	}
	else{
		echo "No se pudo registrar el Titular";
	}
}
$lblcode=ecUrl($idcontrato);
//validar si existe la persona en la tabla titular
//SI: obtener el id de titular
//NO: insertar la persona y obtener el id de titular

$valores=array(
     "idtitular"=>"'$idtitular'",
     "estado"=>"'61'"
);
if ($admcontrato->actualizar($valores,$idcontrato)) {
  	?>
		<script type="text/javascript">
		swal({
              title: "Exito !!!",
              text: "Titular Registrado Correctamente",
              type: "success",
              showCancelButton: false,
              confirmButtonColor: "#28e29e",
              confirmButtonText: "OK",
              closeOnConfirm: false
          }, function () {
			location.href="../editar/?lblcode=<?php echo $lblcode; ?>&lblcontrato=<?php echo $idcontrato ?>";
          });
		</script>
	<?php
}
else{
	?>
		<script type="text/javascript">
			setTimeout(function() {
	            Materialize.toast('<span>0 No se pudo realizar la Operacion. Consulte con su proveedor</span>', 1500);
	        }, 1500);
		</script>
	<?php
}
?>