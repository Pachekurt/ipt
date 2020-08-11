<?php
$ruta="../../";
include_once($ruta."class/usuario.php");
$usuario=new usuario;
include_once($ruta."funciones/funciones.php");
$user=$_REQUEST['user'];//Request para android
$pass=$_REQUEST['pass'];
$pass=md5(e($pass));
$dusuario=$usuario->mostrarUltimo("usuario='".$user."' and pass='".$pass."'");
if (count($dusuario)>0){
	/*********************************** INGRESO AL SISTEMA  ******************************/
	$arrayJSON['flag']=1;
	$arrayJSON['msg']="Bienvenido al Sistema de Facturacion";
	$arrayJSON['idusuario']=$dusuario['idusuario'];
	$arrayJSON['nombre']=$dusuario['usuario'];
	/**********************************************************************************/
	/********************************* ENCAPSULAMOS ***********************************/
	echo json_encode([$arrayJSON]);
	/**********************************************************************************/
}
else
{
	/************************ FORMATO  USUARIO Y CONTRASEÑA INCORRECTAS  ***************/
	$arrayJSON['flag']=0;
	$arrayJSON['msg']="ERROR. Usuario o contraseña Incorrecta. Intente de Nuevo.";
	$arrayJSON['idusuario']="";
	$arrayJSON['nombre']="";
	/**************************** ENCAPSULAMOS ****************************************/
	echo json_encode([$arrayJSON]);
	/**********************************************************************************/
}
?>
