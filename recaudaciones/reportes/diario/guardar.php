<?php
	$ruta="../../../";
	include_once($ruta."class/cobcarteradet.php");
	$cobcarteradet=new cobcarteradet;
	session_start();
	extract($_POST);
	$dcdet=$cobcarteradet->muestra($id);
    /*********** actualiza contrato ************/
    $valores=array(
    	"fechadep"=>"'$fecha'",
    	"horadep"=>"'$hora'",
    	"consolidado"=>"'1'",
    	"obs"=>"'$obs'"
	);
	$cobcarteradet->actualizar($valores,$id);
	/*******************************************/
    ?>
		<script  type="text/javascript">
			swal({
				title: "Exito !!!",
				text: "Validado Correctamente",
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