<?php 
	$ruta="../../";
	include_once($ruta."class/admgestion.php");
	$admgestion=new admgestion;
	extract($_POST);
	session_start();
	$dgestion=$admgestion->mostrarUltimo("");
	$valores=array(
	     "estado"=>"'2'"
	);	
	if($admgestion->actualizar($valores,$id))
	{
		?>
			<script  type="text/javascript">
				swal({
		              title: "Exito !!!",
		              text: "Gestion Cerrada Correctamente",
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
			Materialize.toast('<span>No se pudo generar el registro</span>', 1500);
		</script>
		<?php
	}
?>