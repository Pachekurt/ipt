<?php 
	$ruta="../../";
	include_once($ruta."class/admejecutivo.php");
	$admejecutivo=new admejecutivo;
	include_once($ruta."class/usuario.php");
	$usuario=new usuario;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	$id=dcUrl($id);
	session_start();
	$valores=array(
	     "estado"=>"'$estado'"
	);	
	if($admejecutivo->actualizar($valores,$id))
	{
		$valoresd=array(
		    "pass"=>"'e514b125ffb59bd135b852a5cc887258'"
		);	
		if($usuario->actualizar($valoresd,$id))
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
					Materialize.toast('<span>Error al Actualizar</span>', 150);
				</script>
			<?php
		}	
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