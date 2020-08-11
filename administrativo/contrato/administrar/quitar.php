<?php
	$ruta="../../../";
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
    /*********** actualiza contrato  ***********/
    $valores=array(
	     "eshabil"=>"'0'"
	);
	if ($admcontrato->actualizar($valores,$idcontrato)) {
		?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Operacion Realizada Correctamente",
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
	}else{
		?>
		<script type="text/javascript">
			Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
		</script>
		<?php		
	}
    
?>