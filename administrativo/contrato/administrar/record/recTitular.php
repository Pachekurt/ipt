<?php 
	$ruta="../../../../";
	include_once($ruta."class/persona.php");
	$persona=new persona;
	extract($_POST);
	if ($idcarnet!="" && $idcarnet!=" ") {
		# code...
		$dpersona=$persona->mostrarUltimo("carnet='".$idcarnet."'");
		if (count($dpersona)>0) {
			$arrayJSON['token']=1;
			$arrayJSON['id']=$dpersona['idpersona'];
			$arrayJSON['nombre']=$dpersona['nombre']." ".$dpersona['paterno']." ".$dpersona['materno'];
		}
		else{
			$arrayJSON['token']=0;
			$arrayJSON['id']=0;
			$arrayJSON['nombre']=0;
		}
	}else{
		$arrayJSON['token']=0;
		$arrayJSON['id']=0;
		$arrayJSON['nombre']=0;
	}

	echo json_encode($arrayJSON);	
?>
