<?php
session_start();
$ruta="../../";

include_once($ruta."class/admautorizacion.php");
$admautorizacion=new admautorizacion;
include_once($ruta."funciones/funciones.php");
extract($_GET);

//codigo
//nro
//origen
//detalle

$daut=$admautorizacion->mostrarUltimo("codigo=".$codigo." and origen='$origen'");
if (count($daut)>0) {
	//autorizacion ya se encuentra registrado
	if ($daut['estado']==1) {
		// la anulacion ya esta autorizada
		$arrayJSON['id']=$daut['idadmautorizacion'];
		$arrayJSON['estado']=1;
		$arrayJSON['detalle']=$daut['detalle'];
		$arrayJSON['msg']="Solicitud Autorizada. NUM-AUT: ".$daut['nro'].". ".$daut['comentario'];
	}
	elseif ($daut['estado']==2) {
		// la anulacion esta anulada
		$arrayJSON['id']=$daut['idadmautorizacion'];
		$arrayJSON['estado']=2;
		$arrayJSON['detalle']=$daut['detalle'];
		$arrayJSON['msg']="Solicitud Rechazada."." ".$daut['comentario'];
	}
	else{
		//la anulacion esta en espera de autorizacion
		$arrayJSON['id']=$daut['idadmautorizacion'];
		$arrayJSON['estado']=0;
		$arrayJSON['detalle']=$daut['detalle'];
		$arrayJSON['msg']="La solicitud aun no esta autorizada. En caso de tardanza contacte con la persona encargada de autoriazción.";
	}
}
else{
	//registrar autorizacion
	$valores=array(
		"codigo"=>"'$codigo'",
		"origen"=>"'$origen'",
		"detalle"=>"'$detalle'"
	);	
	if($admautorizacion->insertar($valores))
	{
		$arrayJSON['estado']=-1;
		$arrayJSON['detalle']=$detalle;
		$arrayJSON['msg']="Solicitud enviada exitosamente. Espere la autoriazción.";
	}
	else{
		$arrayJSON['estado']=-100;
		$arrayJSON['detalle']=$detalle;
		$arrayJSON['msg']="Solicitud enviada exitosamente. Espere la autoriazción.";
	}
}
echo json_encode($arrayJSON); 
?>
