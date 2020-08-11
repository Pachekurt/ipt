<?php
session_start();
$ruta="../../../../";
$folder="";
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."class/personaplan.php");
$personaplan=new personaplan;
include_once($ruta."class/admplan.php");
$admplan=new admplan;
include_once($ruta."class/pvo.php");
$pvo=new pvo;
include_once($ruta."class/admcontratodelle.php");
$admcontratodelle=new admcontratodelle;
include_once($ruta."class/sede.php");
$sede=new sede;
include_once($ruta."class/dominio.php");
$dominio=new dominio;
include_once($ruta."class/vorganizacion.php");
$vorganizacion=new vorganizacion;
include_once($ruta."class/vtitular.php");
$vtitular=new vtitular;
include_once($ruta."class/vcontratodet.php");
$vcontratodet=new vcontratodet;
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo;
include_once($ruta."class/factura.php");
$factura=new factura;
include_once($ruta."funciones/funciones.php");
require_once($ruta.'recursos/pdf/tcpdf/tcpdf.php');
/******************    SEGURIDAD *************/
extract($_GET);
$idsede=$_SESSION["idsede"];
$dse=$sede->muestra($idsede);
//******* SEGURIDAD GET *************/
/**************************************/
$totalCuotas=0;
// **********  obtener organizacion      ***********************************************************/
/***************************************************************************************************/
$nsede=$dse['nombre'];
//$nroplanilla=diferenciaDias(obtenerAnio($fechaGen)."-01"."-01", $fechaGen)+1;
//$nroplanilla=substr($fechaGen, 5, 2);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf->SetPrintHeader(false);
$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('INGLES PARA TODOS');
$pdf->SetTitle('PVO PRODUCCION');
$pdf->SetSubject('PVO PRODUCCION');
$pdf->SetKeywords('PVO PRODUCCION');
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
$pdf->AddPage('P','A4');
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
      <div class="tituloFactura">P.V.O. DE PRODUCION DEL <br>'.$fechain.' AL '.$fechafin.'</div>
    </td>
    <td width="20%"><br>
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
    <td class="cabecera3" style="text-align:center; font-size:10px;">DEPOSITOS EN EFECTIVO</td>
  </tr>
</table>';
$consulta="";
$html=$html.$consulta.'
<table border="0" align="center" cellpadding="2" width="100%">
  <tr style="background-color:#dddddd;">
    <td class="cabecera2 textocentro" width="30"> #</td>
    <td class="cabecera2 textocentro" width="30"> Record</td>
    <td class="cabecera2 textocentro" width="37"> Fecha </td>
    <td class="cabecera2 textocentro" width="150"> Titular </td>
    <td class="cabecera2 textocentro" width="90"> Ejecutivo </td>
    <td class="cabecera2 textocentro" width="90"> Organizacion </td>
    <td class="cabecera2 textocentro" width="35"> Nro. Contrato </td>
    <td class="cabecera2 textocentro" width="35"> Cuenta </td>
    <td class="cabecera2 textocentro" width="48"> Fecha Verificacion</td>
    <td class="cabecera2 textocentro" width="19"> Plan </td>
    <td class="cabecera2 textocentro" width="30"> Monto </td>
    <td class="cabecera2 textocentro" width="30"> Factura </td>
    <td class="cabecera2 textocentro"> Abono </td>
    <td class="cabecera2 textocentro"> Reportado </td>
    <td class="cabecera2 textocentro"> Verificado </td>
  </tr>';
$pdf->SetFont('helvetica', '', 6);
  $montoDep=0;
  $montoDesc=0;
  $cantDep=0;
  $dDep=$vcontratodet->mostrarTodo("fecha BETWEEN '$fechain' AND '$fechafin' and codigo=3113 and anulado=0");
  $tenor="";
  if (count($dDep)>0) {
    $tenor="TOTAL :";
  }
  else{
    $tenor="---- SIN MOVIMIENTOS ----";
  } 
  //$drepor=0;

$cantVer= 0;
 $drepor= 0;
   $dabono=0;
$mysqli1 = mysqli_connect("localhost", "duartema_admin", "Jhulios20005", "duartema_nacional"); 


     foreach (($resultado = $mysqli1->query("call pvo('$fechain' , '$fechafin')"))as $dato) {

 //foreach($pvo->sql("call pvo('$fechain' , '$fechafin')") as $dato)
//  {
    $cantDep++;
   // $dcont=$admcontrato->muestra($f['idadmcontrato']);
   // $dpp=$personaplan->muestra($dcont['idpersonaplan']);
   // $dplan=$admplan->muestra($dpp['idadmplan']);
   // $montoDep=$montoDep+$f['monto'];
     $dtit=$vtitular->muestra($dato['idtitular']);
  //  $ddom=$dominio->muestra($f['estado']);
   // $dfact=$factura->muestra($f['idfactura']);
   // $deje=$vejecutivo->muestra($f['idadmejecutivo']);
    //$dorg=$vorganizacion->muestra($f['idorganigrama']);
   // if ($f['codigo']==3116) {
   //   $cantVer++;
   // }
      if ($dato['verificado']=='VERIFICADO') {
        $cantVer= $cantVer+1;
      } 
      if ($dato['reportado']=='REPORTADO') {
        $drepor= $drepor+1;
      }
       if ($dato['abono']=='ABONO') {
        $dabono= $dabono+1;
      }


     $dver=$admcontratodelle->mostrarUltimo("codigo=3116 and idcontrato=".$dato['idadmcontrato']);
    
    $html=$html.'
    <tr>
      <td class="sfila textocentro" > '.$cantDep.'</td>
      <td class="sfila textocentro" > '.$dato['record'].'</td>
      <td class="sfila textocentro"> '.$dato['fecha'].'</td>
      <td class="sfila textoIZ"> '.$dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'].'</td>
      <td class="sfila textoIZ"> '.$dato['nombree']." ".$dato['paternoe'].'</td>
      <td class="sfila textoIZ"> '.$dato['organizacion'].'</td>
      <td class="sfila textocentro"> '.$dato['nrocontrato'].'</td>
      <td class="sfila textocentro"> '.$dato['cuenta'].'</td>
      <td class="sfila textocentro"> '.$dver['fecha'].'</td>
      <td class="sfila textocentro"> '.$dato['short'].'</td>
      <td class="sfila textocentro"> '.$dato['monto'].'</td>
      <td class="sfila textocentro"> '.$dato['nro'].'</td>
      <td class="sfila textocentro"> '.$dato['abono'].'</td>
      <td class="sfila textocentro"> '.$dato['reportado'].'</td>
      <td class="sfila textocentro"> '.$dato['verificado'].'</td>
    </tr>';
  }
  $html=$html.'
  </table>
  <table border="0" align="center" cellpadding="2" width="100%">
      <tr>
      <td class="sfila cabecera2 sMoneda" width="550">'.$tenor.'</td>
      <td class="sfila cabecera2 sMoneda" width="60"> '.number_format($montoDep, 2, '.', ' ').'</td>
    </tr>
 </table>
 <br><br><br>
 <table width="33%" cellpadding="1">
  <tr style="background-color:#dddddd;">
    <td class="cabecera3" style="text-align:center; font-size:10px;">RESUMEN P.V.O.</td>
  </tr>
</table>
 ';
 $html=$html.'
<table border="0"  cellpadding="2" width="100%">
  <tr style="background-color:#dddddd;">
    <td class="cabecera2" width="195"> Detalle </td>
    <td class="cabecera2 textocentro" width="60"> # </td>
  </tr>';
 // $drepor=$admcontrato->mostrarTodo("estado in (63) and fechaestado BETWEEN '$fechain' AND '$fechafin'");
 // $dpresi=$admcontrato->mostrarTodo("estado in (68) and fechaestado BETWEEN '$fechain' AND '$fechafin'");
 // $dabono=$admcontrato->mostrarTodo("estado in (62) and fechaestado BETWEEN '$fechain' AND '$fechafin'");
  $html=$html.'
    
    <tr>
      <td class="sfila ">Abono</td>
      <td class="sfila textocentro">'.$dabono.'</td>
    </tr>
    <tr>
      <td class="sfila ">Reportado</td>
      <td class="sfila textocentro">'.$drepor.'</td>
    </tr>
    <tr>
      <td class="sfila ">VERIFICADOS</td>
      <td class="sfila textocentro">'.$cantVer.'</td>
    </tr>
    
    <tr>
      <td class="sfila ">------------------------------------------</td>
      <td class="sfila textocentro">-------</td>
    </tr>
    ';
    $consulta="SELECT idadmejecutivo, count(*) as cantidad FROM vcontratodet where codigo=3116 and idsede=$idsede and fecha BETWEEN '$fechain' AND '$fechafin' group by idadmejecutivo, codigo ";
    //$dcont=$admcontrato->sql($consulta);
  foreach($vcontratodet->sql($consulta) as $g)
  {
    $deje=$vejecutivo->muestra($g['idadmejecutivo']);
    
    $html=$html.'
    <tr>
      <td class="sfila ">'.$deje['nombre']." ".$deje['paterno']." ".$deje['materno'].'</td>
      <td class="sfila textocentro">'.$g['cantidad'].'</td>
    </tr>';
  }
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('PVO.pdf', 'I');
?>