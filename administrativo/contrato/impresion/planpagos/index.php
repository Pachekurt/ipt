<?php
session_start();
$ruta="../../../../";
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
include_once($ruta."class/personaplan.php");
$personaplan=new personaplan;
include_once($ruta."class/admplan.php");
$admplan=new admplan;
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

$dcontrato=$admcontrato->muestra($valor);
$dpplan=$personaplan->mostrarUltimo("idcontrato=".$valor);
$dplan=$admplan->muestra($dpplan['idadmplan']);
$idcontrato=$valor;
$dejec=$vejecutivo->muestra($dcontrato['idadmejecutivo']);
$dtitular=$vtitular->muestra($dcontrato['idtitular']);
// **********  obtener organizacion      ***********************************************************/
/***************************************************************************************************/
$dsede=$sede->muestra($dcontrato['idsede']);
$nsede=$dsede['nombre'];

$ejecutivo= $dejec['nombre']." ".$dejec['paterno']." ".$dejec['materno'];
$titular= $dtitular['nombre']." ".$dtitular['paterno']." ".$dtitular['materno'];

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf->SetPrintHeader(false);
$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('INGLES PARA TODOS');
$pdf->SetTitle('Plan de Pagos');
$pdf->SetSubject('Plan de Pagos');
$pdf->SetKeywords('Plan de Pagos');


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
$pdf->AddPage('','A4');
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
    </td>
    <td><br>              
    </td>
  </tr>
</table>
<div class="tituloFactura">______PLAN DE PAGOS______</div>
<table >
  <tr>
    <td width="200">
      <table class="letras" cellpadding="1">
        <tr>
          <td align="right">
            MATRICULA :
          </td>
          <td align="left">
            <b>'.$dcontrato['nrocontrato'].'</b>
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
';
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
  border: solid 1px #ddd;
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
</style>
<table border="0" cellpadding="2" width="704">
  <tr style="background-color:;">
    <td class="cabecera2 sMoneda" width="60"> NOMBRE : </td>
    <td width="300">'.$titular.' </td>
  </tr>
</table>
<table border="0" cellpadding="2" width="704">
  <tr style="background-color:#dddddd;">
    <td class="cabecera2 textocentro" width="48"> FECHA </td>
    <td class="cabecera2 textocentro" width="40"> CUOTA </td>
    <td class="cabecera2 textocentro" width="40"> MONTO </td>
    <td class="cabecera2 textocentro" width="48"> SALDO </td>
  </tr>';
$pdf->SetFont('helvetica', '', 7);
    foreach($admcontrato->sql('call duartema_nacional.spplanpagos('.$valor.',0)') as $f){
      $html=$html.'
      <tr>
        <td class="sfila textocentro"> '.$f['fecha'].'</td>
        <td class="sfila textocentro"> '.$f['cuota'].'</td>
        <td class="sfila sMoneda"> '.number_format($f['monto'], 2, '.', ' ').'</td>
        <td class="sfila sMoneda"> '.number_format($f['saldo'], 2, '.', ' ').'</td>
      </tr>';
    }
  $html=$html.'

 </table>
 ';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('historial.pdf', 'I');

 ?>
