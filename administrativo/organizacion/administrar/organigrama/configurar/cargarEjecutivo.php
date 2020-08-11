<?php
	session_start();  
	extract($_POST);
	$ruta="../../../../../";	
	include_once($ruta."class/vejecutivo.php");
  	$vejecutivo=new vejecutivo;
  	include_once($ruta."class/admejecutivo.php");
  	$admejecutivo=new admejecutivo;
  	include_once($ruta."class/admjerarquia.php");
  	$admjerarquia=new admjerarquia;
  	include_once($ruta."class/admorganidet.php");
  	$admorganidet=new admorganidet;
	include_once($ruta."funciones/funciones.php");
	$data = array();
	$dorgD=$admorganidet->muestra($ideje);
	$idpadre=$dorgD['idadmorganidet'];
	$idcargo=$dorgD['idcargo'];

	$idejecutivo=$dorgD['idadmejecutivo'];
	$dejec=$admejecutivo->muestra($idejecutivo);
	$vdejec=$vejecutivo->muestra($idejecutivo);
	$djer=$admjerarquia->muestra($idcargo);
	//agregar todos los de nivel inferior que pertenescan a la misma organizacion
	foreach($vejecutivo->mostrarBusqueda("idcargo=".$djer['hijo']." and idorganizacion=".$idorgz) as $f)
	{
		// validamos que el ejecutivo no se repita en el nivel
		$ddet=$admorganidet->mostrarTodo("idadmejecutivo=".$f['idvejecutivo']." and padre=$ideje");
		if (count($ddet)<1) {
			// se debera validar que el ejecutivo no este en otro nodo del organigrama
			//el ejecutivo ya esta registrado en otro nodo del organigrama?
			// alicia esta incluida en el organigrama
			$ddet=$admorganidet->mostrarTodo("idadmejecutivo=".$f['idvejecutivo']." and idadmorgani=".$dorgD['idadmorgani']." and idcargo=".$djer['hijo']);
			if (count($ddet)<1) {
			    $data[] = array(
					"idejecutivo" => $f['idvejecutivo'],
					"nombre" => $f['nombre'].' '.$f['paterno'].' '.$f['materno'],
					"cargo" => $f['njerarquia']
				);
			}
		}                     
		
	}
	/******************************************************************************************************/
	//agregar a si con jerarquia inferior
		$djerHijo=$admjerarquia->muestra($djer['hijo']);
		$data[] = array(
			"idejecutivo" => $idejecutivo,
			"nombre" => $vdejec['nombre'].' '.$vdejec['paterno'].' '.$vdejec['materno'],
			"cargo" => " COMO ".$djerHijo['nombre']
		);
	echo json_encode($data);
?>