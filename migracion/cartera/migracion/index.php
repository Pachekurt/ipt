<?php
	$ruta="../../../";
	include_once($ruta."class/migcartera.php");
	$migcartera=new migcartera;
    include_once($ruta."class/migdetalle.php");
    $migdetalle=new migdetalle;
    include_once($ruta."class/cobcartera.php");
    $cobcartera=new cobcartera;
    include_once($ruta."class/cobcarteradet.php");
    $cobcarteradet=new cobcarteradet;
    include_once($ruta."class/admcontrato.php");
    $admcontrato=new admcontrato;
    include_once($ruta."class/admcontratodelle.php");
    $admcontratodelle=new admcontratodelle;
    include_once($ruta."class/personaplan.php");
    $personaplan=new personaplan;
    include_once($ruta."class/admplan.php");
    $admplan=new admplan;
    include_once($ruta."class/vcontratoplan.php");
    $vcontratoplan=new vcontratoplan;
	include_once($ruta."funciones/funciones.php");
	session_start();
    $fecha=date("Y-m-d");
    $hora=date("H:i:s");
    //fase 1 crear admcontrato
    //fase 2 crear admcontrato detalle
    //fase 3 insertar a cartera
    //fase 4 insertar a cartera detalle
    //FASE 1*************************************************
    $i=0;
    foreach($personaplan->mostrarTodo("estado=5") as $f){
        $dmcartera=$migcartera->mostrarUltimo("cuenta=".$f['numcuenta']);
        $idejecutivo=$dmcartera['ejecutivo'];
        //fase1 crear admcontrato
        $idpersonaplan=$f['idpersonaplan'];
        $nrocontrato=$f['numcontrato'];//revisar
        $cuenta=$f['numcuenta'];
        $idtitular=$f['idtitular'];
        $pagado=$dmcartera['pagadoprod'];
        //echo "PAGADO->".$pagado;
        $fechaVence=$dmcartera['fechavence'];
        $saldo=$dmcartera['saldo'];
        $idplan=$dmcartera['idplan'];
        $val2=array(
            "idcontratogen"=>36,
            "idpersonaplan"=>"'$idpersonaplan'",
            "nrocontrato"=>"'$nrocontrato'",
            "cuenta"=>"'$cuenta'",
            "idsede"=>$dmcartera['sede'],
            "idtitular"=>"'$idtitular'",
            "pagado"=>"'$pagado'",
            "cartera"=>"'1'",
            "fechainicio"=>"'$fechaVence'",
            "cartera"=>"'1'",
            "estado"=>"'67'",
            "eshabil"=>"'1'"
        );
        $admcontrato->insertar($val2);
        $dcont=$admcontrato->mostrarUltimo("cuenta=".$cuenta);
        $idcontrato=$dcont['idadmcontrato'];
        /********************************************************/
            // actualizar personaplan
            $valores=array(
                "idcontrato"=>"'$idcontrato'",
                "idadmplan"=>"'$idplan'"
            );
            $personaplan->actualizar($valores,$idpersonaplan);
        /*********************************************************/
        $dcp=$vcontratoplan->muestra($idcontrato);
        $valores2=array(
            "idcontrato"=>$idcontrato,
            "record"=>"'0'",
            "idorganigrama"=>"'0'",
            "idsemana"=>"'0'",
            "fecha"=>"'$fecha'",
            "hora"=>"'$hora'",
            "monto"=>"'$pagado'",
            "saldo"=>"'0'",
            "saldocartera"=>"'0'",
            "tiopago"=>"'1'",
            "referencia"=>"'0'",
            "lote"=>"'0'",
            "detalle"=>"'CUENTAS MIGRADAS DE INFORMACION PROPORCIONADA POR AUDITORIA'",
            "estado"=>"'67'",
            "codigo"=>"'3113'"
        );
        $admcontratodelle->insertar($valores2);
        //fase 3 insertar a cartera
        $valores3=array( 
            "idejecutivo"=>"'$idejecutivo'",
            "idcontrato"=>$idcontrato,
            "idsede"=>$dmcartera['sede'],
            "fechainicio"=>"'".$dmcartera['fechavence']."'",
            "fechavence"=>"'".$dmcartera['fechavence']."'",
            "fechaultpago"=>"'".$dmcartera['fechavence']."'",
            "fechaproxve"=>"'".$dmcartera['fechavence']."'",
            "monto"=>"'".$dcp['inversion']."'",
            "pagadoprod"=>"'".$pagado."'",
            "saldo"=>"'$saldo'",
            "cuotas"=>"'".$dcp['cuotas']."'",
            "diasmora"=>"'0'",
            "estado"=>"'131'"
        );  
        $cobcartera->insertar($valores3);
        $dcart=$cobcartera->mostrarUltimo("idcontrato=".$idcontrato);
        $idcartera=$dcart['idcobcartera'];

        foreach($migdetalle->mostrarTodo("cuenta=".$f['numcuenta']) as $g){                                    
            $descuento=$g['descuento'];
            $moneda=$g['moneda'];
            $fechaPago=$g['fechavence'];
            $saldobs=$g['saldoActualBs'];
            $saldosus=$g['SaldoActualSus'];
            $montobs=$g['montoBs'];
            $montosus=$g['montoSus'];
            $saldoAnterior=$g['saldoAnterior'];
            $saldoAnteriorSus=$g['saldoanteriorSus'];
            $cuota=$g['cuotadia'];
            $obs=$g['obs'];

            $puntobruto=$g['puntosBruto'];
            $puntosadelanto=$g['puntosAdelanto'];
            $puntosneto=$g['puntosNeto'];
            $puntoarrastre=$g['puntoArrastre'];

            $fechabase=$g['mes'];
            $val2=array(
                "idcartera"=>"'$idcartera'",
                "codigo"=>"'3211'",
                "fecha"=>"'$fechaPago'",
                "fechaBase"=>"'$fechabase'",
                "moneda"=>"'$moneda'",
                "saldo"=>"'$saldobs'",
                "saldosus"=>"'$saldosus'",
                "monto"=>"'$montobs'",
                "descuento"=>"'$descuento'",
                "montosus"=>"'$montosus'",
                "saldoant"=>"'$saldoAnterior'",
                "saldoantSus"=>"'$saldoAnteriorSus'",
                "cuota"=>"'$cuota'",
                "glosa"=>"'$obs'",
                "diasmora"=>"'0'",
                "tipopago"=>"'1'",
                "referencia"=>"'0'",
                "lote"=>"'0'",
                "estadoant"=>"'131'",
                "estado"=>"'131'",
                "puntobruto"=>"'$puntobruto'",
                "punto"=>"'$puntosadelanto'",
                "arrastre"=>"'$puntosneto'",
                "puntoadelanto"=>"'$puntoarrastre'"
            );  
            $cobcarteradet->insertar($val2);
        }
        $i++;
    }
    echo $i." CUENTAS MIGRADAS";
?>