<?php 
	$ruta="../../../";
	include_once($ruta."class/admplan.php");
	$admplan=new admplan;
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	include_once($ruta."class/vejecutivo.php");
	$vejecutivo=new vejecutivo;
	include_once($ruta."class/dominio.php");
	$dominio=new dominio;
	extract($_GET);
	$dcont=$admcontrato->mostrarUltimo("nrocontrato=$nrocontrato");
  	$idcontrato=$dcont['idadmcontrato'];

  	$deje=$vejecutivo->muestra($dcont['idadmejecutivo']);
  	$ejecutivo=$deje['nombre']." ".$deje['paterno']." ".$deje['materno'];
  	$destado=$dominio->muestra($dcont['estado']);
  	$estado=$destado['nombre'];

	$arrayJSON['idcontrato']=$idcontrato;
	$arrayJSON['ejecutivo']=$ejecutivo;
	$arrayJSON['estado']=$estado;
	echo json_encode($arrayJSON);
?>