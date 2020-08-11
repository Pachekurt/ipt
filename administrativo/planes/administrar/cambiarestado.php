<?php 
	$ruta="../../../"; 
	include_once($ruta."class/admplan.php");
	$admplan=new admplan;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	 
	session_start();
 
		 $valores=array(
	     "activo"=>"'$estado'",
	      
	);	
	 
 
	if($admplan->actualizar($valores,$id))
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