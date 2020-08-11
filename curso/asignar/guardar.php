<?php 
	$ruta="../../";
	include_once($ruta."class/estudiantecurso.php");
	$estudiantecurso=new estudiantecurso;
	include_once($ruta."class/estudiante.php");
	$estudiante=new estudiante;
	extract($_POST);
	session_start();

	$valores=array(
	     "idestudiante"=>"'$idestudiante'",
	     "idcurso"=>"'$idcurso'",
	     "estado"=>"'1'"
	);	
	$valores2=array(
	     "estadoacademico"=>"'148'", 
	);	
	$estudiante->actualizar($valores2,$idestudiante);
	if($estudiantecurso->insertar($valores))
	{
		?>
			<script  type="text/javascript">
				swal({
		              title: "Exito !!!",
		              text: "Se asigno correctamente",
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