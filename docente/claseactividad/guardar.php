<?php 
	$ruta="../../";
	include_once($ruta."class/asistenciaact.php");
	$asistenciaact=new asistenciaact;
	extract($_POST);
	session_start();

	$valores=array(
	     "asis"=>"'$asis'"
	);	
	if($asistenciaact->actualizar($valores,$idasistenciaact))
	{
		echo '1';
	}
?>