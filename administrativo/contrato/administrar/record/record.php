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
include_once($ruta."class/admplan.php");
$admplan=new admplan;
include_once($ruta."class/personaplan.php");
$personaplan=new personaplan;
include_once($ruta."class/titular.php");
$titular=new titular;
include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo;
include_once($ruta."class/admorgani.php");
$admorgani=new admorgani;
include_once($ruta."class/sede.php");
$sede=new sede;
include_once($ruta."class/admorganizacion.php");
$admorganizacion=new admorganizacion;
include_once($ruta."funciones/funciones.php");
require_once($ruta.'recursos/pdf/tcpdf/tcpdf.php');
include($ruta."recursos/qr/qrlib.php"); 
/******************    SEGURIDAD *************/
//******* SEGURIDAD GET *************/
extract($_GET);
$valor=dcUrl($lblcode);
if (!ctype_digit(strval($valor))) {
  if (!isset($_SESSION["faltaSistema"]))
  {  $_SESSION['faltaSistema']="0"; }
  $_SESSION['faltaSistema']=$_SESSION['faltaSistema']+1;
  header('Location: '.$ruta.'login/salir.php');
}
$dcontratodet=$admcontratodelle->mostrar($valor);
$dcontratodet=array_shift($dcontratodet);
$idcontrato=$dcontratodet['idcontrato'];

// **********  obtener organizacion      ***********************************************************/
$dcontr=$admcontrato->muestra($idcontrato);
$dorg=$admorgani->muestra($dcontr['idorganigrama']);
$dorgz=$admorganizacion->muestra($dorg['idadmorganizacion']);
$norgz=$dorgz['nombre'];

/***************************************************************************************************/
$dcontrato=$admcontrato->muestra($dcontratodet['idcontrato']);

$dsede=$sede->muestra($dcontrato['idsede']);
$nsede=$dsede['nombre'];

$dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
$dpersona=$persona->mostrar($dtit['idpersona']);
$dpersona=array_shift($dpersona);
$dejecutivo=$vejecutivo->muestra($dcontrato['idadmejecutivo']);
$dperplan=$personaplan->mostrarUltimo("idcontrato=".$idcontrato);
$dplan=$admplan->mostrar($dperplan['idadmplan']);
$dplan=array_shift($dplan);
$ejecutivo= $dejecutivo['nombre']." ".$dejecutivo['paterno']." ".$dejecutivo['materno'];
$titular= $dpersona['nombre']." ".$dpersona['paterno']." ".$dpersona['materno'];
$codeContents = $idcontrato.'|'.$dcontrato['nrocontrato'].'|'.$dcontratodet['monto'].'|'.$dcontrato['abono'].'|'.$titular.'|'.$ejecutivo.'|'.$dcontratodet['fecha']; 

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf->SetPrintHeader(false);
$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('INGLES PARA TODOS');
$pdf->SetTitle('RECORD DE PRODUCCION');
$pdf->SetSubject('SWCGB');
$pdf->SetKeywords('RECORD DE PRODUCCION');


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
            <div class="tituloFactura">RECORD DE PRODUCCION</div>
            </td>
            <td><br>
            <table border="1">
              <tr>
                <td>
                  <table class="letras" cellpadding="2">
                    <tr>
                      <td align="right">
                        Nº&nbsp;RECORD :
                      </td>
                      <td align="left">
                        <b>'.$dcontratodet['record'].'</b>
                      </td>
                    </tr>
                    <tr>
                      <td align="right">
                        Nº&nbsp;CONTRATO :
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
                        <b>'.$dcontratodet['fecha'].'</b>
                      </td>
                    </tr>
                    <tr>
                      <td align="right">
                        HORA :
                      </td>
                      <td align="left">
                        <b>'.$dcontratodet['hora'].'</b>
                      </td>
                    </tr>

                  </table>
                </td>
              </tr>
            </table>                     
            </td>
          </tr>
        </table';
        $pdf->SetFont('helvetica', '', 10);
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$html='
<style>
.tituloCenda{
  text-align:center;
  font-weight: bold;
  font-size:10px;
}
.fondo{
  background-color:#dbdbdb;
}
.sMoneda{
  text-align: right;
  font-size:8px;
}
.scenter{
  text-align: center;
  font-size:8px;
}
.sfila{
  border-right: solid 1px #fff;
  border-bottom: solid 1px #606060;
  border-left: solid 1px #fff;
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
  border-top: solid 1px white;
  border-bottom: solid 1px white;
}
.cabecera2{
  border-top: solid 1px #606060;
  border-bottom: solid 1px #606060;
  font-weight: bold;
  font-size:7px;
}
</style>
  <table border="0" class="sfila" cellpadding="2" width="704">
  <tr>
    <td class="cabecera2" width="230">
      <div class="cabeceraCentro scenter">
        TITULAR
      </div>
    </td>
    <td class="cabecera2" width="70">
      <div class="sMoneda">
        MONTO
      </div>
    </td>
    <td class="cabecera2" width="130">
      <div class="sMoneda">
        SALDO PRIMERA CUOTA
      </div>
    </td>
    
    <td class="cabecera2" width="100">
      <div class="sMoneda">
        SALDO CARTERA
      </div>
    </td>
  </tr>';
  $abono=$dcontrato['abono'];
  if ($dcontrato['abono']<0) {
    $abono=0;
  }
   $html=$html.'
     <tr height="80" class="sfila">
       <td class="scenter"> '.$titular.'</td>
       <td class="sMoneda">'.number_format($dcontratodet['monto'], 2, '.', ',').'</td>
       <td class="sMoneda">'.number_format($abono, 2, '.', ',').'</td>
       <td class="sMoneda">'.number_format($dcontratodet['saldocartera'], 2, '.', ',').'</td>
     </tr>';
    $fechca = date_create($dcontratodet['fecha']);
    $fechaQr=date_format($fechca, 'd/m/Y');
    $costototal=$dcontratodet['monto'];
    
     
    // we need to generate filename somehow,  
    // with md5 or with database ID used to obtains $codeContents... 
    $fileName = 'qr/'.$valor.'.png'; 
     
    $pngAbsoluteFilePath = $fileName; 
    $urlRelativeFilePath = $fileName; 
    if (!file_exists($pngAbsoluteFilePath)) { 
        QRcode::png($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_L, 3);
    } 
     if ($dcontratodet['tiopago']==1) {
        $tipoPago="Pago en Efectivo";
     }
     elseif ($dcontratodet['tiopago']==2) {
       $tipoPago=" Por Tarjeta de Crédito, REF:".$dcontratodet['referencia']."-LOTE: ".$dcontratodet['lote'];
     }else{
        $tipoPago=" Por Tarjeta de Débito, REF:".$dcontratodet['referencia']."-LOTE: ".$dcontratodet['lote'];
     }
  $html=$html.'

 </table>
 <table style="background-color:#dbdbdb;" cellpadding="5">
    
    <tr>
      <td width="230"><b>Son: '.num2letras(number_format($dcontratodet['monto'], 2, '.', ''))." Bolivianos ".'</b></td>
      <td width="300">'.$tipoPago.'</td>
    </tr>
    
  </table>
 ';
  $html=$html.'
  <table width="704">
  <tr>
    <td>
      ______________________________________________________________________________________________
    </td>
  </tr>
  </table>
  <table>
  <tr>
    <td width="417">
      <table cellspacing="1" cellpadding="2">
      <tr>
        <td class="letras4 fondo" width="80"><br>PLAN :</td>
        <td class="letras4 " width="320"><b> '.$dplan['nombre'].' '.$dplan['personas'].' PERSONA(S)</b></td>
      </tr>
      <tr>
        <td class="letras4 fondo">COSTO PLAN :</td>
        <td class="letras4"><b> '.number_format($dplan['inversion'], 2, '.', ',').' Bs.-</b></td>
      </tr>
      <tr>
        <td class="letras4 fondo">PRIMERA CUOTA :</td>
        <td class="letras4"><b> '.number_format($dplan['pagoinicial'], 2, '.', ',').' Bs.-</b></td>
      </tr>
      <tr>
        <td class="letras4 fondo">TOTAL PAGADO:</td>
        <td class="letras4"><b> '.number_format($dplan['inversion']-$dcontr['pagado'], 2, '.', ',').' Bs.-</b></td>
      </tr>
      <tr>
        <td class="letras4 fondo">ASESOR:</td>
        <td class="letras4"><b> '.$dejecutivo['nombre'].' '.$dejecutivo['paterno'].' '.$dejecutivo['materno'].'</b></td>
      </tr>
      <tr>
        <td class="letras4 fondo">ORGANIZACION:</td>
        <td class="letras4"><b> '.$norgz.'</b></td>
      </tr>
      <tr>
        <td class="letras4 fondo">OBSERVACIONES:</td>
        <td class="letras4" ><b> '.$dcontratodet['detalle'].'</b></td>
      </tr>
     </table>
    </td>
    <td><img width="100px" src="'.$urlRelativeFilePath.'" /></td>
  </tr>
 </table>
 _______________________________________________________________________________________________
';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('Record.pdf', 'I');

 ?>
