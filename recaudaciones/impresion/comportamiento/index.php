<?php
session_start();
$ruta="../../../";
$folder="";
include_once($ruta."class/dominio.php");
$dominio=new dominio;
include_once($ruta."class/admcontratodelle.php");
$admcontratodelle=new admcontratodelle;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo;
include_once($ruta."class/vtitular.php");
$vtitular=new vtitular;
include_once($ruta."class/sede.php");
$sede=new sede;
include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."class/personaplan.php");
$personaplan=new personaplan;
include_once($ruta."class/admplan.php");
$admplan=new admplan;
include_once($ruta."class/domicilio.php");
$domicilio=new domicilio;
include_once($ruta."class/laboral.php");
$laboral=new laboral;
include_once($ruta."class/cobcartera.php");
$cobcartera=new cobcartera;
include_once($ruta."class/cobcarteradet.php");
$cobcarteradet=new cobcarteradet;
include_once($ruta."class/factura.php");
$factura=new factura;
include_once($ruta."class/usuario.php");
$usuario=new usuario;
include_once($ruta."class/admcontratodelle.php");
$admcontratodelle=new admcontratodelle;
include_once($ruta."class/vcontratoplan.php");
$vcontratoplan=new vcontratoplan;
include_once($ruta."class/vvinculado.php");
$vvinculado=new vvinculado;

include_once($ruta."funciones/funciones.php");
require_once($ruta.'recursos/pdf/tcpdf/tcpdf.php');
include($ruta."recursos/qr/qrlib.php"); 
/******************    SEGURIDAD *************/
extract($_GET);
//******* SEGURIDAD GET *************/
$valor=dcUrl($lblcode);
if (!ctype_digit(strval($valor))) {
  if (!isset($_SESSION["faltaSistema"]))
  {  $_SESSION['faltaSistema']="0"; }
  $_SESSION['faltaSistema']=$_SESSION['faltaSistema']+1;
  header('Location: '.$ruta.'login/salir.php');
}
/**************************************/
$dcar=$cobcartera->muestra($valor);
$destado=$dominio->muestra($dcar['estado']);
$estado=$destado['nombre'];
$dcontrato=$admcontrato->muestra($dcar['idcontrato']);
$dpplan=$personaplan->mostrarUltimo("idcontrato=".$valor);
$dplan=$admplan->muestra($dpplan['idadmplan']);
$dcp=$vcontratoplan->muestra($dcar['idcontrato']);
$idcontrato=$dcar['idcontrato'];
$dejec=$vejecutivo->muestra($dcontrato['idadmejecutivo']);
$dtitular=$vtitular->muestra($dcontrato['idtitular']);
$totalCuotas=$dcp['cuotas']+1;
// **********  obtener organizacion      ***********************************************************/
/***************************************************************************************************/
$dsede=$sede->muestra($dcontrato['idsede']);
$nsede=$dsede['nombre'];

$ejecutivo= $dejec['nombre']." ".$dejec['paterno']." ".$dejec['materno'];
$titular= $dtitular['nombre']." ".$dtitular['paterno']." ".$dtitular['materno'];
$cititular=$dtitular['carnet']." ".$dtitular['expedido'];
$celular=$dtitular['celular'];
$ocupacion=$dtitular['ocupacion'];

$ddet=$admcontratodelle->mostrarUltimo("idcontrato=".$dcar['idcontrato']." and codigo=3116");
$fechaVer=$ddet['fecha'];
$dusVer=$usuario->muestra($ddet['usuariocreacion']);
$dpersona=$persona->muestra($dusVer['idpersona']);
$usuarioVer=$dpersona['nombre']." ".$dpersona['paterno']." ".$dpersona['materno'];
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf->SetPrintHeader(false);
$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('INGLES PARA TODOS');
$pdf->SetTitle('Estado de Cuentas');
$pdf->SetSubject('Estado de Cuentas');
$pdf->SetKeywords('Estado de Cuentas');
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/es.php')) {
    require_once(dirname(__FILE__).'/lang/es.php');
    $pdf->setLanguageArray($l);
}
// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
//$pdf->SetFont('dejavusans', '', 14, '', true);
$pdf->SetFont('helvetica', '', 8);
$pdf->AddPage('L','A4');
// Add a page
// This method has several options, check the source code documentation for more information.
setlocale(LC_ALL, 'es_ES').': ';
// Set some content to print
$html=' 
<style>
.tituloFactura{
  font-size:12px;
  font-weight: bold;
}
.tituloCenda{
  color:red;
}
.letras{
  font-size:7px;
}
.letras2{
  font-size:18px;
}
</style>
<table width="100%"  align="center">
  <tr>
    <td class="letras">
      <center>
        <img src="'.$ruta.'recursos/images/materialize-logo.png" >
        <b>SEDE '.$nsede.'</b>
      </center>
    </td>
    <td><br>
      <div class="tituloFactura">ESTADO DE CUENTAS</div>
    </td>
    <td><br>
    <table border="1">
      <tr>
        <td>
          <table class="letras" cellpadding="2">
            <tr>
              <td align="right">
                USUARIO :
              </td>
              <td align="left">
                <b>'.$_SESSION["usuario"].'</b>
              </td>
            </tr>
            <tr>
              <td align="right">
                FECHA :
              </td>
              <td align="left">
                <b>'.date("Y-m-d").'</b>
              </td>
            </tr>
            <tr>
              <td align="right">
                HORA :
              </td>
              <td align="left">
                <b>'.date("H:i:s").'</b>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>                     
    </td>
  </tr>
</table>';
$pdf->SetFont('helvetica', '', 9);
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$html='
<style>
.tituloCenda{
  text-align:center;
  font-weight: bold;
  font-size:10px;
}
.sMoneda{
  text-align: right;
}
.scenter{
  text-align: center;
}
.sfila{
  border-bottom: solid 1px #ddd;
}
.letras{
  font-size:6px;
  text-align: center;
}
.letras4{
  font-size:8px;
}
.cabeceraCentro{
  padding: 1px;
  border-top: solid 1px #ddd;
  border-bottom: solid 1px #ddd;
  text-align:center;
}
.textocentro{
  text-align:center;
}
.cabecera2{
  border: solid 1px white;
  font-weight: bold;
}
.cabecera3{
  border: solid 5px white;
  font-weight: bold;
}
.bggray{
  background-color:#dddddd;
}
</style>
<table width="100%" cellpadding="1">
  <tr style="background-color:#dddddd;">
    <td class="cabecera3" style="text-align:center; font-size:10px;">DATOS DE CONTRATO</td>
    <td class="cabecera3" style="text-align:center; font-size:10px;">DATOS DE TITULAR</td>
  </tr>
  <tr>
    <td>
      <table width="100%" cellpadding="3">
        <tr>
          <td class="bggray cabecera3" width="65">Nº MATRICULA:</td>
          <td width="140">'.$dcontrato['nrocontrato'].'</td>
          <td class="bggray cabecera3" width="70">Nº CUENTA:</td>
          <td width="135">'.$dcontrato['cuenta'].'</td>
        </tr>
        <tr>
          <td class="bggray cabecera3" >SEDE : </td>
          <td>'.$nsede.'</td>
          <td class="bggray cabecera3">ESTADO: </td>
          <td>'.$estado.'</td>
        </tr>
        <tr>
          <td class="bggray cabecera3" >PLAN : </td>
          <td>'.$dcp['nombre'].'</td>
          <td class="bggray cabecera3">PRECIO BASICO: </td>
          <td>'.$dcp['inversion'].' Bs.-</td>
        </tr>
        <tr>
          <td class="bggray cabecera3" >CUOTA 1 : </td>
          <td>'.$dcar['pagadoprod'].'</td>
          <td class="bggray cabecera3">CUOTA MES: </td>
          <td>'.$dcp['mensualidad'].'</td>
        </tr>
        <tr>
          <td class="bggray cabecera3" >PRIMER VENC. : </td>
          <td>'.$dcar['fechainicio'].'</td>
          <td class=" cabecera3"></td>
          <td></td>
        </tr>
        <tr>
          <td class="bggray cabecera3" >VERIFICADOR : </td>
          <td>'.$usuarioVer.'</td>
          <td class="bggray cabecera3">FECHA VER.: </td>
          <td>'.$fechaVer.'</td>
        </tr>
      </table>
    </td>
    <td>
      <table width="100%" cellpadding="3">
        <tr>
          <td class="bggray cabecera3" width="48">NOMBRE:</td>
          <td width="140">'.$titular.'</td>
          <td class="bggray cabecera3" width="60">CARNET:</td>
          <td width="135">'.$cititular.'</td>
        </tr>
        <tr>
          <td class="bggray cabecera3" >CELULAR: </td>
          <td>'.$celular.'</td>
          <td class="bggray cabecera3">OCUPACION: </td>
          <td>'.$ocupacion.'</td>
        </tr>
        ';
        foreach($domicilio->mostrarTodo("idpersona=".$dtitular['idpersona']) as $f)
        {
        $html=$html.'
          <tr>
            <td class="bggray cabecera3">DIR. DOM.: </td>
            <td>'.$f['idbarrio']." ".$f['nombre'].'</td>
            <td class="bggray cabecera3">TELF. DOM.:</td>
            <td>'.$f['telefono'].'</td>
          </tr>
        ';
        }
        foreach($laboral->mostrarTodo("idpersona=".$dtitular['idpersona']) as $f)
        {
        $html=$html.'
          <tr>
            <td class="bggray cabecera3">DIR. OF.: </td>
            <td>'.$f['idbarrio']." ".$f['nombre'].'</td>
            <td class="bggray cabecera3">TELF. OF.:</td>
            <td>'.$f['telefono'].'</td>
          </tr>
          ';
        }
        $html=$html.'
        <tr>
          <td></td>
          <td class=" cabecera3">BENEFICIARIO(S)</td>
          <td></td>
          <td></td>
        </tr>
        ';
        $cont=1;
        foreach($vvinculado->mostrarTodo("idpersonaplan=".$dcontrato['idpersonaplan']) as $f){
        $html=$html.'
          <tr>
            <td class="bggray cabecera3">BEN('.$cont.')</td>
            <td>'.$f['nombre'].' '.$f['paterno'].' '.$f['materno'].'</td>
            <td></td>
            <td></td>
          </tr>';
          $cont++;
        }
        $html=$html.'
      </table>
    </td>
  </tr>
</table>';
$html=$html.'<br><br>
<h3>COMPORTAMIENTO PAGO POR RECORD DE PRODUCCION</h3>
<table border="0" align="center" cellpadding="2" width="704">
  <tr style="background-color:#dddddd;">
    <td class="cabecera2 textocentro" width="48"> FECHA </td>
    <td class="cabecera2 textocentro" width="48"> HORA </td>
    <td class="cabecera2 textocentro" width="35"> CUOTA </td>
    <td class="cabecera2 textocentro" width="40"> MONTO PAGADO </td>
    <td class="cabecera2 textocentro" width="50"> SALDO </td>
    <td class="cabecera2 textocentro" width="68"> TIPO PAGO </td>
    <td class="cabecera2 textocentro" width="48"> FACTURA </td>
    <td class="cabecera2 textocentro" width="48"> EJECUTIVO </td>
    <td class="cabecera2 textocentro" width=""> DETALLE </td>
  </tr>';
$pdf->SetFont('helvetica', '', 7);
  //$montoTotal=0;
  foreach($admcontratodelle->mostrarTodo("idcontrato=$idcontrato and codigo=3113") as $f)
  {

    $dfact=$factura->muestra($f['idfactura']);
    $facNro=$dfact['nro'];
    $dus=$usuario->muestra($f['usuariocreacion']); 
    $tipo="";
    $codigoP="";
    switch ($f['tiopago']) {
      case 1:
        $tipo="EF";
        break;
      case 2:
        $tipo="TC";
        break;
      case 3:
        $tipo="TD";
        break;
    }
    $html=$html.'
    <tr>
      <td class="sfila textocentro"> '.$f['fecha'].'</td>
      <td class="sfila textocentro"> '.$f['hora'].'</td>
      <td class="sfila textocentro"> '."1 *".$totalCuotas.'</td>
      <td class="sfila sMoneda"> '.number_format($f['monto'], 2, '.', ' ').'</td>
      <td class="sfila sMoneda"> '.number_format($f['saldo'], 2, '.', ' ').'</td>
      <td class="sfila textocentro"> '.$tipo.'</td>
      <td class="sfila textocentro"> '.$facNro.'</td>
      <td class="sfila textocentro"> '.$dus['usuario'].'</td>
      <td class="sfila "> '.$f['detalle'].'</td>
    </tr>';
  }
  $html=$html.'

 </table>
 ';
 $html=$html.'
<h3>COMPORTAMIENTO PAGO POR CARTERA</h3>
<table border="0" align="center" cellpadding="2" width="100%">
  <tr style="background-color:#dddddd;">
    <td class="cabecera2 textocentro" width="45"> FECHA </td>
    <td class="cabecera2 textocentro" width="37"> HORA </td>
    <td class="cabecera2 textocentro" width="35"> CUOTA </td>
    <td class="cabecera2 textocentro" width="38"> MONEDA </td>
    <td class="cabecera2 textocentro" width="50"> SALDO ANTERIOR </td>
    <td class="cabecera2 textocentro" width="40"> MONTO PAGADO </td>
    <td class="cabecera2 textocentro" width="40"> DESC. </td>
    <td class="cabecera2 textocentro" width="50"> SALDO </td>
    <td class="cabecera2 textocentro" width="68"> TIPO PAGO </td>
    <td class="cabecera2 textocentro" width="48"> FACTURA </td>
    <td class="cabecera2 textocentro" width="48"> DIAS MORA </td>
    <td class="cabecera2 textocentro" width="48"> EJECUTIVO </td>
    <td class="cabecera2 textocentro" width=""> DETALLE </td>
  </tr>';
$pdf->SetFont('helvetica', '', 7);
  $montoTotal=0;
  foreach($cobcarteradet->mostrarTodo("idcartera=$valor") as $f)
  {
    $montoTotal=$montoTotal+$f['monto'];
    $dfact=$factura->muestra($f['idfactura']); 
    $dus=$usuario->muestra($f['usuariocreacion']); 
    $tipo="";
    $codigoP="";
    switch ($f['tipopago']) {
      case 1:
        $tipo="EF";
        break;
      case 2:
        $tipo="TC-".$f['referencia']." / ".$f['lote'];
        break;
      case 3:
        $tipo="TD-".$f['referencia']." / ".$f['lote'];
        break;
    }
    $cuotaC=$f['cuota'];
    $html=$html.'
    <tr>
      <td class="sfila textocentro"> '.$f['fecha'].'</td>
      <td class="sfila textocentro"> '.$f['horacreacion'].'</td>
      <td class="sfila textocentro"> '.$cuotaC."*".$totalCuotas.'</td>
       <td class="sfila textocentro"> '.$f['moneda'].'</td>
      <td class="sfila sMoneda"> '.number_format($f['saldoant'], 2, '.', ' ').'</td>
      <td class="sfila sMoneda"> '.number_format($f['monto'], 2, '.', ' ').'</td>
      <td class="sfila sMoneda"> '.number_format($f['descuento'], 2, '.', ' ').'</td>
      <td class="sfila sMoneda"> '.number_format($f['saldo'], 2, '.', ' ').'</td>
      <td class="sfila textocentro"> '.$tipo.'</td>
      <td class="sfila textocentro"> '.$dfact['nro'].'</td>
      <td class="sfila textocentro"> '.$f['diasmora'].'</td>
      <td class="sfila textocentro"> '.$dus['usuario'].'</td>
      <td class="sfila"> '.$f['fechaBase'].' '.$f['glosa'].'</td>
    </tr>';
  }
  $html=$html.'
      <tr>
      <td class="sfila textocentro"></td>
      <td class="sfila textocentro"> </td>
      <td class="sfila textocentro"> </td>
      <td class="sfila cabecera2 sMoneda"> TOTAL: </td>
         <td class="sfila sMoneda"> </td>
      <td class="sfila cabecera2 sMoneda"> '.number_format($montoTotal, 2, '.', ' ').'</td>
      
      <td class="sfila textocentro"></td>
      <td class="sfila textocentro"></td>
      <td class="sfila textocentro"></td>
      <td class="sfila textocentro"></td>
      <td class="sfila textocentro"></td>
    </tr>
 </table>
 ';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('EstadoCuentas-'.$valor.'.pdf', 'I');

 ?>
