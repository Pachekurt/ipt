<?php 
	$ruta="../../";
	include_once($ruta."class/curso.php");
	$curso=new curso;
	extract($_POST);
	session_start();

	$valores=array(
	     "idejecutivo"=>"'$idejecutivoInport'"
	);	
	if($curso->actualizar($valores,$idcurso))
	{
		?>
			<script  type="text/javascript">
			$('#btnSave').attr("disabled",true);
				swal({
		              title: "Exito !!!",
		              text: "Cambio realizado correctamente",
		              type: "success",
		              showCancelButton: false,
		              confirmButtonColor: "#28e29e",
		              confirmButtonText: "OK",
		              closeOnConfirm: false
		          }, function () {      
		           location.href = "index.php";
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


?>