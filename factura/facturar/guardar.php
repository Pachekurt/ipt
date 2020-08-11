<?php
$ruta="../../";
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

include_once($ruta."class/factcliente.php");
$factcliente=new factcliente;

require_once($ruta."funciones/codigo.php");
include_once($ruta."funciones/funciones.php");
extract($_POST);
session_start();

    $fecha=date("Y-m-d");
    $iddescuento=0;
    $saldo=0;
    /*****************************************************************************************************************/
    /********************  OPREACION PARA INSERTAR A FACTURACION *****************************************************/
    $dcli=$factcliente->muestra($idcliente);
    $dsede=$sede->mostrarUltimo("idsede=".$_SESSION["idsede"]);

    $dsuc=$admsucursal->mostrarUltimo("idsede=".$_SESSION["idsede"]." and estado=1");
    $idsucursal=$dsuc['idadmsucursal'];
    $ddos=$admdosificacion->mostrarUltimo("idadmsucursal=".$idsucursal." and estado=1");
    $iddosificacion=$ddos['idadmdosificacion'];
    $nro=$ddos['nro'];
    $idtabla=$idcliente;
    $tipotabla="SERV. AD.";

    $fecha=$fecha;
    $matricula=$idmatricula;
    $total=$idmonto;
    /*************************************************************************************************/
    $numAut=$ddos['autorizacion'];
    $numFactura=$nro;
    $nitCli=$dcli['nit'];
    $razonCli=$dcli['razon'];
    $fTransaccion=$fecha;
    $date = date_create($fTransaccion);
    $fTransaccion=date_format($date, 'Y-m-d');
    $fTransaccion=str_replace("-", "", $fTransaccion);
    $llave=$ddos['llave'];
    // datos antes de ingresar a facturacion
    
    echo "\n"."numAut-> ".$numAut."\n";
    echo "numFactura-> ".$numFactura."\n";
    echo "nitCli-> ".$nitCli."\n";
    echo "fTransaccion-> ".$fTransaccion."\n";
    echo "monto-> ".round($idmonto)."\n";
    echo "llave-> ".$llave."\n";
    
    /********************************* GENERANDO CODIGO DE CONTROL ***********************************/
    $clsControl = new CodigoControl($numAut,$numFactura,$nitCli,$fTransaccion,round($idmonto),$llave);
    $codigoControl = $clsControl->generar();
    /*************************************************************************************************/
    $impresion="0";
    $estado="1";
      // se debera insertar factura maestro
      $val3=array(
        "idsucursal"=>"'$idsucursal'",
        "iddosificacion"=>"'$iddosificacion'",
        "idtabla"=>"'$idtabla'",
        "tipotabla"=>"'$tipotabla'",
        "nro"=>"'$numFactura'",
        "fecha"=>"'$fecha'",
        "matricula"=>"'$matricula'",
        "nit"=>"'$nitCli'",
        "razon"=>"'$razonCli'",
        "total"=>"'$idmonto'",
        "descuento"=>"'$iddescuento'",
        "saldo"=>"'$saldo'",
        "control"=>"'$codigoControl'",
        "impresion"=>"'0'",
        "estado"=>"'1'",
      );  
      if($factura->insertar($val3)){
        //actualiza numero de factura
        $valFactura=array(
          "nro"=>$numFactura+1
        );  
        $admdosificacion->actualizar($valFactura,$iddosificacion);
        
        /************************************************************************************************/
        $fdet=$factura->mostrarUltimo("idtabla=$idtabla and tipotabla='".$tipotabla."'");
        $idfactura=$fdet['idfactura'];
        /************************************** PAGO  CON  ADELANTO ***************************************/
          //en caso de que la factura tenga monto descontable que no sea solo adelnato
          
          //echo $montoFact;
          $detalle=$idItem;
          $cantidad=1;
          $precio=$idmonto;
          $estado=1;
          $val4=array(
            "idfactura"=>"'$idfactura'",
            "detalle"=>"'$detalle'",
            "cantidad"=>"'$cantidad'",
            "precio"=>"'$precio'",
            "estado"=>"'$estado'"
          );  
          $facturadet->insertar($val4);
          /***************************************************************************************************/
          // actualiza carteradetalle con el id factura generada
          $lblcode=ecUrl($idfactura);
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
                  window.open("../../factura/impresion/computarizada/?lblcode=<?php echo $lblcode ?>","_blank");
                } else {
                  location.reload();
                  //window.open("<?php //echo $ruta ?>factura/impresion/pos/?lblcode=<?php //echo $lblcode ?>","_blank");
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