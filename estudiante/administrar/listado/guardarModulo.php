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
	     "detalle"=>"'SE CAMBIO AL ESTUDIANTE AL MODULO $idmodulo'",
	     "idejecutivoDetalla"=>"'$idejecutivo'",
	     "tipo"=>"'academico'",
	     "estado"=>"'153'"
	);	

		$valoresestudiante=array(
	     "idmodulo"=>"'$idmodulo'" 
		);	
if ($estudiante->actualizar($valoresestudiante,$idestudianteSel)) {


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