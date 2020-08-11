<?php 
$ruta="../../";
include_once($ruta."class/referencia.php");
$referencia=new referencia;
extract($_GET);

 $ref=$referencia->mostrar($idr);
 $ref=array_shift($ref);

 
	$arrayJSON['idreferenciaInport']=$idr;
	$arrayJSON['nombreRE']=$ref['nombre'];
	$arrayJSON['descripcionRE']=$ref['descripcion'];

	echo json_encode($arrayJSON); 
?>