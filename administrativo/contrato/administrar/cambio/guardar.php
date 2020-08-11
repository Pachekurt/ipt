<?php
	$ruta="../../../../";
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	include_once($ruta."class/vtitular.php");
	$vtitular=new vtitular;
	include_once($ruta."class/admcontratodelle.php");
	$admcontratodelle=new admcontratodelle;
	include_once($ruta."class/personaplan.php");
	$personaplan=new personaplan;
	include_once($ruta."class/admplan.php");
	$admplan=new admplan;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
	$dconta=$admcontrato->muestra($idcontrato);// data anterior
	$nroConta=$dconta['nrocontrato'];

	$dtitular=$vtitular->muestra($dconta['idtitular']);// datos del titular

	$dcontd=$admcontrato->muestra($idcontratoNuevo);// data nuevo
	$nroContd=$dcontd['nrocontrato'];

    //***** PASOS PARA CAMBIO DE CONTRATO *****//
    //1. Generar un movimiento de traspaso en el contrato actual
	    $fecha=date("Y-m-d");
		$hora=date("H:i:s");
		$valores2=array(
			"idcontrato"=>$idcontrato,
			"fecha"=>"'$fecha'",
			"hora"=>"'$hora'",
			"detalle"=>"'CAMBIO DE CONTRATO AL $nroContd '",
			"estado"=>$dconta['estado'],
			"codigo"=>"'3121'"
		);
		$admcontratodelle->insertar($valores2);
    //2. Anular el contrato generando un movimiento de devolucion de contratos anulados
		$valores=array(
		     "estado"=>"'64'"
		);
		$admcontrato->actualizar($valores,$idcontrato);
		$valores2=array(
		     "idcontrato"=>$idcontrato,
		     "fecha"=>"'$fecha'",
		     "hora"=>"'$hora'",
		     "detalle"=>"'ANULACION POR CAMBIO DE CONTRATO  AL $nroContd'",
		     "estado"=>"'64'",
		     "codigo"=>"'3115'"
		);	
		$admcontratodelle->insertar($valores2);
    //3. Copiar todos los datos del anterior contrato al nuevo contrato
		$valores=array(
			"cuenta"=>"'".$dconta['cuenta']."'",
			"idadmsemana"=>"'".$dconta['idadmsemana']."'",
			"idtitular"=>"'".$dconta['idtitular']."'",
			"idorganigrama"=>"'".$dconta['idorganigrama']."'",
			"abono"=>"'".$dconta['abono']."'",
		    "estado"=>$dconta['estado'],
		    "fechaestado"=>"'".$dconta['fechaestado']."'"
		);
		$admcontrato->actualizar($valores,$idcontratoNuevo);
    //4. generar un movimiento de traspaso en el nuevo contrato
		$valores2=array(
			"idcontrato"=>$idcontratoNuevo,
			"fecha"=>"'$fecha'",
			"hora"=>"'$hora'",
			"detalle"=>"'CAMBIO DE CONTRATO DEL $nroConta - $idobs '",
			"estado"=>$dconta['estado'],
			"codigo"=>"'3121'"
		);
		$admcontratodelle->insertar($valores2);
	//5. Generar el registro en persona plan
        $dplan=$admplan->muestra($idplan);
        $valores=array(
			"abono"=>$dplan['pagoinicial']
		);
		$admcontrato->actualizar($valores,$idcontratoNuevo);
	    $valores=array(
			"idpersona"=>"'".$dtitular['idpersona']."'",
		    "idtitular"=>"'".$dtitular['idtitular']."'",
			"idadmplan"=>"'".$idplan."'",
			"idcontrato"=>"'".$idcontratoNuevo."'",
			"observacion"=>"'".$idobs."'",
			"estado"=>"'0'"
		);
		$personaplan->insertar($valores);
		$datospp=$personaplan->mostrarUltimo("idcontrato=$idcontratoNuevo");
  		$idpersonaplan=$datospp['idpersonaplan'];

    //6. Copiar los registro de asignacion de titular Y abonos en el nuevo contrato
		foreach($admcontratodelle->mostrarTodo("idcontrato=$idcontrato") as $f){
			if ($f['codigo']==3112){
				$valores2=array(
					"idcontrato"=>$idcontratoNuevo,
					"idorganigrama"=>"'".$f['codigo']."'",
					"idtitular"=>"'".$f['idtitular']."'",
					"idsemana"=>"'".$f['idsemana']."'",
					"fecha"=>"'".$f['fecha']."'",
					"hora"=>"'".$f['hora']."'",
					"monto"=>"'".$f['monto']."'",
					"saldo"=>"'".$f['saldo']."'",
					"saldocartera"=>"'".$f['saldocartera']."'",
					"tiopago"=>"'".$f['tiopago']."'",
					"detalle"=>"'".$f['detalle']."'",
					"estado"=>"'".$f['estado']."'",
					"codigo"=>$f['codigo']
				);	
				$admcontratodelle->insertar($valores2);
			}
			elseif ($f['codigo']==3113) {// generamos los movimientos de record de produccion
				$dcontSiclo=$admcontrato->muestra($idcontratoNuevo);
				$nuevoSaldo=$dcontSiclo['abono']-$f['monto'];
  				$nuevoPagado=$dcontSiclo['pagado']+$f['monto'];
  				$valores=array(
					"abono"=>"'$nuevoSaldo'",
					"pagado"=>"'$nuevoPagado'"
				);
				$admcontrato->actualizar($valores,$idcontratoNuevo);
				$valores2=array(
					"idcontrato"=>$idcontratoNuevo,
					"idorganigrama"=>"'".$f['codigo']."'",
					"idtitular"=>"'".$f['idtitular']."'",
					"idsemana"=>"'".$f['idsemana']."'",
					"idfactura"=>"'".$f['idfactura']."'",
					"fecha"=>"'".$f['fecha']."'",
					"hora"=>"'".$f['hora']."'",
					"monto"=>"'".$f['monto']."'",
					"saldo"=>"'".$nuevoSaldo."'",
					"tiopago"=>"'".$f['tiopago']."'",
					"referencia"=>"'".$f['referencia']."'",
					"lote"=>"'".$f['lote']."'",
					"detalle"=>"'".$f['detalle']."'",
					"estado"=>"'".$f['estado']."'",
					"codigo"=>$f['codigo']
				);	
				$admcontratodelle->insertar($valores2);
			}
        }
        $dcontNew=$admcontrato->muestra($idcontratoNuevo);
        if ($dcontNew['estado']=63 && $dcontNew['abono']>0) {
        	$valores=array(
				"estado"=>62
			);
			$admcontrato->actualizar($valores,$idcontratoNuevo);
        }
        // actualiza contrato
        $valores=array(
			"idpersonaplan"=>"'$idpersonaplan'"
		);
		$admcontrato->actualizar($valores,$idcontratoNuevo);

        $lblcode=ecUrl($idcontratoNuevo);
		?>
		<script  type="text/javascript">
			swal({
				title: "Exito !!!",
				text: "Cambio de Contrato Generado Correctamente",
				type: "success",
				showCancelButton: false,
				confirmButtonColor: "#28e29e",
				confirmButtonText: "OK",
				closeOnConfirm: false
	        }, function () { 
	        	window.open("../../impresion/historial/?lblcode=<?php echo $lblcode ?>","_blank");
	            location.href="../";
	        });
		</script>