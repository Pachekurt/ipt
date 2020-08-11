<?php
session_start();
$ruta="../../../";
include_once($ruta."class/admejecutivo.php");
$admejecutivo=new admejecutivo;

include_once($ruta."funciones/funciones.php");
extract($_POST);

$fecha=date("Y-m-d");


$data=array(
	"idpersona"=>"'$idpersona'",
	"idcargo"=>"'9'",
	"idsede"=>"'0'",
	"idorganizacion"=>"'0'",
	"idtipoejecutivo"=>"'0'",
	"idhorarios"=>"'0'",
	"fechaingreso"=>"'$fecha'"
);	
if($admejecutivo->insertar($data)){
	$dejecutivo=$admejecutivo->mostrarUltimo("idpersona=".$idpersona);
	$lblcode=ecUrl($dejecutivo['idadmejecutivo']);
	?>
		<script type="text/javascript">
		swal({
              title: "Exito !!!",
              text: "Ejecutivo Registrado Correctamente",
              type: "success",
              showCancelButton: false,
              confirmButtonColor: "#28e29e",
              confirmButtonText: "OK",
              closeOnConfirm: false
          }, function () {
			location.href="../editar/?lblcode=<?php echo $lblcode; ?>";
          });
		</script>
	<?php
}
else{
	echo "No se pudo registrar el Ejecutivo";
	?>
		<script type="text/javascript">
			sweetAlert("Oops...", "No se pudo registrar. Intente de nuevo o consulte con el Dpto. de Sistemas ", "error");
		</script>
	<?php
}

?>