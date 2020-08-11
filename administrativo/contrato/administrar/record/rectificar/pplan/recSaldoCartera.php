<?php
	$ruta="../../../../../../";
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	include_once($ruta."class/admcontratodelle.php");
	$admcontratodelle=new admcontratodelle;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
    
    	foreach($admcontratodelle->mostrarTodo("saldocartera<0 and codigo=3113") as $g){
	    	echo "ERROR ACA ".$g['idcontrato']." PagadoRegistrado: ".$g['saldocartera']."<br>";
	    	$valores=array(
				"saldocartera"=>"0",
			);
			$admcontratodelle->actualizar($valores,$g['idadmcontratodelle']);
	    }
?>