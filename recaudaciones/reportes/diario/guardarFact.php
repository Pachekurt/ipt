<?php
	$ruta="../../../";
	include_once($ruta."class/factura.php");
	$factura=new factura;
	session_start();
	extract($_POST);
    /*********** actualiza contrato ************/
    $valores=array(
    	"fechadep"=>"'$fecha'",
    	"horadep"=>"'$hora'",
    	"consolidado"=>"'1'",
    	"obs"=>"'$obs'"
	);
	$factura->actualizar($valores,$id);
	/*******************************************/
    ?>
		<script  type="text/javascript">
			swal({
				title: "Exito !!!",
				text: "Registro Validado Correctamente",
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