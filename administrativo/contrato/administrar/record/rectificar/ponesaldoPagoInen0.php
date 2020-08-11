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
   $contador=0;
    	foreach($admcontratodelle->mostrarTodo("codigo=3113") as $g){
	    	if($g['saldo']<0){
	    		$contador++;
		    	$valores=array(
					"saldo"=>"'0'"
				);
				$admcontratodelle->actualizar($valores,$g['idadmcontratodelle']);
	    	}
	    }
	echo "FINALIZADO CORRECTAMENTE, CANTIDADA AFECTADA: ".$contador;
?>