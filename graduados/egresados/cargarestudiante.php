<?php 
$ruta="../../";
include_once($ruta."class/estudiante.php");
$estudiante=new estudiante;
include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."class/nota.php");
$nota=new nota;
extract($_GET);

$es=$estudiante->mostrar($ide);
$es=array_shift($es);
$per=$persona->mostrar($es['idpersona']);
$per=array_shift($per);

$dnota=$nota->sql('call nota('.$ide.')');
$dnota=array_shift($dnota);

	$arrayJSON['estudiante']=$per['nombre']." ".$per['paterno']." ".$per['materno'];
	$arrayJSON['carnet']=$per['carnet']." ".$per['expedido'];
	$arrayJSON['idperson']=$per['idpersona'];
	$arrayJSON['grammar']=$dnota['Grammar']; 
	$arrayJSON['listening']=$dnota['Listening']; 
	$arrayJSON['reading']=$dnota['Reading']; 
	$arrayJSON['writing']=$dnota['Writing']; 
	$arrayJSON['speech']=$dnota['finalspeech']; 
	echo json_encode($arrayJSON); 
?>