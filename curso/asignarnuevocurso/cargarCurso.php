<?php 
$ruta="../../";
include_once($ruta."class/vcurso.php");
$vcurso=new vcurso;
include_once($ruta."class/estudiantecurso.php");
$estudiantecurso=new estudiantecurso;
extract($_GET);

$vcu=$vcurso->mostrar($idc);
$vcu=array_shift($vcu);

 $existe=$estudiantecurso->mostrarTodo("idestudiante=".$ide." and estado=1");

 $estC=$estudiantecurso->mostrarTodo("idestudiante=".$ide." and estado=1");
 $estC=array_shift($estC);
 $vce=$vcurso->mostrarTodo("idvcurso=".$estC['idcurso']);
 $vce=array_shift($vce);
 if(count($existe)>0)
{ //existe
	$arrayJSON['idcursoInport']=$vcu['idvcurso'];
	$arrayJSON['modulo']=$vcu['modulo']." (".$vcu['mdescripcion'].")";
	$arrayJSON['horario']=$vcu['inicio']." a ".$vcu['fin'];
	$arrayJSON['fechainicio']=$vcu['fechainicio'];
	$arrayJSON['fechafin']=$vcu['fechafin'];

	$arrayJSON['moduloEC']=$vce['modulo']." (".$vce['mdescripcion'].")";
	$arrayJSON['horarioEC']=$vce['inicio']." a ".$vce['fin'];
	$arrayJSON['fechainicioEC']=$vce['fechainicio'];
	$arrayJSON['fechafinEC']=$vce['fechafin'];

	$arrayJSON['existe']="1";
}else{
	$arrayJSON['idcursoInport']=$vcu['idvcurso'];
	$arrayJSON['modulo']=$vcu['modulo']." (".$vcu['mdescripcion'].")";
	$arrayJSON['horario']=$vcu['inicio']." a ".$vcu['fin'];
	$arrayJSON['fechainicio']=$vcu['fechainicio'];
	$arrayJSON['fechafin']=$vcu['fechafin'];

	$arrayJSON['moduloEC']="";
	$arrayJSON['horarioEC']="";
	$arrayJSON['fechainicioEC']="";
	$arrayJSON['fechafinEC']="";

	$arrayJSON['existe']="0";
}

 	

	echo json_encode($arrayJSON); 
?>