<?php 
$ruta="../../../../../";
$folder="";

/******************    SEGURIDAD *************/
session_start();
/********************************************/

include_once($ruta."class/vtitular.php");
$vtitular=new vtitular;
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo;
include_once($ruta."class/vcontratoplan.php");
$vcontratoplan=new vcontratoplan;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."class/cobcartera.php");
$cobcartera=new cobcartera;
include_once($ruta."class/personaplan.php");
$personaplan=new personaplan;
include_once($ruta."class/admplan.php");
$admplan=new admplan;
include_once($ruta."class/admplanes.php");
$admplanes=new admplanes;
include_once($ruta."class/usuario.php");
$usuario=new usuario;
include_once($ruta."class/factura.php");
$factura=new factura;
include_once($ruta."class/vfactura.php");
$vfactura=new vfactura;
include_once($ruta."class/sede.php");
$sede=new sede;
include_once($ruta."class/vcontratodet.php");
$vcontratodet=new vcontratodet;
include_once($ruta."class/admcontratodelle.php");
$admcontratodelle=new admcontratodelle;

include_once($ruta."funciones/funciones.php");
require_once($ruta.'recursos/pdf/tcpdf/tcpdf.php');
/******************    SEGURIDAD *************/
extract($_GET);
$idsede=dcUrl($lblcode);
$dse=$sede->muestra($idsede);
//******* SEGURIDAD GET *************/
/**************************************/
$totalCuotas=0;
// **********  obtener organizacion      ***********************************************************/
/***************************************************************************************************/
$nsede=$dse['nombre'];
$nroplanilla=diferenciaDias(obtenerAnio($fechaGen)."-01"."-01", $fechaGen)+1;
//$nroplanilla=substr($fechaGen, 5, 2);

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
    <td class="letras" width="30%">
      <center>
        <img src="'.$ruta.'recursos/images/materialize-logo.png" >
        <b>SEDE '.$nsede.'</b>
      </center>
    </td>
    <td width="50%"><br>
      <div class="tituloFactura">PARTE DIARIO DE PRODUCCION-INGLES PARA TODOS<br>'.strtoupper(obtenerFechaLetra($fechaGen)).'</div>
    </td>
    <td width="20%"><br>
    <table border="1">
      <tr>
        <td>
          <table class="letras" cellpadding="2">
          <tr>
              <td align="right">
                PLANILLA :
              </td>
              <td align="left">
                <b style="font-size:10px;">'.$nroplanilla.'</b>
              </td>
            </tr>
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
            <tr>
              <td align="right">
                T/C :
              </td>
              <td align="left">
                <b>6.96</b>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>                     
    </td>
  </tr>
</table>';
$pdf->SetFont('helvetica', '', 8);
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
  border-bottom: solid 1px #888;
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
.textoIZ{
  text-align:left;
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
    <td class="cabecera3" style="text-align:center; font-size:10px;">DEPOSITOS EN EFECTIVO Y CHEQUES</td>
  </tr>
</table>';
$consulta="";
$html=$html.$consulta.'
<table border="0" align="center" cellpadding="2" width="100%">
  <tr style="background-color:#dddddd;">
    <td class="cabecera2 textocentro" width="45"> Fecha Dep</td>
    <td class="cabecera2 textocentro" width="37"> Hora Dep. </td>
    <td class="cabecera2 textocentro" width="140"> Titular </td>
    <td class="cabecera2 textocentro" width="50"> Carnet </td>
    <td class="cabecera2 textocentro" width="50"> Plan </td>
    <td class="cabecera2 textocentro" width="38"> Matricula </td>
    <td class="cabecera2 textocentro" width="35"> Factura </td>
    <td class="cabecera2 textocentro" width="34"> Record </td>
    <td class="cabecera2 textocentro" width="27"> Moneda </td>
    <td class="cabecera2 textocentro" width="40"> $us </td>
    <td class="cabecera2 textocentro" width="40"> Monto </td>
    <td class="cabecera2 textocentro" width="40"> Saldo Cuo.Ini. </td>
    <td class="cabecera2 textocentro" width="40"> Saldo Cartera. </td>
    <td class="cabecera2 textocentro" width="50"> Ejecutivo </td>
    <td class="cabecera2 textocentro" width=""> Observaciones </td>
  </tr>';
$pdf->SetFont('helvetica', '', 6);
  $montoDep=0;
  $montoDesc=0;
  $cantDep=0;
  $dDep=$vcontratodet->mostrarTodo("consolidado=2 and anulado=0 and idsede=$idsede and tiopago=1 and fecha='$fechaGen'");
  $tenor="";
  if (count($dDep)>0) {
    $tenor="TOTAL :";
  }
  else{
    $tenor="---- SIN MOVIMIENTOS ----";
  }

  foreach($vcontratodet->mostrarTodo("consolidado=2 and anulado=0 and idsede=$idsede and tiopago=1 and fecha='$fechaGen'","fechadep,horadep") as $f)
  {
    $cantDep++;
    $montoDep=$montoDep+$f['monto'];
    $dpl=$personaplan->muestra($f['idpersonaplan']);
    $dplan=$admplan->muestra($dpl['idadmplan']);
    $dplanes=$admplanes->muestra($dplan['idadmplanes']);
    $dtit=$vtitular->muestra($f['idtitular']);
    $deje=$vejecutivo->muestra($f['idadmejecutivo']); 
    $montoDesc=$montoDesc+$f['monto'];
    $dfact=$factura->muestra($f['idfactura']); 
    $dus=$usuario->muestra($f['usuariocreacion']);
    $array = explode(" ", $deje['nombre']); 
    $tipo="";
    $codigoP="";
    switch ($f['tiopago']) {
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
    $html=$html.'
    <tr>
      <td class="sfila textocentro" > '.$f['fechadep'].'</td>
      <td class="sfila textocentro"> '.$f['horadep'].'</td>
      <td class="sfila textocentro"> '.$dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'].'</td>
      <td class="sfila textocentro"> '.$dtit['carnet'].'</td>
      <td class="sfila textocentro"> '.$dplanes['short']." ".$dplan['nombre'].'</td>
      <td class="sfila textocentro"> '.$f['nrocontrato'].'</td>
      <td class="sfila textocentro"> '.$dfact['nro'].'</td>
      <td class="sfila textocentro"> '.$f['record'].'</td>
      <td class="sfila textocentro"> '.$f['moneda'].'</td>
      <td class="sfila sMoneda"> '.number_format(0, 2, '.', ' ').'</td>
      <td class="sfila sMoneda"> '.number_format($f['monto'], 2, '.', ' ').'</td>
      <td class="sfila sMoneda"> '.number_format($f['saldo'], 2, '.', ' ').'</td>
      <td class="sfila sMoneda"> '.number_format($f['saldocartera'], 2, '.', ' ').'</td>
      <td class="sfila textocentro"> '.substr(strtoupper ($array[0]), 0, 1).". ".$deje['paterno'].'</td>
      <td class="sfila textocentro"> '.$f['obs'].'</td>
    </tr>';
  }
  $html=$html.'
  </table>
  <table border="0" align="center" cellpadding="2" width="100%">
      <tr>
      <td class="sfila cabecera2 sMoneda" width="481">'.$tenor.'</td>
      <td class="sfila cabecera2 sMoneda" width="55"> '.number_format($montoDep, 2, '.', ' ').'</td>
    </tr>
 </table>
 <br><br><br>
 <table width="100%" cellpadding="1">
  <tr style="background-color:#dddddd;">
    <td class="cabecera3" style="text-align:center; font-size:10px;">DEPOSITOS MEDIANTE TARJETA DE CREDITO Y DEBITO</td>
  </tr>
</table>
 ';
 $html=$html.'
<table border="0" align="center" cellpadding="2" width="100%">
  <tr style="background-color:#dddddd;">
    <td class="cabecera2 textocentro" width="45"> Fecha Dep</td>
    <td class="cabecera2 textocentro" width="37"> Hora Dep. </td>
    <td class="cabecera2 textocentro" width="140"> Titular </td>
    <td class="cabecera2 textocentro" width="50"> Carnet </td>
    <td class="cabecera2 textocentro" width="50"> Plan </td>
    <td class="cabecera2 textocentro" width="38"> Matricula </td>
    <td class="cabecera2 textocentro" width="35"> Factura </td>
    <td class="cabecera2 textocentro" width="34"> Record </td>
    <td class="cabecera2 textocentro" width="27"> Referencia </td>
    <td class="cabecera2 textocentro" width="40"> Lote </td>
    <td class="cabecera2 textocentro" width="40"> Monto </td>
    <td class="cabecera2 textocentro" width="40"> Saldo Cuo.Ini. </td>
    <td class="cabecera2 textocentro" width="40"> Saldo Cartera. </td>
    <td class="cabecera2 textocentro" width="50"> Ejecutivo </td>
    <td class="cabecera2 textocentro" width=""> Observaciones </td>
  </tr>';
$pdf->SetFont('helvetica', '', 6);
  $montoTj=0;
  $montoDesc=0;
  $cantTj=0;
  $dDep=$vcontratodet->mostrarTodo("consolidado=2 and anulado=0 and idsede=$idsede and tiopago>1 and fecha='$fechaGen'");
  $tenor="";
  if (count($dDep)>0) {
    $tenor="TOTAL :";
  }
  else{
    $tenor="---- SIN MOVIMIENTOS ----";
  }
  foreach($vcontratodet->mostrarTodo("consolidado=2 and anulado=0 and idsede=$idsede and tiopago>1 and fecha='$fechaGen'","fechadep,horadep") as $f)
  {
    $cantTj++;
    $montoTj=$montoTj+$f['monto'];
    $dtit=$vtitular->muestra($f['idtitular']);
    $dpl=$personaplan->muestra($f['idpersonaplan']);
    $dplan=$admplan->muestra($dpl['idadmplan']);
    $dplanes=$admplanes->muestra($dplan['idadmplanes']);
    $deje=$vejecutivo->muestra($f['idadmejecutivo']); 
    $montoDesc=$montoDesc+$f['monto'];
    $dfact=$factura->muestra($f['idfactura']); 
    $dus=$usuario->muestra($f['usuariocreacion']);
    $array = explode(" ", $deje['nombre']); 
    $tipo="";
    $codigoP="";
    switch ($f['tiopago']) {
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
    $html=$html.'
    <tr>
      <td class="sfila textocentro" > '.$f['fechadep'].'</td>
      <td class="sfila textocentro"> '.$f['horadep'].'</td>
      <td class="sfila textocentro"> '.$dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'].'</td>
      <td class="sfila textocentro"> '.$dtit['nit'].'</td>
      <td class="sfila textocentro"> '.$dplanes['short']." ".$dplan['nombre'].'</td>
      <td class="sfila textocentro"> '.$f['nrocontrato'].'</td>
      <td class="sfila textocentro"> '.$dfact['nro'].'</td>
      <td class="sfila textocentro"> '.$f['record'].'</td>
      <td class="sfila textocentro"> '.$f['referencia'].'</td>
      <td class="sfila textocentro"> '.$f['lote'].'</td>
      <td class="sfila sMoneda"> '.number_format($f['monto'], 2, '.', ' ').'</td>
      <td class="sfila sMoneda"> '.number_format($f['saldo'], 2, '.', ' ').'</td>
      <td class="sfila sMoneda"> '.number_format($f['saldocartera'], 2, '.', ' ').'</td>
      <td class="sfila textocentro"> '.substr(strtoupper ($array[0]), 0, 1).". ".$deje['paterno'].'</td>
      <td class="sfila textocentro"> '.$f['obs'].'</td>
    </tr>';
  }
  $html=$html.'
  </table>
  <table border="0" align="center" cellpadding="2" width="100%">
    <tr>
      <td class="sfila cabecera2 sMoneda" width="481">'.$tenor.'</td>
      <td class="sfila cabecera2 sMoneda" width="55"> '.number_format($montoTj, 2, '.', ' ').'</td>
    </tr>
 </table>
<br><br><br>
 <table width="33%" cellpadding="1">
  <tr style="background-color:#dddddd;">
    <td class="cabecera3" style="text-align:center; font-size:10px;">CONTRATOS ANULADOS EN EL DIA</td>
  </tr>
</table>
 ';
 $html=$html.'
<table border="0" align="center" cellpadding="2" width="100%">
  <tr style="background-color:#dddddd;">
    <td class="cabecera2 textocentro" width="60"> Fecha </td>
    <td class="cabecera2 textocentro" width="55"> Hora </td>
    <td class="cabecera2 textocentro" width="80"> Matrícula </td>
    <td class="cabecera2 textocentro" width="60"> Detalle </td>
  </tr>';
$pdf->SetFont('helvetica', '', 7);
  $montoServ=0;
  $cantServ=0;
  $dDep=$vcontratodet->mostrarTodo("codigo in (3115,3119) and idsede=$idsede and fecha='$fechaGen'");
  $tenor="";
  if (count($dDep)>0) {
    $tenor="TOTAL :";
  }
  else{
    $tenor="---- SIN MOVIMIENTOS ----";
  }
  foreach($vcontratodet->mostrarTodo("codigo in (3115,3119) and idsede=$idsede and fecha='$fechaGen'","fechadep,horadep") as $f)
  {
    $cantServ++;
    $dus=$usuario->muestra($f['usuariocreacion']);
    $estado="";
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
    $html=$html.'
    <tr>
      <td class="sfila textocentro"> '.$f['fecha'].'</td>
      <td class="sfila textocentro"> '.$f['fecha'].'</td>
      <td class="sfila sMoneda"> '.$f['nrocontrato'].'</td>
      <td class="sfila textocentro"> '.$f['detalle'].'</td>
    </tr>';
  }
  $html=$html.'
  </table>
  <table border="0" align="center" cellpadding="2" width="100%">
      <tr>
      <td class="sfila cabecera2 sMoneda" width="255">'.$tenor.'</td>
    </tr>
 </table>
 <br><br><br>
 <table width="50%" cellpadding="1">
  <tr style="background-color:#dddddd;">
    <td class="cabecera3" style="text-align:center; font-size:10px;">FACTURAS ANULADAS DURANTE EL DIA</td>
  </tr>
</table>
 ';
 $html=$html.'
<table border="0" align="center" cellpadding="2" width="100%">
  <tr style="background-color:#dddddd;">
    <td class="cabecera2 textocentro" width="60"> Fecha </td>
    <td class="cabecera2 textocentro" width="55"> Hora </td>
    <td class="cabecera2 textocentro" width="55"> Número </td>
    <td class="cabecera2 textocentro" width="80"> Matrícula </td>
    <td class="cabecera2 textocentro" width="60"> Monto </td>
    <td class="cabecera2 textocentro" width="79"> Estado </td>
  </tr>';
$pdf->SetFont('helvetica', '', 7);
  $montoTotal=0;
  $dDep=$vfactura->mostrarTodo("estado=2 and idsede=$idsede and fechanul='$fechaGen'","nro");
  $tenor="";
  if (count($dDep)>0) {
    $tenor="VALOR ANULADO :";
  }
  else{
    $tenor="---- SIN MOVIMIENTOS ----";
  }
  foreach($vfactura->mostrarTodo("estado=2 and idsede=$idsede and fechanul='$fechaGen'","nro") as $f)
  {
    $montoTotal=$montoTotal+$f['total'];
    $dus=$usuario->muestra($f['usuariocreacion']);
    $estado="";
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
    $html=$html.'
    <tr>
      <td class="sfila textocentro"> '.$f['fecha'].'</td>
      <td class="sfila textocentro"> '.$f['horacreacion'].'</td>
      <td class="sfila textocentro"> '.$f['nro'].'</td>
      <td class="sfila sMoneda"> '.$f['matricula'].'</td>
      <td class="sfila sMoneda"> '.$f['total'].'</td>
      <td class="sfila textocentro"> '.$estado.'</td>
    </tr>';
  }
  $html=$html.'
  </table>
  <table border="0" align="center" cellpadding="2" width="100%">
      <tr>
      <td class="sfila cabecera2 sMoneda" width="255">'.$tenor.'</td>
      <td class="sfila cabecera2 sMoneda" width="40"> '.number_format($montoTotal, 2, '.', ' ').'</td>
    </tr>
 </table>
 <br><br><br>
 <table width="60%" cellpadding="1">
  <tr style="background-color:#dddddd;">
    <td class="cabecera3" style="text-align:center; font-size:10px;">RESUMEN GENERAL</td>
  </tr>
</table>
 ';

$cantidadMov=$cantDep+$cantTj+$cantServ;
 $html=$html.'
 <table width="60%" cellpadding="1">
  <tr style="background-color:#dddddd;">
    <td class="cabecera3" style="text-align:center; font-size:10px;">RESUMEN GENERAL</td>
  </tr>
</table>
<table border="0" align="center" cellpadding="2" width="60%">
  <tr>
    <td class="sfila textoIZ" width="10%"> '.$cantDep.' </td>
    <td class="sfila textoIZ" width="70%"> IMPORTES DEPOSITADOS EN EL DIA </td>
    <td class="sfila sMoneda" width="20%">'.number_format($montoDep, 2, '.', ' ').'</td>
  </tr>
  <tr>
    <td class="sfila textoIZ" width="10%"> '.$cantTj.' </td>
    <td class="sfila textoIZ" width="70%"> TARJETAS DE CREDITO RECIBIDAS </td>
    <td class="sfila sMoneda" width="20%"> '.number_format($montoTj, 2, '.', ' ').' </td>
  </tr>
  <tr style="font-size:10px;">
    <td class="sfila cabecera2 textoIZ" width="10%"> '.$cantidadMov.' </td>
    <td class="sfila cabecera2 textoIZ" width="70%"> EFECTIVO DEPOSITADO EN EL BANCO </td>
    <td class="sfila cabecera2 sMoneda" width="20%"> '.number_format($montoDep+$montoTj, 2, '.', ' ').' </td>
  </tr>
</table>
 ';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('Planilla-'.$nroplanilla.'.pdf', 'I');
?>