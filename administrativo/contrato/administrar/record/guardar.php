<?php
	$ruta="../../../../";
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	include_once($ruta."class/admcontratodelle.php");
	$admcontratodelle=new admcontratodelle;
	include_once($ruta."class/vorganizacion.php");
	$vorganizacion=new vorganizacion;
	include_once($ruta."class/vejecutivo.php");
	$vejecutivo=new vejecutivo;
	include_once($ruta."class/vtitular.php");
	$vtitular=new vtitular;
	include_once($ruta."class/admorgani.php");
	$admorgani=new admorgani;
	include_once($ruta."class/admsemana.php");
	$admsemana=new admsemana;
	include_once($ruta."class/sede.php");
	$sede=new sede;
	include_once($ruta."class/admsucursal.php");
	$admsucursal=new admsucursal;
	include_once($ruta."class/admdosificacion.php");
	$admdosificacion=new admdosificacion;
	include_once($ruta."class/factura.php");
	$factura=new factura;
	include_once($ruta."class/facturadet.php");
	$facturadet=new facturadet;
	include_once($ruta."class/vcontratoplan.php");
	$vcontratoplan=new vcontratoplan;
	include_once($ruta."class/personaplan.php");
	$personaplan=new personaplan;
	include_once($ruta."class/ctbdia.php");
	$ctbdia=new ctbdia;
	require_once($ruta."funciones/codigo.php");
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
	$fecha=date("Y-m-d");
	$hora=date("H:i");
    /*********** actualiza contrato  ***********/
    $dcontrato=$admcontrato->muestra($idcontrato);
    if ($idmontoSus>0) {
	    $dct=$ctbdia->mostrarUltimo("estado=1");
	    $tc=number_format($dct['dolar'], 2, '.', '');
	    $dolBol=$idmontoSus*$tc;
	    $bolivianos=number_format($idmonto, 2, '.', '');
	    $idmonto=number_format($dolBol, 2, '.', '')+number_format($idmonto, 2, '.', '');
	}
	else
	{
	    $bolivianos=$idmonto;
	}
	echo "MONTO 1: ".$idmonto."\n";


    if ($dcontrato['idpersonaplan']==0) {
    	$datospp=$personaplan->mostrarUltimo("idcontrato=$idcontrato");
		$idpersonaplan=$datospp['idpersonaplan'];
		$valores=array(
			"idpersonaplan"=>"'$idpersonaplan'"
		);
		$admcontrato->actualizar($valores,$idcontrato);
		$dcontrato=$admcontrato->muestra($idcontrato);
    }
    $dcp=$vcontratoplan->muestra($idcontrato);
    $dsede=$sede->muestra($_SESSION["idsede"]);
    $record=$dsede['ult_record']+1;
    $valores=array(
	    "ult_record"=>"'$record'"
	);
	$sede->actualizar($valores,$dsede['idsede']);

    $dejec=$vejecutivo->muestra($dcontrato['idadmejecutivo']);
    $dtit=$vtitular->muestra($dcontrato['idtitular']);
  	$dorg=$admorgani->mostrarUltimo("idadmorganizacion=".$dejec['idorganizacion']." and estado=1");
  	$nuevoSaldo=$dcontrato['abono']-$idmonto;
  	$nuevoPagado=$dcontrato['pagado']+$idmonto;


  	$saldoCartera=$dcp['inversion']-$nuevoPagado;
  	if ($saldoCartera<0){
  		//ACA CORREGIR PARA EL RECORD e

  		$saldoCartera=0;
  	}
  	$dsemana=$admsemana->mostrarUltimo("estado=1");
	$idsemanaHoy=$dsemana['idadmsemana'];
  	if ($nuevoSaldo<=0) {
  		$nuevoestado=63;
  		//en caso de pasar a reportado cambia el organigrama
  		$idorganigrama=$dorg['idadmorgani'];
  		$idsemana=$idsemanaHoy;
  		$nuevoSaldo=0;
  	}else{
  		// no cambia de estado o no pago la totalidad de la cuota inicial
  		$nuevoestado=62;
  		$idorganigrama=$dcontrato['idorganigrama'];
  		$idsemana=$dcontrato['idadmsemana'];
  	}
    $valores=array(
		"estado"=>"'$nuevoestado'",
		"abono"=>"'$nuevoSaldo'",
		"idadmsemana"=>"'$idsemana'",
		"idorganigrama"=>"'$idorganigrama'",
		"pagado"=>"'$nuevoPagado'",
		"fechaestado"=>"'$fecha'"
	);
	if ($admcontrato->actualizar($valores,$idcontrato)) {

		$abono=number_format($dcontrato['abono'], 2, '.', '');
		$pagado=number_format($dcontrato['pagado'], 2, '.', '');
		$inversion=number_format($dcp['inversion'], 2, '.', '');

		/*******************************************/
		/******** inserta contrato detalle *********/
		if ($idmontoSus>0) {
			$nuevoSaldo=number_format($dcontrato['abono'], 2, '.', '')-number_format($bolivianos, 2, '.', '');
		  	$nuevoPagado=number_format($dcontrato['pagado'], 2, '.', '')+number_format($bolivianos, 2, '.', '');
		  	$saldoCartera=number_format($dcp['inversion'], 2, '.', '')-number_format($nuevoPagado, 2, '.', '');
			if ($bolivianos>0) {
				
				$nuevoSaldo=number_format($abono, 2, '.', '')-number_format($bolivianos, 2, '.', '');
			  	$nuevoPagado=number_format($pagado, 2, '.', '')+number_format($bolivianos, 2, '.', '');
			  	$saldoCartera=number_format($inversion, 2, '.', '')-number_format($nuevoPagado, 2, '.', '');

				$moneda="BS";
				$bolivianos=number_format($bolivianos, 2, '.', '');
				$valores2=array(
					"idcontrato"=>$idcontrato,
					"record"=>"'$record'",
					"idorganigrama"=>"'$idorganigrama'",
					"fecha"=>"'$fecha'",
					"hora"=>"'$hora'",
					"moneda"=>"'$moneda'",
					"monto"=>"'$bolivianos'",
					"saldo"=>"'$nuevoSaldo'",
					"saldocartera"=>"'$saldoCartera'",
					"tiopago"=>"'$tpago'",
					"referencia"=>"'$idref'",
					"lote"=>"'$idlote'",
					"detalle"=>"'$idobs'",
					"estado"=>"'$nuevoestado'",
					"codigo"=>"'3113'"
				);
				$admcontratodelle->insertar($valores2);
				$dContDet=$admcontratodelle->mostrarUltimo("monto=$bolivianos and idcontrato=$idcontrato");
				$idcontdet1=$dContDet['idadmcontratodelle'];
				$lblcodeRec=ecUrl($idcontdet1);

				$abono=$nuevoSaldo;
				$pagado=$nuevoPagado;
			}
			
			$nuevoSaldo=number_format($abono, 2, '.', '')-number_format($dolBol, 2, '.', '');
		  	$nuevoPagado=number_format($pagado, 2, '.', '')+number_format($dolBol, 2, '.', '');
		  	$saldoCartera=number_format($inversion, 2, '.', '')-number_format($nuevoPagado, 2, '.', '');


			$moneda="SUS";
			$dolBol=number_format($dolBol, 2, '.', '');
			$valores2=array(
				"idcontrato"=>$idcontrato,
				"record"=>"'$record'",
				"idorganigrama"=>"'$idorganigrama'",
				"fecha"=>"'$fecha'",
				"hora"=>"'$hora'",
				"moneda"=>"'$moneda'",
				"monto"=>"'$dolBol'",
				"saldo"=>"'$nuevoSaldo'",
				"saldocartera"=>"'$saldoCartera'",
				"tiopago"=>"'$tpago'",
				"referencia"=>"'$idref'",
				"lote"=>"'$idlote'",
				"detalle"=>"'$idobs'",
				"estado"=>"'$nuevoestado'",
				"codigo"=>"'3113'"
			);
			$admcontratodelle->insertar($valores2);
			$dContDet=$admcontratodelle->mostrarUltimo("monto=$dolBol and idcontrato=$idcontrato");
			if ($bolivianos>0) {
				$idcontdet2=$dContDet['idadmcontratodelle'];
				$lblcodeRec=ecUrl($idcontdet2);
			}
			else{
				$idcontdet1=$dContDet['idadmcontratodelle'];
				$lblcodeRec=ecUrl($idcontdet1);
			}

		}
		else{
			$moneda="BS";
			$idmonto=number_format($idmonto, 2, '.', '');
			$valores2=array(
				"idcontrato"=>$idcontrato,
				"record"=>"'$record'",
				"idorganigrama"=>"'$idorganigrama'",
				"fecha"=>"'$fecha'",
				"hora"=>"'$hora'",
				"moneda"=>"'$moneda'",
				"monto"=>"'$idmonto'",
				"saldo"=>"'$nuevoSaldo'",
				"saldocartera"=>"'$saldoCartera'",
				"tiopago"=>"'$tpago'",
				"referencia"=>"'$idref'",
				"lote"=>"'$idlote'",
				"detalle"=>"'$idobs'",
				"estado"=>"'$nuevoestado'",
				"codigo"=>"'3113'"
			);
			$admcontratodelle->insertar($valores2);
			$dContDet=$admcontratodelle->mostrarUltimo("monto=$idmonto and idcontrato=$idcontrato");
			$idcontdet1=$dContDet['idadmcontratodelle'];
			$lblcodeRec=ecUrl($idcontdet1);
		}
			
			/***************************** PREPARA DATOS PARA FACTURA ******************************/
			
		    $dsuc=$admsucursal->mostrarUltimo("idsede=".$_SESSION["idsede"]." and estado=1");
		    $idsucursal=$dsuc['idadmsucursal'];
		    $ddos=$admdosificacion->mostrarUltimo("idadmsucursal=".$idsucursal." and estado=1");
		    $iddosificacion=$ddos['idadmdosificacion'];
		    $nro=$ddos['nro'];
		    $idtabla=$idcontdet1;
		    $tipotabla="RECO";

		    $matricula=$dsede['prefijo']."-".$dcontrato['nrocontrato'];
		    $total=$idmonto;
		    /**************************************************************************************************/
		    $numAut=$ddos['autorizacion'];
		    $numFactura=$nro;

		    $nitCli=$dtit['nit'];
		    $razonCli=$dtit['razon'];

		    $fTransaccion=$fecha;
		    $date = date_create($fTransaccion);
		    $fTransaccion=date_format($date, 'Y-m-d');
		    $fTransaccion=str_replace("-", "", $fTransaccion);
		    
		    $llave=$ddos['llave'];
		    // datos antes de ingresar a facturacion
		    //echo "\n"."numAut-> ".$numAut."\n";
		    //echo "numFactura-> ".$numFactura."\n";
		    //echo "nitCli-> ".$nitCli."\n";
		    //echo "fTransaccion-> ".$fTransaccion."\n";
		    //echo "monto-> ".round($idmonto)."\n";
		    //echo "llave-> ".$llave."\n";
		    /********************************* GENERANDO CODIGO DE CONTROL ***********************************/
		    $clsControl = new CodigoControl($numAut,$numFactura,$nitCli,$fTransaccion,round($idmonto),$llave);
		    $codigoControl = $clsControl->generar();
		    /*************************************************************************************************/
		    $impresion="0";
		    $estado="1";
		    $idmonto=number_format($idmonto, 2, '.', '');
		    // se debera insertar factura maestro
		    $val3=array(
		      "idsucursal"=>"'$idsucursal'",
		      "iddosificacion"=>"'$iddosificacion'",
		      "idtabla"=>"'$idtabla'",
		      "tipotabla"=>"'$tipotabla'",
		      "nro"=>"'$numFactura'",
		      "fecha"=>"'$fecha'",
		      "matricula"=>"'$matricula'",
		      "nit"=>"'$nitCli'",
		      "razon"=>"'$razonCli'",
		      "total"=>"'$idmonto'",
		      "saldo"=>"'$saldoCartera'",
		      "control"=>"'$codigoControl'",
		      "impresion"=>"'$impresion'",
		      "estado"=>"'$estado'",
		    );
		    if($factura->insertar($val3)){
				//actualiza numero de factura
				$valFactura=array(
				"nro"=>$numFactura+1
				);  
				$admdosificacion->actualizar($valFactura,$iddosificacion);

				/*******************************************************************************/
				$fdet=$factura->mostrarUltimo("idtabla=$idtabla and tipotabla='".$tipotabla."'");
				$idfactura=$fdet['idfactura'];
				//// actualiaza detalle 
				$valFactura=array(
				"idfactura"=>$idfactura
				);  
				$admcontratodelle->actualizar($valFactura,$idcontdet1);
				$admcontratodelle->actualizar($valFactura,$idcontdet2);

				/************************************************************/
				$detalle="Pago ".ordinal(1)." Mensualidad ";
				$cantidad=1;
				$precio=$idmonto;
				$estado=1;
				// inserta detalle factura y devuelve id factura
				$val4=array(
				"idfactura"=>"'$idfactura'",
				"detalle"=>"'$detalle'",
				"cantidad"=>"'$cantidad'",
				"precio"=>"'$precio'",
				"estado"=>"'$estado'"
				);
				if($facturadet->insertar($val4)){
			        // actualiza carteradetalle con el id factura generada
			        $lblcode=ecUrl($idfactura);

			        /***********************************************************************************************/
					?>
						<script  type="text/javascript">
					        swal({
				              title: "Factura: "+"<?php echo $numFactura ?>",
				              text: "Selecciona el modo de impresion de la factura",
				              type: "warning",
				              showCancelButton: true,
				              confirmButtonColor: "#16c103",
				              confirmButtonText: "Computarizada",
				              cancelButtonText: "P.O.S.",
				              confirmButtonClass: 'btn green',
				              cancelButtonClass: 'btn red',
				              closeOnConfirm: false,
				              closeOnCancel: false
				            },
				            function(isConfirm){
				              if (isConfirm) {
				                location.reload();
				                window.open("imprimir/?lblcode=<?php echo $lblcodeRec ?>","_blank");
				                window.open("<?php echo $ruta ?>factura/impresion/computarizada/?lblcode=<?php echo $lblcode ?>","_blank");
				              } else {
				                location.reload();
				                window.open("imprimir/?lblcode=<?php echo $lblcodeRec ?>","_blank");
				              }
				            });
						</script>
					<?php
					}
				    else{
				      ?>
				        <script type="text/javascript">
				          setTimeout(function() {
				            Materialize.toast('<span>4 Factura No se pudo realizar el registro</span>', 1500);
				          }, 10);
				        </script>
				      <?php
				    }
			}
		    else{
		      ?>
		        <script type="text/javascript">
		          setTimeout(function() {
		            Materialize.toast('<span>3 Factura No se pudo realizar el registro</span>', 1500);
		          }, 10);
		        </script>
		      <?php
		    }
		    
		
	}else{
		?>
		<script type="text/javascript">
			Materialize.toast('<span>1 No se pudo guardar el registro</span>', 1500);
		</script>
		<?php		
	}
    
?>