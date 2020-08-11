<?php
session_start();
$ruta="../../../";
$folder="";
include_once($ruta."class/vcontratoplan.php");
$vcontratoplan=new vcontratoplan;
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
include_once($ruta."class/dominio.php");
$dominio=new dominio;
include_once($ruta."class/factura.php");
$factura=new factura;
include_once($ruta."class/usuario.php");
$usuario=new usuario;
include_once($ruta."class/cobcartera.php");
$cobcartera=new cobcartera;
include_once($ruta."funciones/funciones.php");
require_once($ruta.'recursos/pdf/tcpdf/tcpdf.php');
include($ruta."recursos/qr/qrlib.php"); 
/******************    SEGURIDAD *************/
extract($_GET);
$deje=$vejecutivo->muestra($idejecutivo);
$dsede=$sede->muestra("idsede=".$deje['idsede']);
//********* SEGURIDAD GET *************/

if ($idejecutivo>5) {
    $titulo=" VIGENTE ";
    $rptVIG=true;
    $rptVenc=true;
    $rptpv=false;
    $rptpj=false;
    $rptju=false;
}
if ($idejecutivo==1) {
    $titulo=" PROXIMA VIGENCIA ";
    $rptVIG=false;
    $rptVenc=false;
    $rptpv=true;
    $rptpj=false;
    $rptju=false;
}
if ($idejecutivo==2) {
    $titulo=" PRE-JURIDICA ";
    $rptVIG=false;
    $rptVenc=false;
    $rptpv=false;
    $rptpj=true;
    $rptju=false;
}
if ($idejecutivo==3) {
    $titulo=" JURIDICA ";
    $rptVIG=false;
    $rptVenc=false;
    $rptpv=false;
    $rptpj=false;
    $rptju=true;
}

$nroplanilla=diferenciaDias(date('Y')."-01"."-01", $fechaGen);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf->SetPrintHeader(false);
$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('INGLES PARA TODOS');
$pdf->SetTitle('CARTERA');
$pdf->SetSubject('CARTERA');
$pdf->SetKeywords('CARTERA');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
if (@file_exists(dirname(__FILE__).'/lang/es.php')) {
    require_once(dirname(__FILE__).'/lang/es.php');
    $pdf->setLanguageArray($l);
}
$pdf->setFontSubsetting(true);

$pdf->SetFont('helvetica', '', 8);
$pdf->AddPage('L','A4');
setlocale(LC_ALL, 'es_ES').': ';
$html=' 
<style>
    .titulo{
      font-size:10px;
      font-style:italic;
    }
</style>
<table width="100%"  align="center">
  <tr>
    <td class="letras">
      <center>
        <img src="'.$ruta.'recursos/images/materialize-logo.png" >
      </center>
    </td>
    <td><br>
    <div class="titulo">Centro de Capacitación Tecnica <br> INGLES PARA TODOS</div>
    </td>
    <td><br>
    <table border="1">
      <tr>
        <td>
          <table class="letras" cellpadding="1">
            <tr>
              <td align="right">
                Nº&nbsp;PLANILLA:
              </td>
              <td align="left">
                <b>'.$nroplanilla.'</b>
              </td>
            </tr>
            <tr>
              <td align="right">
                FECHA&nbsp;PLANILLA:
              </td>
              <td align="left">
                <b>'.$fechaGen.'</b>
              </td>
            </tr>
            <tr>
              <td align="right">
                SEDE:
              </td>
              <td align="left">
                <b>LA PAZ</b>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>                     
    </td>
  </tr>
</table>';
$pdf->SetFont('helvetica', '', 7);
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$html='
<style>
    .titulo{
        font-size:10px;
        font-weight: bold;
    }
    .textocentro{
        text-align:center;
    }
    .hdTable{
        border: solid 1px white;
        font-weight: bold;
        font-size: 7px;
    }
    .sfila{
        border: solid 1px #606060;
    }
</style>
<table border="0" align="center" width="100%">
    <tr>
        <td class="titulo"> CARTERA'.$titulo.' AL '.strtoupper(obtenerFechaLetra($fechaGen)).'<br> SEÑOR: '.$deje['nombre']." ".$deje['paterno']." ".$deje['materno'].' </td>
    </tr>
 </table><br><br>
';
// CARTERA VIGENTE 
if($rptVIG){
$html=$html.'
<table border="0" width="100%">
    <tr>
        <td class="titulo"> CARTERA VIGENTE </td>
    </tr>
 </table>
<table border="0" cellpadding="0" width="100%">
    <tr style="background-color:#dddddd;font-weight: bold;">
        <td class="textocentro hdTable" width="15"> Nº</td>
        <td class="textocentro hdTable" width="50"> MATRICULA </td>
        <td class="textocentro hdTable" width="40"> CUENTA </td>
        <td class="textocentro hdTable" width="110"> EJECUTIVO </td>
        <td class="textocentro hdTable" width="150"> TITULAR</td>
        <td class="textocentro hdTable" width="50"> F. CUOTA 1 </td>
        <td class="textocentro hdTable" width="50"> F.ULT. PAGO </td>
        <td class="textocentro hdTable" width="50"> F. PROX. VE. </td>
        <td class="textocentro hdTable" width="80"> PLAN </td>
        <td class="textocentro hdTable" width="30"> CUOTA </td>
        <td class="textocentro hdTable" width="35"> SALDO </td>
        <td class="textocentro hdTable" width="40">DIAS MORA</td>
        <td class="textocentro hdTable"> ESTADO </td>
    </tr>';
$pdf->SetFont('helvetica', '', 6);
$i=1;
    foreach($cobcartera->mostrarTodo("saldo>0 and estado=131 and idejecutivo=$idejecutivo","fechaproxve") as $f){
        $dct=$admcontrato->muestra($f['idcontrato']);
        $deje=$vejecutivo->muestra($f['idejecutivo']);
        $destado=$dominio->muestra($f['estado']);
        $dcp=$vcontratoplan->muestra($f['idcontrato']);
        $fechaPVE=$f['fechaproxve'];
        $fechaHoy=date("Y-m-d");
        $dias=diferenciaDias($fechaPVE, $fechaHoy);
        $dtit=$vtitular->muestra($dct['idtitular']);
        if ($dias<0) {
            $dias=0;
        }
        $html=$html.'
        <tr>
            <td class="textocentro sfila">'.$i.'</td>
            <td class="textocentro sfila">'.$dct['nrocontrato'].'</td>
            <td class="textocentro sfila">'.$dct['cuenta'].'</td>
            <td class="textocentro sfila">'.strtoupper($deje['nombre'])." ".strtoupper(substr($deje['paterno'],0,1)).".".'</td>
            <td class="textocentro sfila">'.$dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'].'</td>
            <td class="textocentro sfila">'.$f['fechainicio'].'</td>
            <td class="textocentro sfila">'.$f['fechaultpago'].'</td>
            <td class="textocentro sfila">'.$f['fechaproxve'].'</td>
            <td class="textocentro sfila">'.$dcp['personas']." ".$dcp['nombre']." de ".$dcp['inversion'].'</td>
            <td class="textocentro sfila">'.crestantes($f['monto']-$dcp['pagoinicial'],$f['saldo'],$dcp['cuotas'])." de ".($dcp['cuotas']+1).'</td>
            <td class="textocentro sfila">'.number_format($f['saldo'], 2, '.', '').'</td>
            <td class="textocentro sfila">'.$dias.'</td>
            <td class="textocentro sfila">'.$destado['nombre'].'</td>
        </tr>';
        $i++;
    }
  $html=$html.'

</table>
<br><br><br><br>
';
}
if($rptVenc){
// CARTERA VENCIDA
$html=$html.'
<table border="0" width="100%">
    <tr>
        <td class="titulo"> CARTERA VENCIDA </td>
    </tr>
 </table>
<table border="0" cellpadding="0" width="100%">
    <tr style="background-color:#dddddd;font-weight: bold;">
        <td class="textocentro hdTable" width="15"> Nº</td>
        <td class="textocentro hdTable" width="50"> MATRICULA </td>
        <td class="textocentro hdTable" width="40"> CUENTA </td>
        <td class="textocentro hdTable" width="110"> EJECUTIVO </td>
        <td class="textocentro hdTable" width="150"> TITULAR</td>
        <td class="textocentro hdTable" width="50"> F. CUOTA 1 </td>
        <td class="textocentro hdTable" width="50"> F.ULT. PAGO </td>
        <td class="textocentro hdTable" width="50"> F. PROX. VE. </td>
        <td class="textocentro hdTable" width="80"> PLAN </td>
        <td class="textocentro hdTable" width="30"> CUOTA </td>
        <td class="textocentro hdTable" width="35"> SALDO </td>
        <td class="textocentro hdTable" width="40">DIAS MORA</td>
        <td class="textocentro hdTable"> ESTADO </td>
    </tr>';
$pdf->SetFont('helvetica', '', 6);
$i=1;
    foreach($cobcartera->mostrarTodo("saldo>0 and estado=133 and idejecutivo=$idejecutivo","fechaproxve") as $f){
        $dct=$admcontrato->muestra($f['idcontrato']);
        $deje=$vejecutivo->muestra($f['idejecutivo']);
        $destado=$dominio->muestra($f['estado']);
        $dcp=$vcontratoplan->muestra($f['idcontrato']);
        $fechaPVE=$f['fechaproxve'];
        $fechaHoy=date("Y-m-d");
        $dias=diferenciaDias($fechaPVE, $fechaHoy);
        $dtit=$vtitular->muestra($dct['idtitular']);
        if ($dias<0) {
            $dias=0;
        }
        $html=$html.'
        <tr>
            <td class="textocentro sfila">'.$i.'</td>
            <td class="textocentro sfila">'.$dct['nrocontrato'].'</td>
            <td class="textocentro sfila">'.$dct['cuenta'].'</td>
            <td class="textocentro sfila">'.strtoupper($deje['nombre'])." ".strtoupper(substr($deje['paterno'],0,1)).".".'</td>
            <td class="textocentro sfila">'.$dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'].'</td>
            <td class="textocentro sfila">'.$f['fechainicio'].'</td>
            <td class="textocentro sfila">'.$f['fechaultpago'].'</td>
            <td class="textocentro sfila">'.$f['fechaproxve'].'</td>
            <td class="textocentro sfila">'.$dcp['personas']." ".$dcp['nombre']." de ".$dcp['inversion'].'</td>
            <td class="textocentro sfila">'.crestantes($f['monto']-$dcp['pagoinicial'],$f['saldo'],$dcp['cuotas'])." de ".($dcp['cuotas']+1).'</td>
            <td class="textocentro sfila">'.number_format($f['saldo'], 2, '.', '').'</td>
            <td class="textocentro sfila">'.$dias.'</td>
            <td class="textocentro sfila">'.$destado['nombre'].'</td>
        </tr>';
        $i++;
    }
  $html=$html.'

</table>
<br><br><br><br>
';
}

// CARTERA  PAGO FINAL
$html=$html.'
<table border="0" width="100%">
    <tr>
        <td class="titulo"> CARTERA PAGO FINAL </td>
    </tr>
 </table>
<table border="0" cellpadding="0" width="100%">
    <tr style="background-color:#dddddd;font-weight: bold;">
        <td class="textocentro hdTable" width="15"> Nº</td>
        <td class="textocentro hdTable" width="50"> MATRICULA </td>
        <td class="textocentro hdTable" width="40"> CUENTA </td>
        <td class="textocentro hdTable" width="110"> EJECUTIVO </td>
        <td class="textocentro hdTable" width="150"> TITULAR</td>
        <td class="textocentro hdTable" width="50"> F. CUOTA 1 </td>
        <td class="textocentro hdTable" width="50"> F.ULT. PAGO </td>
        <td class="textocentro hdTable" width="50"> F. PROX. VE. </td>
        <td class="textocentro hdTable" width="80"> PLAN </td>
        <td class="textocentro hdTable" width="30"> CUOTA </td>
        <td class="textocentro hdTable" width="35"> SALDO </td>
        <td class="textocentro hdTable" width="40">DIAS MORA</td>
        <td class="textocentro hdTable"> ESTADO </td>
    </tr>';
$pdf->SetFont('helvetica', '', 6);
$i=1;
    foreach($cobcartera->mostrarTodo("saldo=0 and auditado=0 and idejecutivo=$idejecutivo") as $f){
        $dct=$admcontrato->muestra($f['idcontrato']);
        $deje=$vejecutivo->muestra($f['idejecutivo']);
        $destado=$dominio->muestra($f['estado']);
        $dcp=$vcontratoplan->muestra($f['idcontrato']);
        $fechaPVE=$f['fechaproxve'];
        $fechaHoy=date("Y-m-d");
        $dias=diferenciaDias($fechaPVE, $fechaHoy);
        $dtit=$vtitular->muestra($dct['idtitular']);
        if ($dias<0) {
            $dias=0;
        }
        $html=$html.'
        <tr>
            <td class="textocentro sfila">'.$i.'</td>
            <td class="textocentro sfila">'.$dct['nrocontrato'].'</td>
            <td class="textocentro sfila">'.$dct['cuenta'].'</td>
            <td class="textocentro sfila">'.strtoupper($deje['nombre'])." ".strtoupper(substr($deje['paterno'],0,1)).".".'</td>
            <td class="textocentro sfila">'.$dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'].'</td>
            <td class="textocentro sfila">'.$f['fechainicio'].'</td>
            <td class="textocentro sfila">'.$f['fechaultpago'].'</td>
            <td class="textocentro sfila">--</td>
            <td class="textocentro sfila">'.$dcp['personas']." ".$dcp['nombre']." de ".$dcp['inversion'].'</td>
            <td class="textocentro sfila">'.crestantes($f['monto']-$dcp['pagoinicial'],$f['saldo'],$dcp['cuotas'])." de ".($dcp['cuotas']+1).'</td>
            <td class="textocentro sfila">'.number_format($f['saldo'], 2, '.', '').'</td>
            <td class="textocentro sfila">0</td>
            <td class="textocentro sfila">'.$destado['nombre'].'</td>
        </tr>';
        $i++;
    }
  $html=$html.'

</table>
<br><br><br><br>
';


if($rptpv){
//CARTERA PROXIMA VIGENCIA
$html=$html.'
<table border="0" width="100%">
    <tr>
        <td class="titulo"> CARTERA PROXIMA VIGENCIA  </td>
    </tr>
 </table>
<table border="0" cellpadding="0" width="100%">
    <tr style="background-color:#dddddd;font-weight: bold;">
        <td class="textocentro hdTable" width="15"> Nº</td>
        <td class="textocentro hdTable" width="50"> MATRICULA </td>
        <td class="textocentro hdTable" width="40"> CUENTA </td>
        <td class="textocentro hdTable" width="110"> EJECUTIVO </td>
        <td class="textocentro hdTable" width="150"> TITULAR</td>
        <td class="textocentro hdTable" width="50"> F. CUOTA 1 </td>
        <td class="textocentro hdTable" width="50"> F.ULT. PAGO </td>
        <td class="textocentro hdTable" width="50"> F. PROX. VE. </td>
        <td class="textocentro hdTable" width="80"> PLAN </td>
        <td class="textocentro hdTable" width="30"> CUOTA </td>
        <td class="textocentro hdTable" width="35"> SALDO </td>
        <td class="textocentro hdTable" width="40">DIAS MORA</td>
        <td class="textocentro hdTable"> ESTADO </td>
    </tr>';
$pdf->SetFont('helvetica', '', 6);
$i=1;
    foreach($cobcartera->mostrarTodo("saldo>0 and idejecutivo=1","fechaproxve") as $f){
        $dct=$admcontrato->muestra($f['idcontrato']);
        $deje=$vejecutivo->muestra($f['idejecutivo']);
        $destado=$dominio->muestra($f['estado']);
        $dcp=$vcontratoplan->muestra($f['idcontrato']);
        $fechaPVE=$f['fechaproxve'];
        $fechaHoy=date("Y-m-d");
        $dias=diferenciaDias($fechaPVE, $fechaHoy);
        $dtit=$vtitular->muestra($dct['idtitular']);
        if ($dias<0) {
            $dias=0;
        }
        $html=$html.'
        <tr>
            <td class="textocentro sfila">'.$i.'</td>
            <td class="textocentro sfila">'.$dct['nrocontrato'].'</td>
            <td class="textocentro sfila">'.$dct['cuenta'].'</td>
            <td class="textocentro sfila">'.strtoupper($deje['nombre'])." ".strtoupper(substr($deje['paterno'],0,1)).".".'</td>
            <td class="textocentro sfila">'.$dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'].'</td>
            <td class="textocentro sfila">'.$f['fechainicio'].'</td>
            <td class="textocentro sfila">'.$f['fechaultpago'].'</td>
            <td class="textocentro sfila">'.$f['fechaproxve'].'</td>
            <td class="textocentro sfila">'.$dcp['personas']." ".$dcp['nombre']." de ".$dcp['inversion'].'</td>
            <td class="textocentro sfila">'.crestantes($f['monto']-$dcp['pagoinicial'],$f['saldo'],$dcp['cuotas'])." de ".($dcp['cuotas']+1).'</td>
            <td class="textocentro sfila">'.number_format($f['saldo'], 2, '.', '').'</td>
            <td class="textocentro sfila">'.$dias.'</td>
            <td class="textocentro sfila">'.$destado['nombre'].'</td>
        </tr>';
        $i++;
    }
  $html=$html.'

</table>
<br><br><br><br>
';
}
if($rptpj){
// CARTERA PREJURIDICA
$html=$html.'
<table border="0" width="100%">
    <tr>
        <td class="titulo"> CARTERA PREJURIDICA  </td>
    </tr>
 </table>
<table border="0" cellpadding="0" width="100%">
    <tr style="background-color:#dddddd;font-weight: bold;">
        <td class="textocentro hdTable" width="15"> Nº</td>
        <td class="textocentro hdTable" width="50"> MATRICULA </td>
        <td class="textocentro hdTable" width="40"> CUENTA </td>
        <td class="textocentro hdTable" width="110"> EJECUTIVO </td>
        <td class="textocentro hdTable" width="150"> TITULAR</td>
        <td class="textocentro hdTable" width="50"> F. CUOTA 1 </td>
        <td class="textocentro hdTable" width="50"> F.ULT. PAGO </td>
        <td class="textocentro hdTable" width="50"> F. PROX. VE. </td>
        <td class="textocentro hdTable" width="80"> PLAN </td>
        <td class="textocentro hdTable" width="30"> CUOTA </td>
        <td class="textocentro hdTable" width="35"> SALDO </td>
        <td class="textocentro hdTable" width="40">DIAS MORA</td>
        <td class="textocentro hdTable"> ESTADO </td>
    </tr>';
$pdf->SetFont('helvetica', '', 6);
$i=1;
    foreach($cobcartera->mostrarTodo("saldo>0 and idejecutivo=2","fechaproxve") as $f){
        $dct=$admcontrato->muestra($f['idcontrato']);
        $deje=$vejecutivo->muestra($f['idejecutivo']);
        $destado=$dominio->muestra($f['estado']);
        $dcp=$vcontratoplan->muestra($f['idcontrato']);
        $fechaPVE=$f['fechaproxve'];
        $fechaHoy=date("Y-m-d");
        $dias=diferenciaDias($fechaPVE, $fechaHoy);
        $dtit=$vtitular->muestra($dct['idtitular']);
        if ($dias<0) {
            $dias=0;
        }
        $html=$html.'
        <tr>
            <td class="textocentro sfila">'.$i.'</td>
            <td class="textocentro sfila">'.$dct['nrocontrato'].'</td>
            <td class="textocentro sfila">'.$dct['cuenta'].'</td>
            <td class="textocentro sfila">'.strtoupper($deje['nombre'])." ".strtoupper(substr($deje['paterno'],0,1)).".".'</td>
            <td class="textocentro sfila">'.$dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'].'</td>
            <td class="textocentro sfila">'.$f['fechainicio'].'</td>
            <td class="textocentro sfila">'.$f['fechaultpago'].'</td>
            <td class="textocentro sfila">'.$f['fechaproxve'].'</td>
            <td class="textocentro sfila">'.$dcp['personas']." ".$dcp['nombre']." de ".$dcp['inversion'].'</td>
            <td class="textocentro sfila">'.crestantes($f['monto']-$dcp['pagoinicial'],$f['saldo'],$dcp['cuotas'])." de ".($dcp['cuotas']+1).'</td>
            <td class="textocentro sfila">'.number_format($f['saldo'], 2, '.', '').'</td>
            <td class="textocentro sfila">'.$dias.'</td>
            <td class="textocentro sfila">'.$destado['nombre'].'</td>
        </tr>';
        $i++;
    }
  $html=$html.'

</table>
<br><br><br><br>
';
}
if($rptju){
//CARTERA JURIDICA
$html=$html.'
<table border="0" width="100%">
    <tr>
        <td class="titulo"> CARTERA JURIDICA  </td>
    </tr>
 </table>
<table border="0" cellpadding="0" width="100%">
    <tr style="background-color:#dddddd;font-weight: bold;">
        <td class="textocentro hdTable" width="15"> Nº</td>
        <td class="textocentro hdTable" width="50"> MATRICULA </td>
        <td class="textocentro hdTable" width="40"> CUENTA </td>
        <td class="textocentro hdTable" width="110"> EJECUTIVO </td>
        <td class="textocentro hdTable" width="150"> TITULAR</td>
        <td class="textocentro hdTable" width="50"> F. CUOTA 1 </td>
        <td class="textocentro hdTable" width="50"> F.ULT. PAGO </td>
        <td class="textocentro hdTable" width="50"> F. PROX. VE. </td>
        <td class="textocentro hdTable" width="80"> PLAN </td>
        <td class="textocentro hdTable" width="30"> CUOTA </td>
        <td class="textocentro hdTable" width="35"> SALDO </td>
        <td class="textocentro hdTable" width="40">DIAS MORA</td>
        <td class="textocentro hdTable"> ESTADO </td>
    </tr>';
$pdf->SetFont('helvetica', '', 6);
$i=1;
    foreach($cobcartera->mostrarTodo("saldo>0 and idejecutivo=3","fechaproxve") as $f){
        $dct=$admcontrato->muestra($f['idcontrato']);
        $deje=$vejecutivo->muestra($f['idejecutivo']);
        $destado=$dominio->muestra($f['estado']);
        $dcp=$vcontratoplan->muestra($f['idcontrato']);
        $fechaPVE=$f['fechaproxve'];
        $fechaHoy=date("Y-m-d");
        $dias=diferenciaDias($fechaPVE, $fechaHoy);
        $dtit=$vtitular->muestra($dct['idtitular']);
        if ($dias<0) {
            $dias=0;
        }
        $html=$html.'
        <tr>
            <td class="textocentro sfila">'.$i.'</td>
            <td class="textocentro sfila">'.$dct['nrocontrato'].'</td>
            <td class="textocentro sfila">'.$dct['cuenta'].'</td>
            <td class="textocentro sfila">'.strtoupper($deje['nombre'])." ".strtoupper(substr($deje['paterno'],0,1)).".".'</td>
            <td class="textocentro sfila">'.$dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'].'</td>
            <td class="textocentro sfila">'.$f['fechainicio'].'</td>
            <td class="textocentro sfila">'.$f['fechaultpago'].'</td>
            <td class="textocentro sfila">'.$f['fechaproxve'].'</td>
            <td class="textocentro sfila">'.$dcp['personas']." ".$dcp['nombre']." de ".$dcp['inversion'].'</td>
            <td class="textocentro sfila">'.crestantes($f['monto']-$dcp['pagoinicial'],$f['saldo'],$dcp['cuotas'])." de ".($dcp['cuotas']+1).'</td>
            <td class="textocentro sfila">'.number_format($f['saldo'], 2, '.', '').'</td>
            <td class="textocentro sfila">'.$dias.'</td>
            <td class="textocentro sfila">'.$destado['nombre'].'</td>
        </tr>';
        $i++;
    }
  $html=$html.'

</table>
<br><br><br><br>
';
}
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('historial.pdf', 'I');

 ?>
