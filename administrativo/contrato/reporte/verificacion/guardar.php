<?php
	$ruta="../../../../";
	include_once($ruta."class/admcontratodelle.php");
  	$admcontratodelle=new admcontratodelle;
	session_start();
	extract($_POST);
    /*********** actualiza contrato ************/
    $valores=array(
    	"horadep"=>"'$hora'",
    	"consolidado"=>"'1'",
    	"detalle"=>"'$obs'"
	);
	$admcontratodelle->actualizar($valores,$id);
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