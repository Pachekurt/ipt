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
$estado="";
if ($daut['estado']==0) {
	$estado="PENDIENTE";
}
$arrayJSON['id']=$id;
$arrayJSON['titulo']=$ddominio['nombre'];
$arrayJSON['fecha']=$daut['fechacreacion']." ".$daut['horacreacion'];
$arrayJSON['usuario']=$dus['usuario'];
$arrayJSON['estado']=$estado;
$arrayJSON['motivo']=$daut['detalle'];
	

echo json_encode($arrayJSON); 
?>
