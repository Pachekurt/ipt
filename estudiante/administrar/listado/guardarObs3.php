<?php 
	$ruta="../../../";
	include_once($ruta."class/observacion.php");
	$observacion=new observacion;
	include_once($ruta."class/estudiante.php");
	$estudiante=new estudiante;
	extract($_POST);
	session_start();

	$valores=array(
	     "idestudiante"=>"'$idestudianteSel'",
	     "detalle"=>"'$iddescripcion2'",
	     "idejecutivoDetalla"=>"'$idejecutivo'",
	     "tipo"=>"'academico'",
	     "estado"=>"'148'"
	);	

		$valoresestudiante=array(
	     "estadoacademico"=>"'148'" ,
	     "estado"=>"'1'" ,
	     "estadocontrato"=>"'142'" 
		);	
if ($estudiante->actualizar($valoresestudiante,$idestudianteSel)) {


			//$consulta="update estudiantecurso set estado =1 where idestudiante =$idestudianteSel";

			//$resultado=$estudiante->sql($consulta);
			//$resultado=array_shift($resultado);
					if($observacion->insertar($valores))
							{
								?>
									<script  type="text/javascript">
									$('#btnSave').attr("disabled",true);
										swal({
								              title: "Exito !!!",
								              text: "Se registro la observación correctamente",
								              type: "success",
								              //showCancelButton: false,
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
									Materialize.toast('<span>No se pudo guardar la observacion</span>', 1500);
								</script>
								<?php
							}
}
else
{

	?>
		<script type="text/javascript">
			Materialize.toast('<span>No se pudo cambiar el estado</span>', 1500);
		</script>
		<?php
}

	
?>