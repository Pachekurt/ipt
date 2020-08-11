<?php 
	$ruta="../../";
	include_once($ruta."class/asistencia.php");
	$asistencia=new asistencia;
	extract($_POST);
	session_start();

	$valores=array(
	     "asis"=>"'$asis'"
	);	
	if($asistencia->actualizar($valores,$idasistencia))
	{
		echo '1';
	}
?>