<?php
	$ruta="../../../../../";
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	include_once($ruta."class/admcontratodelle.php");
	$admcontratodelle=new admcontratodelle;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
    
    foreach($admcontrato->mostrarTodo("estado>61") as $f){
    	$monto=0;
    	foreach($admcontratodelle->mostrarTodo("idcontrato=".$f['idadmcontrato']." and codigo=3113") as $g){
	    	$monto=$monto+$g['monto'];
	    }
	    $valores=array(
			"pagado"=>"'$monto'"
		);
		$admcontrato->actualizar($valores,$f['idadmcontrato']);
		if ($monto>0) {
			echo "cambio en contrato ".$f['idadmcontrato']."<br>";
		}
    }
?>