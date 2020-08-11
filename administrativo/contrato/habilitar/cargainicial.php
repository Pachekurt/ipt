<?php 
$ruta="../../../";
include_once($ruta."class/admcontratogen.php");
$admcontratogen=new admcontratogen;
extract($_GET);
$dctrGen=$admcontratogen->mostrarUltimo("idsede=$idsede");
$arrayJSON['inicial']=$dctrGen['final']+1;

echo json_encode($arrayJSON); 
?>
