<?php
  $ruta="../../../";
  session_start(); 
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato; 
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio; 
  include_once($ruta."class/admcontratodelle.php");
  $admcontratodelle=new admcontratodelle;
  include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
  $idsede=$_SESSION["idsede"];
  $dse=$sede->muestra($idsede);
/************************************************/
// condicionamos la fecha inicio
/*************************************/
  $fechain=date("Y-m")."-01";
extract($_POST);
 session_start(); 

$valor=$nrorecord;

$dato=$admcontratodelle->mostrartodo("idadmcontratodelle=".$valor);
$dato=array_shift($dato);

            $lblcodeRec=ecUrl($valor);
          //  alert($nrorecord);
             echo $lblcodeRec; 

?> 