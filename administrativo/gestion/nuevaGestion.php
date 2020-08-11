<?php 
	$ruta="../../";
	include_once($ruta."class/admgestion.php");
	$admgestion=new admgestion;
	extract($_POST);
	session_start();
	$dgestion=$admgestion->mostrarUltimo("");
	$valores=array(
	     "anio"=>$dgestion['anio']+1,
	     "estado"=>"'0'"
	);	
	if($admgestion->insertar($valores))
	{
		?>
			<script  type="text/javascript">
				swal({
		              title: "Exito !!!",
		              text: "Se creo la gestion correctamente",
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