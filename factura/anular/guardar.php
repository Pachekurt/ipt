<?php
	$ruta="../../";
	include_once($ruta."class/factura.php");
	$factura=new factura;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
	$fecha=date("Y-m-d");
    $valores=array(
	    "estado"=>2,
	    "fechanul"=>"'$fecha'"
	);
	if ($factura->actualizar($valores,$idfactura)) {
		?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Factura Anulada Correctamente",
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