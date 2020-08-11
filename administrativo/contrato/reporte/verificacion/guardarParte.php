<?php
	$ruta="../../../../";
	include_once($ruta."class/admcontratodelle.php");
	$admcontratodelle=new admcontratodelle;
	include_once($ruta."class/sede.php");
	$sede=new sede;
	session_start();
	extract($_POST);
    /*********** actualiza contrato ************/
    $codigo="110-1-";
    //Programar para cada sede
	// implementar por sedes
	$dmov=$admcontratodelle->mostrarTodo("codigo=3113 and consolidado<1 and fecha='$fechaGen'");
	echo count($dmov);
	if (count($dmov)>0) {
		?>
			<script  type="text/javascript">
 				swal('Error','Aun Hay Registros si confirmar', 'error');
			</script>
		<?php
	}
	else{
		$dsede=$sede->muestra($_SESSION["idsede"]);
		$numeracion=$dsede['ult_record'];
		//actualozamos contrato detalle con los codigos asignados a cada transaccion
		foreach($admcontratodelle->mostrarTodo("consolidado<2 and tiopago=1 and fecha='$fechaGen'","horadep") as $f)
	    {
	    	$numeracion++;
	    	$valores=array(
		    	"cod"=>"'$codigo'",
		    	"nro"=>"'$numeracion'",
		    	"consolidado"=>"'2'"
			);
			$admcontratodelle->actualizar($valores,$f['idadmcontratodelle']);
	    }
	    //actualizamos contratos depositados con tarjeta.
	    foreach($admcontratodelle->mostrarTodo("consolidado<2 and tiopago>1 and fecha='$fechaGen'","horadep") as $f)
	    {
	    	$numeracion++;
	    	$valores=array(
				"cod"=>"'$codigo'",
				"nro"=>"'$numeracion'",
				"consolidado"=>"'2'"
			);
			$admcontratodelle->actualizar($valores,$f['idadmcontratodelle']);
	    }
    	$valores=array(
	    	"ult_record"=>"'$numeracion'"
		);
		$sede->actualizar($valores,$dsede['idsede']);
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