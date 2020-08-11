<?php
session_start();
$ruta="../../";
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo;

include_once($ruta."class/usuario.php");
$usuario=new usuario;
include_once($ruta."class/admejecutivo.php");
$admejecutivo=new admejecutivo;
include_once($ruta."funciones/funciones.php");
extract($_POST);
$valores=array(
	"idsede"=>"'$idsede'"
);
$usuario->actualizar($valores,$idusuario);
$dus=$usuario->muestra($idusuario);
$deje=$admejecutivo->muestra($dus['idadmejecutivo']);
if(count($deje)>0)
{
	$valores=array(
		"idsede"=>"'$idsede'"
	);
	$admejecutivo->actualizar($valores,$deje['idadmejecutivo']);	
}
$_SESSION["idsede"]=$idsede;
?>
	<script  type="text/javascript">
     	swal({
		  title: "Exito !!!",
		  text: "Sede modificado correctamente",
		  type: "success",
		  showCancelButton: false,
		  confirmButtonColor: "#16c103",
		  confirmButtonText: "OK",
		  cancelButtonText: "No. Adm. Ejecutivo",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		    location.reload();
		});		
	</script>
	<?php
?>