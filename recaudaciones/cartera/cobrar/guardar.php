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

include_once($ruta."class/vtitular.php");
$vtitular=new vtitular;

include_once($ruta."class/ctbdia.php");
$ctbdia=new ctbdia;

require_once($ruta."funciones/codigo.php");
include_once($ruta."funciones/funciones.php");
extract($_POST);
session_start();
if ($_SESSION["estadoSesion"]!='Jhulios20005') {
  exit();
}else{
  //monto en dolares
  if ($idmontoSus>0) {
    $dct=$ctbdia->mostrarUltimo("estado=1");
    $tc=number_format($dct['dolar'], 2, '.', '');
    $dolBol=$idmontoSus*$tc;
    $bolivianos=$idmonto;
    $idmonto=$dolBol+$idmonto;
  }
  else
  {
    $bolivianos=$idmonto;
  }
  $dcar=$cobcartera->muestra($idcartera);
  $dcp=$vcontratoplan->muestra($dcar['idcontrato']);
  $dtit=$vtitular->muestra($dcp['idtitular']);
  $restan=crestantes($dcar['monto']-$dcar['pagadoprod'],$dcar['saldo'],$dcp['cuotas']);
  $totalCuotas=$dcp['cuotas']+1;
  $cuotaPago=$totalCuotas-$restan+$idcuotas;
  $saldoAnt=$dcar['saldo'];
  $estadoAnt=$dcar['estado'];
  $diasmoraAnt=$dcar['diasmora'];
  $saldo=$saldoAnt-$idmonto-$iddescuento;
  //echo "SALDO ANT: ".$saldoAnt." MONTO: ".$idmonto." DESC: ".$iddescuento." SALDO".$saldo;
  if ($iddescontable==0) {
    $cuotaPago++;
  }
  /*************** DATOS PARA SIGUIENTE MES ***************************/
  //fecha hoy
  $fecha=date("Y-m-d");
  $dias= diferenciaDias($idproxvence, $fecha);
  if ($dias>0) {
    $estado=133;
    $diasmora=$dias;
  }
  else{
    $estado=131;
    $diasmora=0;
  }
  if ($saldo<=0) {
    $estado=130;
  }

  //fecha prox vence
  //Saldo menos el monto cancelado
  //dias mora hasta la fecha
  //estado-> caldulara si es vigente vencido o ejecucion a partir de la fecha proximo vencimiento
  $valores=array(
  	"fechaultpago"=>"'$fecha'",
  	"fechaproxve"=>"'$idproxvence'",
  	"saldo"=>"'$saldo'",
  	"diasmora"=>"'$diasmora'",
    "estado"=>"'$estado'",
  );
  if($cobcartera->actualizar($valores,$idcartera))
  {
    /****************************** GENERAMOS PUNTAJE  ************************************/
    /**************************************************************************************/
    
    $arrastre=0;
    $puntos=0;
    if ($dcar['estado']==131) {
      $porcentajeBruto=$idmonto/$dcp['mensualidad'];
      if ($porcentajeBruto>2) {
        $arrastre=$porcentajeBruto-2;
        $puntos=2;
      }
      else{
        $arrastre=0;
        $puntos=$porcentajeBruto;
      }
    }
    $puntos=number_format($puntos, 2, '.', '');
    $arrastre=number_format($arrastre, 2, '.', '');
    //echo " PUNTOS ".$puntos."\n";
    //echo " ARRASTRE ".$arrastre."\n";

    /**************************************************************************************/
    /**************************************************************************************/
      
      if ($idmontoSus>0) {
        // PAGO EN BOLIVIANOS
        if ($bolivianos>0) {
          $saldoBs=$saldoAnt-$bolivianos-$iddescuento;
          $val2=array(
            "idcartera"=>"'$idcartera'",
            "codigo"=>"'$idoperacion'",
            "fecha"=>"'$fecha'",
            "moneda"=>"'BS'",
            "saldo"=>"'$saldoBs'",
            "monto"=>"'$bolivianos'",
            "descuento"=>"'$iddescuento'",
            "saldoant"=>"'$saldoAnt'",
            "cuota"=>"'$cuotaPago'",
            "glosa"=>"'$idoptext'",
            "diasmora"=>"'$diasmoraAnt'",
            "tipopago"=>"'$tpago'",
            "referencia"=>"'$idref'",
            "lote"=>"'$idlote'",
            "estadoant"=>"'$estadoAnt'",
            "estado"=>"'$estado'",
            "punto"=>"'$puntos'",
            "arrastre"=>"'0'",
          );  
          $cobcarteradet->insertar($val2);
          $ddet=$cobcarteradet->mostrarUltimo("idcartera=$idcartera and saldo=$saldoBs");
          $iddet1=$ddet['idcobcarteradet'];
          //PAGO EN DOLARES
          $saldoAnt=$saldoBs;
        }

        $saldoNuevo=$saldoAnt-$dolBol;
        $val2=array(
          "idcartera"=>"'$idcartera'",
          "codigo"=>"'$idoperacion'",
          "fecha"=>"'$fecha'",
          "moneda"=>"'SUS'",
          "saldo"=>"'$saldoNuevo'",
          "monto"=>"'$dolBol'",
          "descuento"=>"'0'",
          "saldoant"=>"'$saldoAnt'",
          "cuota"=>"'$cuotaPago'",
          "glosa"=>"'$idoptext'",
          "diasmora"=>"'$diasmoraAnt'",
          "tipopago"=>"'$tpago'",
          "referencia"=>"'$idref'",
          "lote"=>"'$idlote'",
          "estadoant"=>"'$estadoAnt'",
          "estado"=>"'$estado'",
          "punto"=>"'$puntos'",
          "arrastre"=>"'0'",
        );  
        $cobcarteradet->insertar($val2);
        $ddet=$cobcarteradet->mostrarUltimo("idcartera=$idcartera and saldo=$saldoNuevo");
        if ($bolivianos>0) {
          $iddet2=$ddet['idcobcarteradet'];
        }
        else{
          $iddet1=$ddet['idcobcarteradet'];
        }
      }
      else{
        $val2=array(
          "idcartera"=>"'$idcartera'",
          "codigo"=>"'$idoperacion'",
          "fecha"=>"'$fecha'",
          "moneda"=>"'BS'",
          "saldo"=>"'$saldo'",
          "monto"=>"'$idmonto'",
          "descuento"=>"'$iddescuento'",
          "saldoant"=>"'$saldoAnt'",
          "cuota"=>"'$cuotaPago'",
          "glosa"=>"'$idoptext'",
          "diasmora"=>"'$diasmoraAnt'",
          "tipopago"=>"'$tpago'",
          "referencia"=>"'$idref'",
          "lote"=>"'$idlote'",
          "estadoant"=>"'$estadoAnt'",
          "estado"=>"'$estado'",
          "punto"=>"'$puntos'",
          "arrastre"=>"'$arrastre'",
        );  
        $cobcarteradet->insertar($val2);
        $ddet=$cobcarteradet->mostrarUltimo("idcartera=$idcartera and saldo=$saldo");
        $iddet1=$ddet['idcobcarteradet'];
      }
      
      /*****************************************************************************************************************/
      /********************  OPREACION PARA INSERTAR A FACTURACION *****************************************************/
      $dsede=$sede->mostrarUltimo("idsede=".$_SESSION["idsede"]);

      $dsuc=$admsucursal->mostrarUltimo("idsede=".$_SESSION["idsede"]." and estado=1");
      $esprueba=$dsuc['esprueba'];
      $idsucursal=$dsuc['idadmsucursal'];
      $ddos=$admdosificacion->mostrarUltimo("idadmsucursal=".$idsucursal." and estado=1");
      $iddosificacion=$ddos['idadmdosificacion'];
      $nro=$ddos['nro'];
      $idtabla=$iddet1;
      $tipotabla="CART";

      $fecha=$fecha;
      $matricula=$dsede['prefijo']."-".$dcp['nrocontrato'];
      $total=$idmonto;
      /*************************************************************************************************/
      $numAut=$ddos['autorizacion'];
      $numFactura=$nro;
      $nitCli=$dtit['nit'];
      $razonCli=$dtit['razon'];
      $fTransaccion=$fecha;
      $date = date_create($fTransaccion);
      $fTransaccion=date_format($date, 'Y-m-d');
      $fTransaccion=str_replace("-", "", $fTransaccion);
      $llave=$ddos['llave'];
      // datos antes de ingresar a facturacion
      /*
      echo "\n"."numAut-> ".$numAut."\n";
      echo "numFactura-> ".$numFactura."\n";
      echo "nitCli-> ".$nitCli."\n";
      echo "fTransaccion-> ".$fTransaccion."\n";
      echo "monto-> ".round($idmonto)."\n";
      echo "llave-> ".$llave."\n";
      */
      /********************************* GENERANDO CODIGO DE CONTROL ***********************************/
      $clsControl = new CodigoControl($numAut,$numFactura,$nitCli,$fTransaccion,round($idmonto),$llave);
      $codigoControl = $clsControl->generar();
      /*************************************************************************************************/
      $impresion="0";
      $estado="1";
      //En caso de que sea solo adelanto
      if ($idmonto+$idadelanto>0) {
        # code...
      
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
          "esprueba"=>$esprueba,
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
          //// actualiaza detalle 
          $valFactura=array(
            "idfactura"=>$idfactura
          );  
          $cobcarteradet->actualizar($valFactura,$iddet1);
          $cobcarteradet->actualizar($valFactura,$iddet2);
          /************************************** PAGO  CON  ADELANTO ***************************************/
            //en caso de que la factura tenga monto descontable que no sea solo adelnato
            if($iddescontable>0){
              $saldoD=$saldoAnt-$iddescontable;
              $montoFact=number_format($iddescontable, 2, '.', '')-number_format($iddescuento, 2, '.', '');
              $montoFact=number_format($montoFact, 2, '.', '');
              //echo $montoFact;
              $detalle="Pago ".ordinal($cuotaPago)." Mensualidad";
              $cantidad=1;
              $precio=$idmonto;
              $estado=1;
              $val4=array(
                "idfactura"=>"'$idfactura'",
                "detalle"=>"'$detalle'",
                "cantidad"=>"'$cantidad'",
                "precio"=>"'$montoFact'",
                "estado"=>"'$estado'"
              );  
              $facturadet->insertar($val4);
            }
            // en caso de que haya adelanto
            if ($idadelanto>0) {
              $detalle="Adelanto a ".ordinal($cuotaPago+1)." Mensualidad";
              $cantidad=1;
              $precio=$idmonto;
              $estado=1;
              $val4=array(
                "idfactura"=>"'$idfactura'",
                "detalle"=>"'$detalle'",
                "cantidad"=>"'$cantidad'",
                "precio"=>"'$idadelanto'",
                "estado"=>"'$estado'"
              );  
              $facturadet->insertar($val4);
            }
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
      }
      else{
        ?>
              <script  type="text/javascript">
                swal({
                  title: "Descontado!!!",
                  text: "Descuento generado correctamente",
                  type: "warning",
                  showCancelButton: false,
                  confirmButtonColor: "#16c103",
                  confirmButtonText: "OK",
                  cancelButtonText: "P.O.S.",
                  confirmButtonClass: 'btn green',
                  cancelButtonClass: 'btn red',
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm){
                  if (isConfirm) {
                    location.reload();
                  } else {
                    location.reload();
                  }
                });
              </script>
            <?php
      }
  }
  else{
  	?>
      <script type="text/javascript">
        setTimeout(function() {
          Materialize.toast('<span>1 No se pudo realizar el registro</span>', 1500);
        }, 10);
      </script>
    <?php
  }
}
?>