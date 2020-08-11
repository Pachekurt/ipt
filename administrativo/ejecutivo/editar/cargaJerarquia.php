<?php
	session_start();  
	extract($_POST);
	$ruta="../../../";	
	include_once($ruta."class/admjerarquia.php");
  	$admjerarquia=new admjerarquia;
  	$query="";
  	if ($idarea==121) {
  		$query="";
  	}
	foreach($admjerarquia->mostrarBusqueda("tipo=".$idarea.$query) as $f)
	{                           
		$data[] = array(
			"id" => $f['idadmjerarquia'],
			"nombre" => $f['nombre']
		);
	}
	echo json_encode($data);
?>
