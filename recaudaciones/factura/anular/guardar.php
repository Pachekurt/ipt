<?php
$ruta="../../../";
include_once($ruta."class/vcontratoplan.php");
$vcontratoplan=new vcontratoplan;
include_once($ruta."class/admplan.php");
$admplan=new admplan;
include_once($ruta."class/cobcarteradet.php");
$cobcarteradet=new cobcarteradet;
include_once($ruta."class/cobcartera.php");
$cobcartera=new cobcartera;
include_once($ruta."class/factura.php");
$factura=new factura;
include_once($ruta."class/facturadet.php");
$facturadet=new facturadet;
include_once($ruta."class/admsucursal.php");
$admsucursal=new admsucursal;
include_once($ruta."class/admdosificacion.php");
$admdosificacion=new admdosificacion;
include_once($ruta."class/sede.php");
$sede=new sede;
include_once($ruta."class/titular.php");
$titular=new titular;
include_once($ruta."class/vtitular.php");
$vtitular=new vtitular;
include_once($ruta."class/vpagotit.php");
$vpagotit=new vpagotit;
require_once($ruta."funciones/codigo.php");
include_once($ruta."funciones/funciones.php");
extract($_POST);
session_start();
//obtener datos de factura
$dfactura=$factura->muestra($idfactura);
$saldo=$dfactura['saldo'];

//actualizar razon Nit
$dpago=$vpagotit->muestra($dfactura['idtabla']);
$idtitular=$dpago['idvtitular'];
$valores=array(
  "nit"=>"'$idnit'",
  "razon"=>"'$idrazon'"
);
$titular->actualizar($valores,$idtitular);
//Genrar Codigo de Control 
/*****************************************************************************************************************/
/********************  OPREACION PARA INSERTAR A FACTURACION *****************************************************/
$dsede=$sede->mostrarUltimo("idsede=".$_SESSION["idsede"]);
$dsuc=$admsucursal->mostrarUltimo("idsede=".$_SESSION["idsede"]);
$idsucursal=$dsuc['idadmsucursal'];
$ddos=$admdosificacion->mostrarUltimo("idadmsucursal=".$idsucursal." and estado=1");
$iddosificacion=$ddos['idadmdosificacion'];
$nro=$ddos['nro'];
$idtabla=$dfactura['idtabla'];
$tipotabla="CART";

$fecha=date("Y-m-d");
$matricula=$dfactura['matricula'];
$total=$dfactura['total'];

/*****************************************************************************************************************/
$numAut=$ddos['autorizacion'];
$numFactura=$nro;
$nitCli=$idnit;
$fTransaccion=$fecha;
$date = date_create($fTransaccion);
$fTransaccion=date_format($date, 'Y-m-d');
$fTransaccion=str_replace("-", "", $fTransaccion);
$monto=$total;
$llave=$ddos['llave'];
// datos antes de ingresar a facturacion

echo "\n"."numAut-> ".$numAut."\n";
echo "numFactura-> ".$numFactura."\n";
echo "nitCli-> ".$nitCli."\n";
echo "fTransaccion-> ".$fTransaccion."\n";
echo "monto-> ".round($total)."\n";
echo "llave-> ".$llave."\n";

/********************************* GENERANDO CODIGO DE CONTROL ***********************************/
$clsControl = new CodigoControl($numAut,$numFactura,$nitCli,$fTransaccion,round($monto),$llave);
$codigoControl = $clsControl->generar();
echo $codigoControl."\n";
/*************************************************************************************************/


//traspasar tabla factura
//traspasar movimientos de factura
// cambiar id de factura en record de produccion
$val3=array(
  "idsucursal"=>"'$idsucursal'",
  "iddosificacion"=>"'$iddosificacion'",
  "idtabla"=>"'$idtabla'",
  "tipotabla"=>"'CART'",
  "nit"=>"'$idnit'",
  "razon"=>"'$idrazon'",
  "nro"=>"'$numFactura'",
  "fecha"=>"'$fecha'",
  "matricula"=>"'$matricula'",
  "total"=>"'$monto'",
  "saldo"=>"'$saldo'",
  "control"=>"'$codigoControl'",
  "impresion"=>"'0'",
  "estado"=>"'1'"
);  
if($factura->insertar($val3)){
  echo "CORRECTAMENTE";
  $dfactM=$factura->mostrarUltimo("idtabla=$idtabla and control='".$codigoControl."'");
  $idfacturaM=$dfactM['idfactura'];
  foreach($facturadet->mostrarTodo("idfactura=$idfactura") as $f)
  {
    $val4=array(
      "idfactura"=>"'$idfacturaM'",
      "detalle"=>"'".$f['detalle']."'",
      "cantidad"=>"'".$f['cantidad']."'",
      "precio"=>"'".$f['precio']."'",
      "estado"=>"'".$f['estado']."'"
    );
    $facturadet->insertar($val4);
  }
  // direccionamos la nueva factura Generada
  $valFactura=array(
    "idfactura"=>$idfacturaM
  );  
  $cobcarteradet->actualizar($valFactura,$idtabla);
  //actualiza numero de factura
  $valFactura=array(
    "nro"=>$numFactura+1
  );  
  $admdosificacion->actualizar($valFactura,$iddosificacion);
  //ANULAMOS LA ANTERIOR FACTURA
  $valores=array(
    "estado"=>"2",
    "idestado"=>"$idautorizacion"
  );
  $factura->actualizar($valores,$idfactura);

  $lblcode=ecUrl($idfacturaM);
  ?>
    <script  type="text/javascript">
      swal({
        title: "Factura:  <?php echo $numFactura ?>",
        text: "Selecciona el modo de impresion de la factura",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#16c103",
        confirmButtonText: "Computarizada",
        cancelButtonText: "P.O.S.",
        confirmButtonClass: 'btn green',
        cancelButtonClass: 'btn red',
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm){
        if (isConfirm) {
          location.reload();
          window.open("../../../factura/impresion/computarizada/?lblcode=<?php echo $lblcode ?>","_blank");
        } else {
          location.reload();
        }
      });
    </script>
  <?php
}
else{
  ?>
    <script type="text/javascript">
      setTimeout(function() {
        Materialize.toast('<span>3 Factura No se pudo realizar el registro</span>', 1500);
      }, 10);
    </script>
  <?php
}
?>