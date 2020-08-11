<?php 
	$ruta="../../../";
	include_once($ruta."class/rol.php");
	$rol=new rol;
	extract($_POST);
	session_start();

	$valores=array(
	     "Nombre"=>"'$idnombre'",
	     "Descripcion"=>"'$iddesc'"
	);	
	if($rol->insertar($valores))
	{
		?>
			<script  type="text/javascript">
				swal({
		              title: "Exito !!!",
		              text: "Datos Registrados Correctamente",
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
			Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
		</script>
		<?php
	}

?>