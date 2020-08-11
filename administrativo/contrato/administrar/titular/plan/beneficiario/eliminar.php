<?php 
	if (!empty($_POST)) {
	extract($_POST);
	$ruta="../../../../../../";
	$nombre="vinculado";
	include_once($ruta."class/".$nombre.".php");

include_once($ruta."class/estudiante.php");
$estudiante=new estudiante;
include_once($ruta."class/persona.php");
$persona=new persona;

	${$nombre}=new $nombre;
	${$nombre}->eliminar($id);

	$datov = $vinculado->muestra($id);
	$idper=$datov['idpersona'];

	$datoest=$estudiante->mostrarTodo("idpersona = ".$idper);
$datoest=array_shift($datoest);

$idestu=$datoest['idestudiante'];


	$estudiante->eliminar($idestu);

	 
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