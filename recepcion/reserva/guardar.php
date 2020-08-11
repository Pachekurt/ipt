<?php 
$ruta="../../";
include_once($ruta."class/actividadreserva.php");
$actividadreserva=new actividadreserva;
extract($_POST);
session_start();

	 $ah=$actividadreserva->mostrarTodo("idestudiante=".$idestudiante." and idactividadhabil=".$idactividadhabil);


if(count($ah)>0)
{
	?>
	<script  type="text/javascript">
		swal("Error!", "alumno ya se encuantra reservado en la actividad", "error")
		</script>
	<?php	
}else{
	$valores=array(
		     "idestudiante"=>"'$idestudiante'",
		     "idactividadhabil"=>"'$idactividadhabil'",
		     "estado"=>"'1'"
			);	
			if($actividadreserva->insertar($valores))
			{
				?>
					<script  type="text/javascript">
						swal({
				              title: "Exito !!!",
				              text: "Se reservo correctamente",
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
			}else{
				?>
				<script type="text/javascript">
					Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
				</script>
				<?php
			}
}

	

?>

