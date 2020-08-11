<?php
	$ruta="../../../";
	include_once($ruta."class/admjerarquia.php");
	$admjerarquia=new admjerarquia;
	include_once($ruta."class/admejecutivo.php");
	$admejecutivo=new admejecutivo;
	extract($_POST);
	$deje=$admejecutivo->muestra($idejecutivo);
	$djer=$admjerarquia->muestra($deje['idcargo']);
    $valores2=array(
		"idcargo"=>$djer['padre']
	);	
	$admejecutivo->actualizar($valores2,$idejecutivo);
    ?>
		<script  type="text/javascript">
			swal({
				title: "Exito !!!",
				text: "Ejecutivo Ascendido Correctamente",
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
?>