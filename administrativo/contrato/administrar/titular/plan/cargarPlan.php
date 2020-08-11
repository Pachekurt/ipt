<?php 
$ruta="../../../../../";
include_once($ruta."class/admplan.php");
$admplan=new admplan;
extract($_GET);

$datoPlan=$admplan->mostrar($id);
$datoPlan=array_shift($datoPlan);

$arrayJSON['precio']=$datoPlan['inversion']." Bs.-";
$arrayJSON['pagoInicial']=$datoPlan['pagoinicial']." Bs.-";
$arrayJSON['pagoMensual']=$datoPlan['mensualidad']." Bs.-";
$arrayJSON['mesesPlazo']=$datoPlan['cuotas']." Meses";
$arrayJSON['personas']=$datoPlan['personas']." Personas";

echo json_encode($arrayJSON); 
?>
