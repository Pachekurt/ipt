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
    
    foreach($admcontrato->mostrarTodo("estado<>60") as $f){
    	$contador=0;
    	$sumatoria=0;
    	foreach($admcontratodelle->mostrarTodo("idcontrato=".$f['idadmcontrato']." and codigo=3113") as $g){
	    	$contador++;
	    	$sumatoria=$sumatoria+$g['monto'];
	    }
		if ($sumatoria!=$f['pagado']) {
			echo "ERROR ACA ".$f['nrocontrato']." PagadoRegistrado: ".$f['pagado']." sumatoria: ".$sumatoria."<br>";
			$valores=array(
				"pagado"=>"'$sumatoria'"
			);
			$admcontrato->actualizar($valores,$f['idadmcontrato']);
		}
    }
?>