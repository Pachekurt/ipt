<?php 
$ruta="../../";
include_once($ruta."class/estudiante.php");
$estudiante=new estudiante;
include_once($ruta."class/persona.php");
$persona=new persona;
extract($_GET);

$es=$estudiante->mostrar($ide);
$es=array_shift($es);
$per=$persona->mostrar($es['idpersona']);
$per=array_shift($per);

  $arrayJSON['estudiante']=$per['nombre']." ".$per['paterno']." ".$per['materno'];
  $arrayJSON['carnet']=$per['carnet']." ".$per['expedido'];
  $arrayJSON['idperson']=$per['idpersona'];

  echo json_encode($arrayJSON); 
?>