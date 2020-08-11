<?php
session_start();
$ruta="../../";
include_once($ruta."class/admautorizacion.php");
$admautorizacion=new admautorizacion;
include_once($ruta."class/dominio.php");
$dominio=new dominio;
include_once($ruta."class/usuario.php");
$usuario=new usuario;
include_once($ruta."funciones/funciones.php");
extract($_GET);
$daut=$admautorizacion->muestra($id);

$ddominio=$dominio->muestra($daut['origen']);
$dus=$usuario->muestra($daut['usuariocreacion']);

$dusAut=$usuario->muestra($daut['usuarioAut']);

$estado="";
if ($daut['estado']==0) {
	$estado="PENDIENTE";
}
if ($daut['estado']==1) {
	$estado="APROBADO";
}
$arrayJSON['id']=$id;
$arrayJSON['detalle']=$ddominio['nombre'];
$arrayJSON['usuarioSol']=$dus['usuario'];
$arrayJSON['fechaSol']=$daut['fechacreacion']." ".$daut['horacreacion'];
$arrayJSON['motivoSol']=$daut['detalle'];

$arrayJSON['estado']=$estado;
$arrayJSON['usuarioAut']=$dusAut['usuario'];
$arrayJSON['fechaAut']=$daut['fechaAut']." ".$daut['horaAut'];
$arrayJSON['comentarioAut']=$daut['comentario'];

echo json_encode($arrayJSON); 
?>
