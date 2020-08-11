<?php
	$ruta="../../../";
	include_once($ruta."class/cobcarteradet.php");
	$cobcarteradet=new cobcarteradet;
	include_once($ruta."class/sede.php");
	$sede=new sede;
	include_once($ruta."class/vcarteradet.php");
  	$vcarteradet=new vcarteradet;
  	include_once($ruta."class/vfactura.php");
  	$vfactura=new vfactura;
	include_once($ruta."class/factura.php");
	$factura=new factura;

	include_once($ruta."funciones/funciones.php");
	session_start();
	extract($_POST);
	
	$idsede=$_SESSION["idsede"];
  	$dse=$sede->muestra($idsede);
	$lblcode=ecUrl($idsede);
	
    /*********** actualiza contrato ************/
	// implementar por sedes
	$dmov=$vcarteradet->mostrarTodo("consolidado<1 and idsede=$idsede and fecha='$fechaGen'");
	$dfact=$vfactura->mostrarTodo("tipotabla='SERV. AD.' and idsede=$idsede and consolidado<1 and estado=1 and fecha='$fechaGen'");
	
	$cantidad=count($dmov)+count($dfact);
	if ($cantidad>0) {
		?>
			<script  type="text/javascript">
				swal(
			      'Error',
			      'Aun Hay Registros si confirmar',
			      'error'
			    );
			</script>
		<?php
	}
	else{
		/***************************** consolida cartera pago con efectivo ******************/
		foreach($vcarteradet->mostrarTodo("consolidado=1 and idsede=$idsede and tipopago=1 and fecha='$fechaGen'","horadep") as $f)
	    {
	    	$valores=array(
		    	"consolidado"=>"'2'"
			);
			$cobcarteradet->actualizar($valores,$f['idvcarteradet']);
	    }
	    /****************************** consolida cartera pago por tarjeta  *********************************************************/
	    foreach($vcarteradet->mostrarTodo("consolidado=1 and idsede=$idsede and tipopago>1 and fecha='$fechaGen'","horadep") as $f)
	    {
	    	$valores=array(
		    	"consolidado"=>"'2'"
			);
			$cobcarteradet->actualizar($valores,$f['idvcarteradet']);
	    }
	    /***********************************  consolida factura  ***************************************************************/
	    foreach($vfactura->mostrarTodo("tipotabla='SERV. AD.' and idsede=$idsede and consolidado<2 and estado=1 and fecha='$fechaGen'","nro") as $f)
	    {
	    	$valores=array(
		    	"consolidado"=>"'2'"
			);
			$factura->actualizar($valores,$f['idvfactura']);
	    }
		?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Guardado Correctamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#28e29e",
					confirmButtonText: "IMPRIMIR PARTE",
					closeOnConfirm: false
				}, function () {
					fecha="<?php echo $fechaGen ?>";
					lblcode="<?php echo $lblcode ?>";
					window.open("imprimir/?fechaGen="+fecha+"&lblcode="+lblcode,"_blank");
					location.reload();
				});
			</script>
		<?php
	}
?>