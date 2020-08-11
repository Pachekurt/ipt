<?php 
$ruta="../../";
include_once($ruta."class/vcurso.php");
$vcurso=new vcurso;
include_once($ruta."class/estudiantecurso.php");
$estudiantecurso=new estudiantecurso;
include_once($ruta."class/estudiante.php");
$estudiante=new estudiante;
include_once($ruta."class/persona.php");
$persona=new persona;
extract($_GET);

 $est=$estudiante->mostrarTodo("idestudiante=".$ide);
 $est=array_shift($est);
 $per=$persona->mostrar($est['idpersona']);
 $per=array_shift($per);

 $estC=$estudiantecurso->mostrarTodo("idestudiante=".$ide." and estado=1");
 $estC=array_shift($estC);
 $vce=$vcurso->mostrarTodo("idvcurso=".$estC['idcurso']);
 $vce=array_shift($vce);

	$arrayJSON['idestudianteInport']=$ide;
	$arrayJSON['moduloEC']=$vce['modulo']." (".$vce['mdescripcion'].")";
	$arrayJSON['horarioEC']=$vce['inicio']." a ".$vce['fin'];
	$arrayJSON['fechainicioEC']=$vce['fechainicio'];
	$arrayJSON['fechafinEC']=$vce['fechafin'];
	$arrayJSON['docenteEC']=$vce['nombre']." ".$vce['paterno']." ".$vce['materno'];
	$arrayJSON['estudianteEC']=$per['nombre']." ".$per['paterno']." ".$per['materno'];
	$arrayJSON['carnetEC']=$per['carnet']." ".$per['expedido'];

	echo json_encode($arrayJSON); 
?>