<?php 
  $ruta="../../../";
    include_once($ruta."class/vcontratodeta.php");
    $vcontratodeta=new vcontratodeta;
  extract($_GET);
    session_start();
  $arrayName = array();

    foreach($vcontratodeta->mostrarTodo("nrocontrato=".$id." and record not in (0)") as $f)
    {
      
         $lblcode=ecUrl($f['idvcontratodeta']);
   
       
      $val5=array(
            "codigo"=>$lblcode,
            "id"=>$f['idvcontratodeta'],
            "numero"=>$f['record'],
            "contrato"=>$f['nrocontrato'],
            "monto"=>$f['monto'],
            "detalle"=>$f['detalle'],    
            
    );
      array_push($arrayName,$val5);
  }
  $arreglo['data']=$arrayName;
  echo json_encode($arreglo);
?>