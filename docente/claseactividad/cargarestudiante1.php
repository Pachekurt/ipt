<?php 
$ruta="../../";
include_once($ruta."class/admestudiante.php");
$admestudiante=new admestudiante;
include_once($ruta."class/persona.php");
$persona=new persona;
extract($_GET);

$es=$admestudiante->mostrarTodo("carnet=$ci");
$es=array_shift($es);
$mesaje="NO EXISTE";

	$ruta="../../";
	include_once($ruta."class/estudiantecurso.php");
	$estudiantecurso=new estudiantecurso;
	include_once($ruta."class/asistencia.php");
	$asistencia=new asistencia;
    include_once($ruta."class/vestudiantecurso.php");
	$vestudiantecurso=new vestudiantecurso;

$nros=$vestudiantecurso->mostrarTodo("carnet=".$ci);
$nros=count($nros);
if($es['idestudiante']==0)
{
        $arrayJSON['estudiante']=$mesaje;
        $arrayJSON['carnet']=$mesaje;
        $arrayJSON['idest']=$es['idestudiante'];
        $arrayJSON['contrato']=$mesaje;
        $arrayJSON['academico']=$mesaje;
        $arrayJSON['ncontrato']=$mesaje;
        $arrayJSON['nacademico']=$mesaje;
}
else{
	   $arrayJSON['estudiante']=$es['nombre']." ".$es['paterno']." ".$es['materno'];
        $arrayJSON['carnet']=$es['carnet']." ".$es['expedido'];
        $arrayJSON['idest']=$es['idestudiante'];
        $arrayJSON['contrato']=$es['estadocontrato'];
        $arrayJSON['academico']=$es['estadoacademico'];
        $arrayJSON['ncontrato']=$es['nestadocontrato'];
        $arrayJSON['nacademico']=$es['nestadoacademico'];
}
echo json_encode($arrayJSON);         
?>