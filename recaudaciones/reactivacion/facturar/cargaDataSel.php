<?php 
	$ruta="../../../";
	include_once($ruta."class/admplan.php");
	$admplan=new admplan;
	include_once($ruta."class/cobcartera.php");
	$cobcartera=new cobcartera;
	include_once($ruta."class/vcontratoplan.php");
	$vcontratoplan=new vcontratoplan;
	include_once($ruta."class/admenlace.php");
	$admenlace=new admenlace;
	include_once($ruta."class/reactivacion.php");
	$reactivacion=new reactivacion;
	extract($_GET);
	$drea=$reactivacion->muestra($id);
  	$monto=$drea['monto'];

  	
	$arrayJSON['monto']=$monto;
	$arrayJSON['descontable']=$monto;
	$arrayJSON['adelanto']=0;
	$arrayJSON['cuotas']=1;
	$arrayJSON['proxvence']=date("Y-m-d");
	$arrayJSON['operacion']=3218;
	$arrayJSON['txtoperacion']="Pago Cuota MN";
	echo json_encode($arrayJSON); 

?>