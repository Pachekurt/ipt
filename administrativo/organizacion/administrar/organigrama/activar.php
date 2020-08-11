<?php 
	$ruta="../../../../";
	include_once($ruta."class/admorgani.php");
	$admorgani=new admorgani;
	include_once($ruta."class/admsemana.php");
	$admsemana=new admsemana;
	extract($_POST);
	session_start();

	$dsem=$admsemana->mostrarUltimo("estado=1");
	$idsemana=$dsem['idadmsemana'];

	$valores=array(
		"idadmsemana"=>"'$idsemana'",
	    "estado"=>"'1'"
	);	
	if($admorgani->actualizar($valores,$id))
	{
		?>
			<script  type="text/javascript">
				swal({
		              title: "Exito !!!",
		              text: "Organigrama Activada Correctamente",
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
			Materialize.toast('<span>No se pudo generar el registro</span>', 1500);
		</script>
		<?php
	}
?>