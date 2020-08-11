<?php
session_start();
$ruta="../../../../../";
include_once($ruta."class/titular.php");
$titular=new titular;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."class/admorgani.php");
$admorgani=new admorgani;
include_once($ruta."class/admejecutivo.php");
$admejecutivo=new admejecutivo;
include_once($ruta."class/admsemana.php");
$admsemana=new admsemana;
include_once($ruta."class/admcontratodelle.php");
$admcontratodelle=new admcontratodelle;
include_once($ruta."funciones/funciones.php");
extract($_POST);
$dtitular=$titular->mostrarUltimo("idpersona=".$idpersona);

// obtenemos el organigrama activo de la organizacion***********************************************/
$dcontrato=$admcontrato->muestra($idcontrato);
$dejec=$admejecutivo->muestra($dcontrato['idadmejecutivo']);
$dorgani=$admorgani->mostrarUltimo("idadmorganizacion=".$dejec['idorganizacion']." and estado=1");
$idorganigrama=$dorgani['idadmorgani'];
/******************************************************************************************************/
// obtenemos semana
$dsemana=$admsemana->mostrarUltimo("estado=1");
$idsemana=$dsemana['idadmsemana'];

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

/******************    Se debera crear un registro de asignacion de titular al contrato  **********************/
/**************************************************************************************************************/
$fecha=date("Y-m-d");
$hora=date("H:i:s");
$valores=array(
     "idorganigrama"=>"'$idorganigrama'",
     "idadmsemana"=>"'$idsemana'",
     "idtitular"=>"'$idtitular'",
     "estado"=>"'68'",
     "fechaestado"=>"'$fecha'"
);
if ($admcontrato->actualizar($valores,$idcontrato)) {
	/******** inserta contrato detalle *********/
		$valores2=array(
			"idcontrato"=>$idcontrato,
			"idtitular"=>$idtitular,
			"idsemana"=>"'$idsemana'",
			"fecha"=>"'$fecha'",
			"hora"=>"'$hora'",
			"idsemana"=>"'$idsemana'",
			"detalle"=>"'ASIGNACION DE TITULAR'",
			"estado"=>"'68'",
			"codigo"=>"'3112'"
		);	
		$admcontratodelle->insertar($valores2);
	/*******************************************/
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
			location.href="../plan/?lblcode=<?php echo $lblcode; ?>";
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