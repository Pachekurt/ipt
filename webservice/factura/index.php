<?php
$ruta="../../";

$idusuario=$_REQUEST['idusuario'];//Request para android
$nrofactura=$_REQUEST['nrofactura'];

include_once($ruta."class/dominio.php");
$dominio=new dominio;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."class/vtitular.php");
$vtitular=new vtitular;
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo;
include_once($ruta."class/sede.php");
$sede=new sede;
include_once($ruta."class/factura.php");
$factura=new factura;
include_once($ruta."class/facturadet.php");
$facturadet=new facturadet;
include_once($ruta."class/admsucursal.php");
$admsucursal=new admsucursal;
include_once($ruta."class/miempresa.php");
$miempresa=new miempresa;
include_once($ruta."class/files.php");
$files=new files;
include_once($ruta."class/admdosificacion.php");
$admdosificacion=new admdosificacion;
include_once($ruta."class/vpagotit.php");
$vpagotit=new vpagotit;
include_once($ruta."class/vrecotit.php");
$vrecotit=new vrecotit;
include_once($ruta."class/usuario.php");
$usuario=new usuario;
include_once($ruta."class/factcliente.php");
$factcliente=new factcliente;
include_once($ruta."funciones/funciones.php");

$dus=$usuario->muestra($idusuario);
$dsucursal=$admsucursal->mostrarUltimo("idsede=".$dus['idsede']);
$idsucursal=$dsucursal['idadmsucursal'];
/************************************* Buscador  ****************************************/
$dfactura=$factura->mostrarUltimo("nro=".$nrofactura." and idsucursal=".$idsucursal);
if (count($dfactura)>0) {
  //echo "Factura Encontrada"."\n\n";
  $idfactura=$dfactura['idfactura'];
  $valFactura=array(
    "impresion"=>$dfactura['impresion']+1
  );  
  $factura->actualizar($valFactura,$idfactura);
  $dsede=$sede->muestra($dus['idsede']);
  $demp=$miempresa->muestra($dsucursal['idmiempresa']);
  $ddos=$admdosificacion->muestra($dfactura['iddosificacion']);
  $nombreG=$demp['nombre'];
  $nsuc=$dsucursal['nombre'];
  $zonaG=$dsucursal['zona'];
  $dirG=$dsucursal['direccion']." ".$zonaG;
  $fonos="Telfs: ".$dsucursal['telefonos'];
  $nsede=$dsede['nombre']."-BOLIVIA";
  $titulo="FACTURA";
  if ($dfactura['esprueba']==1) {
    $titulo=$titulo." - NO VALIDA";
  }
  $nitgolden="NIT: ".$demp['nit'];
  $nrofactura="FACTURA Nro.: ".$dfactura['nro'];
  $autorizacion="AUTORIZACION Nro.:".$ddos['autorizacion'];
  $actividad=$dsucursal['actividad'];
  $fecha="FECHA: ".$dfactura['fechacreacion'];
  $hora="HORA: ".$dfactura['horacreacion'];
  $matricula="MATRICULA: ".$dfactura['matricula'];
  $razonT="ERROR";
  $nitT="ERROR";
  $razonT=$dfactura['razon'];
  $nitT=$dfactura['nit'];

  $nitQR=$nitT;
  $razonT="NOMBRE: ".$razonT;
  $nitT="NIT/CI: ".$nitT;
  $total="TOTAL: Bs. ".number_format($dfactura['total'], 2, '.', '');
  $descuento="DESCUENTOS: ".number_format($dfactura['descuento'], 2, '.', '');
  $totalPagar="TOTAL A PAGAR: ".number_format($dfactura['total'], 2, '.', '');
  $literal="SON: ".strtoupper(num2letras(number_format($dfactura['total'], 2, '.', '')));
  $control="CÓDIGO DE CONTROL: ".$dfactura['control'];
  $fechca = date_create($ddos['fechalimite']);
  $fechaQr=date_format($fechca, 'd/m/Y');
  $fechalimite="FECHA LÍMITE DE EMISIÓN: ".$fechaQr;
  $leyenda1="ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS. EL USO ILÍCITO DE ÉSTA SERÁ SANCIONADO DE ACUERDO A LEY";
  $leyenda2=$ddos['leyenda'];
  $saldo="SALDO: ".number_format($dfactura['saldo'], 2, '.', '')." Bolivianos";
  //$saldo="SALDO: 0.00";
  $txtQR= $demp['nit'].'|'.$dfactura['nro'].'|'.$ddos['autorizacion'].'|'.$fechaQr.'|'.number_format($dfactura['total'], 2, '.', '').'|'.number_format($dfactura['total'], 2, '.', '').'|'.$dfactura['control'].'|'.$nitQR.'|0|0|0|0'; 

  /******************************** VARIABLES DE SALIDA ********************************
  echo $nombreG."\n";
  echo $nsuc."\n";
  echo $zonaG."\n";
  echo $dirG."\n";
  echo $fonos."\n";
  echo $nsede."\n";
  echo $titulo."\n";
  echo $nitgolden."\n";
  echo $nrofactura."\n";
  echo $autorizacion."\n";
  echo $actividad."\n";
  echo $fecha."\n";
  echo $hora."\n";
  echo $matricula."\n";
  echo $razonT."\n";
  echo $nitT."\n";
  //detalle
  echo $total."\n";
  echo $descuento."\n";
  echo $totalPagar."\n";
  echo $literal."\n";
  echo $control."\n";
  echo $fechalimite."\n";
  echo $leyenda1."\n";
  echo $leyenda2."\n";
  echo $txtQR."\n";
/**********************************************/
  $arrayJSON['flag']=1;
  $arrayJSON['msg']="Factura Encontrada";
  $arrayJSON['nombreG']=$nombreG;
  $arrayJSON['nsuc']=$nsuc;
  $arrayJSON['zonaG']=$zonaG;
  $arrayJSON['dirG']=$dirG;
  $arrayJSON['fonos']=$fonos;
  $arrayJSON['nsede']=$nsede;
  $arrayJSON['titulo']=$titulo;
  $arrayJSON['nitgolden']=$nitgolden;
  $arrayJSON['nrofactura']=$nrofactura;
  $arrayJSON['autorizacion']=$autorizacion;
  $arrayJSON['actividad']=$actividad;
  $arrayJSON['fecha']=$fecha;
  $arrayJSON['hora']=$hora;
  $arrayJSON['matricula']=$matricula;
  $arrayJSON['razonT']=$razonT;
  $arrayJSON['nitT']=$nitT;
  $arrayJSON['total']=$total;
  $arrayJSON['totalPagar']=$totalPagar;
  $arrayJSON['descuento']=$descuento;
  $arrayJSON['saldo']=$saldo;
  $arrayJSON['literal']=$literal;
  $arrayJSON['control']=$control;
  $arrayJSON['fechalimite']=$fechalimite;
  $arrayJSON['leyenda1']=$leyenda1;
  $arrayJSON['leyenda2']=$leyenda2;
  $arrayJSON['txtQR']=$txtQR;
  
  $arrayName = array();
  foreach($facturadet->mostrarTodo("idfactura=$idfactura") as $f)
  {
    $det=$f['detalle'];
    $precio=number_format($f['precio'], 2, '.', '');
    $val4=array(
      "detalle"=>"$det",
      "subtotal"=>"$precio"
    );
    array_push($arrayName,$val4);
  }
  $arrayJSON['items']=$arrayName;
  echo json_encode([$arrayJSON]);
}
else{
  $arrayJSON['flag']=0;
  $arrayJSON['msg']="La factura no se encuestra registrada. Si el error persiste, contacte con el director de  sistemas";
  echo json_encode([$arrayJSON]);
}
/*****************************************************************************************/

 ?>
