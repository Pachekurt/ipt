<?php 
	$ruta="../../"; 
	include_once($ruta."class/usuario.php");
	$usuario=new usuario;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	 
	session_start();

	if ($estado==1) {
		 $valores=array(
	     "activo"=>"'$estado'",
	     "pass"=>"'56376e8e7cfbf3050a3cc57f7e87fdde'"
	);	
	}
	else
	{
		 $valores=array(
	     "activo"=>"'$estado'",
	     "pass"=>"'08123c9d824f4d8b8d58328b41a8108b'"
	);	
		
	}
if ($estado==1) {
	 
}
else
{

}
	if($usuario->actualizar($valores,$id))
	{
		 
		 
		?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Operacion Realizada Correctamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#28e29e",
					confirmButtonText: "OK",
					closeOnConfirm: false
		        }, function () {      
		            location.reload();

		        });				
			</script>
		<?php 
		}	 
	else
	{
		?>
			<script type="text/javascript">
				Materialize.toast('<span>No se pudo generar el registro</span>', 150);
			</script>
		<?php
	} 
?>