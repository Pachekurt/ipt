  <?php 
  $ruta="../../"; 
  include_once($ruta."class/vcurso.php");
  $vcurso=new vcurso;  
  include_once($ruta."class/usuario.php");
  $usuario=new usuario; 
  
  extract($_GET);
  $arrayName = array();

   foreach($vcurso->mostrarFull("idsede=".$idsede) as $f)
    {
       //$lblcode=ecUrl($f['idvcurso']);
      // $lblcode2=$f['idvfactura'];
       
      $val4=array(
      "idcurso"=>$f['idvcurso'] ,
      "modulo"=>$f['modulo'] ,
      "docente"=>$f['nombre']." ".$f['paterno'],
      "fecha"=>$f['fechainicio']." ".$f['fechafin'],
      "hora"=>$f['inicio']." ".$f['fin'] 
    );
      array_push($arrayName,$val4);
  }
  $arreglo['data']=$arrayName;
  echo json_encode($arreglo);
?>

  