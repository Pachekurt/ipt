<?php 
$ruta="../../../";
include_once($ruta."class/domicilio.php");
$domicilio=new domicilio;
extract($_GET);
foreach($domicilio->mostrarTodo("iddomicilio=".$id) as $f)
{
  $resultado[] = array( 
    "idmaps" => $f['iddomicilio'],
    "coordX" => $f['geox'],
    "coordY" => $f['geoy']
  );  
}
echo json_encode($resultado);

?>