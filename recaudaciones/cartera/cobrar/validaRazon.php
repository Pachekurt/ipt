<?php
	$ruta="../../../";
	include_once($ruta."class/titular.php");
	$titular=new titular;
	include_once($ruta."funciones/funciones.php");
	extract($_GET);
	$dtit=$titular->muestra($idtitular);
	if ($dtit['razon']=="" && $dtit['nit']=="") {
		/*******************************************/
		$arrayJSON['flag']="1";
	}
	else{
		$arrayJSON['flag']="0";
	}
	echo json_encode($arrayJSON); 
?>