<?php
	session_start();  
	extract($_POST);
	$ruta="../../../";	
	include_once($ruta."class/admorganizacion.php");
  	$admorganizacion=new admorganizacion;
	foreach($admorganizacion->mostrarBusqueda("tipo=".$idarea) as $f)
	{                           
		$data[] = array(
			"idejecutivo" => $f['idadmorganizacion'],
			"nombre" => $f['nombre'] 
		);
	}
	echo json_encode($data);
?>
