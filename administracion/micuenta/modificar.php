<?php
session_start();
$ruta="../../";

include_once($ruta."class/usuario.php");
$usuario=new usuario;

include_once($ruta."funciones/funciones.php");
extract($_POST);

$idpass1=md5(e($idpass1));
$valores=array(
	"pass"=>"'$idpass1'",
);	
if($usuario->actualizar($valores,$idus))
{
	?>
		<script  type="text/javascript">
         	swal({
			  title: "Exito !!!",
			  text: "Contraseña modificada correctamente",
			  type: "success",
			  showCancelButton: false,
			  confirmButtonColor: "#16c103",
			  confirmButtonText: "OK",
			  cancelButtonText: "No. Adm. Ejecutivo",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm){
			    location.href="<?php echo $ruta ?>";
			});		
		</script>
	<?php
}
else
{
	?>
	<script type="text/javascript">
		Materialize.toast('<span>No se pudo guardar el registro SSS</span>', 1500);
	</script>
	<?php
}
?>