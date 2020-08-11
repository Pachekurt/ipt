<?php 
	$ruta="../../";
	include_once($ruta."class/admorganizacion.php");
	$admorganizacion=new admorganizacion;
	extract($_POST);
	session_start();

	$valores=array(
	     "nombre"=>"'$idnombre'",
	     "idsede"=>"'$idsede'"
	);	
	if($admorganizacion->insertar($valores))
	{
		?>
			<script  type="text/javascript">
				swal({
		              title: "Exito !!!",
		              text: "Organizacion Creada Correctamente",
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