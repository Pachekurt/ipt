<?php 
	$ruta="../../";
	include_once($ruta."class/curso.php");
	$curso=new curso;
	include_once($ruta."class/usuario.php");
	$usuario=new usuario;
	extract($_POST);
	session_start();
	$idusuario=$_SESSION["codusuario"];
	$us=$usuario->mostrar($idusuario);
    $us=array_shift($us);
    $idsede=$us['idsede'];

	$cu=$curso->mostrarTodo("iddocente=".$iddocente." and idmodulo=".$idmodulo." and horainicio= '$idhoraini' and horafin='$idhorafin' and fechainicio='$idfechaini' and fechafin='$idfechafin'");
	$cu=array_shift($cu);

if(count($cu)>0)
{
	?>
	<script  type="text/javascript">
		swal("Error!", "No puede registrar, ya se encuantra registrado", "warning")
		</script>
	<?php	
}else{
	$valores=array(
	     "idejecutivo"=>"'$idejecutivoInport'",
	     "idsede"=>"'$idsede'",
	     "idmodulo"=>"'$idmodulo'",
	     "idhorario"=>"'$idhorario'",
	     "fechainicio"=>"'$idfechaini'",
	     "fechafin"=>"'$idfechafin'",
	     "descripcion"=>"'$iddesc'"
	);	
	if($curso->insertar($valores))
	{
		?>
			<script  type="text/javascript">
			$('#btnSave').attr("disabled",true);
				swal({
		              title: "Exito !!!",
		              text: "Datos Registrados Correctamente",
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
}

	

?>