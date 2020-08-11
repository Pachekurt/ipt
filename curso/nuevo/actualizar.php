<?php 
	$ruta="../../";
	include_once($ruta."class/curso.php");
	$curso=new curso;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
	$valores=array(
	     "iddocente"=>"'$iddocente'",
	     //"idsede"=>"'1'",
	     "idmodulo"=>"'$idmodulo'",
	     "horainicio"=>"'$idhoraini'",
	     "horafin"=>"'$idhorafin'",
	     "fechainicio"=>"'$idfechaini'",
	     "fechafin"=>"'$idfechafin'",
	     "descripcion"=>"'$iddesc'"
	);
	if($curso->actualizar($valores,dcUrl($idcurso)))
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