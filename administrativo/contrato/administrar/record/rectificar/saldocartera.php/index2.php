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
    
    foreach($admcontrato->mostrarTodo("idpersonaplan=0 and estado<>64 and estado<>60 and estado<>61") as $f){
    	$contador=0;
    	echo "ERROR ACA ".$f['nrocontrato']." ".$f['estado']."<br>";
    }
?>