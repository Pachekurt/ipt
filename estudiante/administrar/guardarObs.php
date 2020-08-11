<?php 
	$ruta="../../";
	include_once($ruta."class/observacion.php");
	$observacion=new observacion;
	extract($_POST);
	session_start();

	$valores=array(
	     "idestudiante"=>"'$idestudianteSel'",
	     "detalle"=>"'$iddescripcion'",
	     "idejecutivoDetalla"=>"'$idejecutivo'",
	     "tipo"=>"'admin'",
	     "estado"=>"'0'"
	);	
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
			Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
		</script>
		<?php
	}
?>