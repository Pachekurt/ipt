<?php
	$ruta="../../../../";
	include_once($ruta."class/admcontratodelle.php");
	$admcontratodelle=new admcontratodelle;
	include_once($ruta."class/vcontratodet.php");
	$vcontratodet=new vcontratodet;
	include_once($ruta."class/sede.php");
	$sede=new sede;
	session_start();
	extract($_POST);
	$idsede=$_SESSION["idsede"];
  	$dse=$sede->muestra($idsede);
    /*********** actualiza contrato ************/
	$dmov=$vcontratodet->mostrarTodo("codigo=3113 and anulado=0 and idsede=$idsede and consolidado<1 and fecha='$fechaGen'");
	echo count($dmov);
	if (count($dmov)>0) {
		?>
			<script  type="text/javascript">
 				swal('Error','Aun Hay Registros si confirmar', 'error');
			</script>
		<?php
	}
	else{
		//actualozamos contrato detalle con los codigos asignados a cada transaccion
		foreach($vcontratodet->mostrarTodo("consolidado<2 and anulado=0 and idsede=$idsede and tiopago=1 and fecha='$fechaGen'","horadep") as $f)
	    {
	    	$valores=array(
		    	"consolidado"=>"'2'"
			);
			$admcontratodelle->actualizar($valores,$f['idvcontratodet']);
	    }
	    //actualizamos contratos depositados con tarjeta.
	    foreach($vcontratodet->mostrarTodo("consolidado<2 and anulado=0 and idsede=$idsede and tiopago>1 and fecha='$fechaGen'","horadep") as $f)
	    {
	    	$valores=array(
				"consolidado"=>"'2'"
			);
			$admcontratodelle->actualizar($valores,$f['idvcontratodet']);
	    }
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
	}
	/*******************************************/
?>