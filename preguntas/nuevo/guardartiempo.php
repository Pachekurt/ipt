<?php
session_start();
include_once("../../class/referencia.php");
$referencia=new referencia;
extract($_POST); 
 
         $valores=array("duracion"=>"'$idtiempo'"
          );              

     if($referencia->actualizar($valores,$idreferencia))
      {
        echo '1';
      }
        else{
        
      echo '0';
      }
?>