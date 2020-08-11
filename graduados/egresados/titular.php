<?php 
$ruta="../../";
include_once($ruta."class/estudiante.php");
$estudiante=new estudiante; 
extract($_GET); 
extract($_POST);

$valores=array(
	     "estadoacademico"=>"'151'"
	);	
	if($estudiante->actualizar($valores,$id))
	{
		?>
				<script type="text/javascript"> 
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
?>