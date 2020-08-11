<?php 
	$ruta="../../../";
	include_once($ruta."class/rol.php");
	$rol=new rol;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
	$valores=array(
	     "Nombre"=>"'$idnombre'",
	     "Descripcion"=>"'$iddesc'"
	);	
	if($rol->actualizar($valores,dcUrl($idrol)))
	{
		?>
			<script  type="text/javascript">
				swal({
		              title: "Exito !!!",
		              text: "Datos Actualizados Correctamente",
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
			setTimeout(function() {
	            Materialize.toast('<span>No se pudo realizar la operacion</span>', 1500);
	        }, 1500);
		</script>
		<?php
	}

?>