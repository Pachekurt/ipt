<?php 
$ruta="../../";
include_once($ruta."class/estudiantereserva.php");
$estudiantereserva=new estudiantereserva;
include_once($ruta."class/admestudiante.php");
$admestudiante=new admestudiante;
include_once($ruta."class/examen.php"); //añadido para BD tabla examen
$examen=new examen;

extract($_GET);



$datoer=$estudiantereserva->mostrar($idres);

$datoer=array_shift($datoer);

$datosexamen=$examen->mostrarTodo("idestudiantereserva=".$idres);
//
$datosexamen=array_shift($datosexamen);





$datoestudiante=$admestudiante->mostrarTodo("idestudiante =". $datoer['idestudiante']);

$datoestudiante = array_shift($datoestudiante);



  
//$examen=$examen->mostrarTodo("gra =". $examen['gr']);
//$examen = array_shift($examen);


$arrayJSON['modulo']=$datoer['idmodulo'];
$arrayJSON['nombre']=$datoestudiante['nombre']." ".$datoestudiante['paterno']." ".$datoestudiante['materno'] ; 


$arrayJSON['gra']=$datosexamen['gr']; //gra esta en listadoexamenes
$arrayJSON['lis']=$datosexamen['li'];
$arrayJSON['spk']=$datosexamen['sp'];
$arrayJSON['read']=$datosexamen['re'];
$arrayJSON['wri']=$datosexamen['wr'];
$arrayJSON['pro']=$datosexamen['promedio'];

	echo json_encode($arrayJSON);
?>