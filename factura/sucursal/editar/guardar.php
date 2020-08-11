<?php 
	$ruta="../../../";
	include_once($ruta."class/admsucursal.php");
	$admsucursal=new admsucursal;
	extract($_POST);
	session_start();

	$valores=array(
	     "direccion"=>"'$iddireccion'",
	     "zona"=>"'$idzona'",
	     "telefonos"=>"'$idfono'",
	     "actividad"=>"'$idactividad'",
	);	
	if($admsucursal->actualizar($valores,$id))
	{
		?>
			<script  type="text/javascript">
				swal({
		              title: "Exito !!!",
		              text: "Daros Modificados Correctamente",
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