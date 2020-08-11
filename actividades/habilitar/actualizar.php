<?php 
	$ruta="../../";
	include_once($ruta."class/actividadhabil.php");
	$actividadhabil=new actividadhabil;
	include_once($ruta."class/usuario.php");
	$usuario=new usuario;
	extract($_POST);
	session_start();
	$idusuario=$_SESSION["codusuario"];
	$us=$usuario->mostrar($idusuario);
    $us=array_shift($us);
    $idsede=$us['idsede'];

	$ah=$actividadhabil->mostrarTodo("idactividades=".$idactividad." and horainicio=".$idhorainicio." and idejecutivo=".$idejecutivo." and duracion=".$idduracion);


if(count($ah)>0)
{
	?>
	<script  type="text/javascript">
		swal("Error!", "No puede registrar, ya se encuantra registrado", "warning")
		</script>
	<?php	
}else{
	$valores=array(
	     "idactividades"=>"'$idactividad'",
	     //"idsede"=>"'$idsede'",
	     "idejecutivo"=>"'$idejecutivo'",
	     "fecha"=>"'$idfecha'",
	     "duracion"=>"'$idduracion'",
	     "horainicio"=>"'$idhorainicio'"
	     //"idsede"=>"'$idsede'"
	);	
	if($actividadhabil->actualizar($valores,$idactividadhabil))
	{
		?>
			<script  type="text/javascript">
			$('#btnSave').attr("disabled",true);
				swal({
		              title: "Exito !!!",
		              text: "Datos Actualizados Correctamente",
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