<?php 
$ruta="../../";
include_once($ruta."class/vestudiante.php");
$vestudiante=new vestudiante;
extract($_GET);

 $vest=$vestudiante->mostrarTodo("idvestudiante=".$ide);
 $vest=array_shift($vest);

	$arrayJSON['idestudianteInport']=$ide;
	$arrayJSON['moduloIF']=$vest['modulo']." (".$vest['descripcion'].")";
	$arrayJSON['estudianteIF']=$vest['nombre']." ".$vest['paterno']." ".$vest['materno'];
	$arrayJSON['carnetIF']=$vest['carnet']." ".$vest['expedido'];
	$arrayJSON['ruIF']=$vest['ru'];
	$arrayJSON['passIF']=$vest['pass'];

	echo json_encode($arrayJSON); 
?>