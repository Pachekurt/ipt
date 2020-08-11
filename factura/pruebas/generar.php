<?php 
	require_once("../../funciones/codigo.php");
	extract($_POST);
	$date = date_create($fTransaccion);
	$fTransaccion=date_format($date, 'Y-m-d');
	$fTransaccion=str_replace("-", "", $fTransaccion);
    $clsCodigo= new CodigoControl($numAut,$numFactura,$nitCli,$fTransaccion,round($monto),$llave);
    echo $clsCodigo->generar();
?>