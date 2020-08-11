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
    
    foreach($admcontrato->mostrarTodo("estado=62") as $f){
    	$contador=0;
    	foreach($admcontratodelle->mostrarTodo("idcontrato=".$f['idadmcontrato']." and codigo=3113") as $g){
	    	$contador++;
	    }
		if ($contador==0) {
			echo "ERROR ACA ".$f['nrocontrato']."<br>";
			$valores=array(
				"estado"=>"68"
			);
			$admcontrato->actualizar($valores,$f['idadmcontrato']);
		}
    }
?>