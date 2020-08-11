<?php
session_start();
$ruta="../../../";
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo;

include_once($ruta."class/usuario.php");
$usuario=new usuario;

include_once($ruta."funciones/funciones.php");
extract($_POST);

$idpass1=md5(e($idpass1));
$deje=$vejecutivo->muestra($idejecutivo);
$idpersona=$deje['idpersona'];
$idsede=$deje['idsede'];


$valores=array(
	"idpersona"=>"'$idpersona'",
	"idadmejecutivo"=>"'$idejecutivo'",
	"usuario"=>"'$idusuario'",
	"pass"=>"'$idpass1'",
	"idrol"=>"'$idrol'",
	"idsede"=>"'$idsede'"
);	
if($usuario->insertar($valores))
{
	?>
		<script  type="text/javascript">
         	swal({
			  title: "Exito !!!",
			  text: "Usuario Creado Correctamente",
			  type: "success",
			  showCancelButton: false,
			  confirmButtonColor: "#16c103",
			  confirmButtonText: "OK",
			  cancelButtonText: "No. Adm. Ejecutivo",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm){
			    location.href="../";
			});		
		</script>
	<?php
}
else
{
	?>
	<script type="text/javascript">
		Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
	</script>
	<?php
}
?>