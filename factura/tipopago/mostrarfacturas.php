  <?php 
  $ruta="../../../../../web-admin/";
    $rutaRaiz="../../"; 
  include_once($rutaRaiz."class/vfactura.php");
  $vfactura=new vfactura;
  include_once($rutaRaiz."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($rutaRaiz."class/sede.php");
  $sede=new sede;
  extract($_GET);
  $arrayName = array();

   foreach($vfactura->mostrarTodoDesdendente("idsede=$idsede and idsucursal=$idsucursal and iddosificacion=$iddos","nro") as $f)
    {
       $lblcode=ecUrl($f['idvfactura']);
      // $lblcode2=$f['idvfactura'];
       $dsuc=$admsucursal->muestra($f['idsucursal']);
       $dsede=$sede->muestra($dsuc['idsede']);

                          switch ($f['estado']) {
                            case '1':
                              $estado="VALIDA";
                            break;
                            case '2':
                             $estado="ANULADA";
                            break;
                            case '3':
                              $estilo="";
                            break;
                            case '4':
                              $estilo="";
                            break;
                          }

                          switch ($f['tipotabla']) {
                            case 'CART':
                              $desde="CARTERA";
                              break;
                            case 'RECO':
                               $desde="PRODUCCION";
                              break;
                            case 'SERV. AD.':
                               $desde="SERVICIO ADICIONAL";
                              break;
                          } 
      $val4=array(
      "fecha"=>$f['fecha']." ".$f['horacreacion'],
      "nro"=>$f['nro'],
      "lbl"=>$lblcode,
      "lbl2"=>$lblcode2,
      "matricula"=>$f['matricula'],
      "monto"=>$f['total'],
      "sede"=>$dsede['nombre'],
      "desde"=>$desde,
      "estado"=>$estado 
    );
      array_push($arrayName,$val4);
  }
  $arreglo['data']=$arrayName;
  echo json_encode($arreglo);
?>