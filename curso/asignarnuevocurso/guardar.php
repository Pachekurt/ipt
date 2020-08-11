<?php 
	$ruta="../../";
	include_once($ruta."class/estudiantecurso.php");
	$estudiantecurso=new estudiantecurso;
	extract($_POST);
	session_start();

	$valores=array(
	     "idestudiante"=>"'$idestudiante'",
	     "idcurso"=>"'$idcurso'",
	     "estado"=>"'1'"
	);	

foreach($estudiantecurso->mostrarTodo("idestudiante=".$idestudiante." and estado =1") as $ec)
		{
			$valores=array("estado"=>"'0'"
			               );
			if ($estudiantecurso->actualizar($valores,$ec['idestudiantecurso']))
			{}
		}

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