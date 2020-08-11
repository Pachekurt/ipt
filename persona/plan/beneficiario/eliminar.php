<?php 
	if (!empty($_POST)) {
	extract($_POST);
	$ruta="../../../../../../";
	$nombre="vinculado";
	include_once($ruta."class/".$nombre.".php");
	${$nombre}=new $nombre;
	${$nombre}->eliminar($id);
		?>
			<script  type="text/javascript">
				swal({
		              title: "Exito !",
		              text: "Beneficario dado de baja correctamente",
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
	          }, 10);
	    </script>
		<?php
	}
?>