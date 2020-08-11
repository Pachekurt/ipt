<?php
session_start();
$ruta="../../../../../";
$folder="";
include_once($ruta."class/vcontratoplan.php");
$vcontratoplan=new vcontratoplan;
include_once($ruta."class/vcontratodeta.php");
$vcontratodeta=new vcontratodeta;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo;
include_once($ruta."class/vtitular.php");
$vtitular=new vtitular;
include_once($ruta."class/sede.php");
$sede=new sede;
include_once($ruta."class/factura.php");
$factura=new factura;
include_once($ruta."class/usuario.php");
$usuario=new usuario;
include_once($ruta."funciones/funciones.php");
require_once($ruta.'recursos/pdf/tcpdf/tcpdf.php');
include($ruta."recursos/qr/qrlib.php"); 
/******************    SEGURIDAD *************/
extract($_GET);
$dsede=$sede->muestra("$codsede");
//********* SEGURIDAD GET *************/

//$nroplanilla=diferenciaDias(date('Y')."-01"."-01", $fechaGen);
$nroplanilla=diferenciaDias(obtenerAnio($fechaGen)."-01"."-01", $fechaGen)+1;




// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf->SetPrintHeader(false);
$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('INGLES PARA TODOS');
$pdf->SetTitle('Historial Contrato');
$pdf->SetSubject('Historial Contrato');
$pdf->SetKeywords('Historial Contrato');
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
                <b>'.$dsede['nombre'].'</b>
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
    }
    .sfila{
        border: solid 1px #606060;
    }
</style>
<table border="0" align="center" width="100%">
    <tr>
        <td class="titulo"> PARTE DIARIO DE VERIFICACIÓN<br>'.strtoupper(obtenerFechaLetra($fechaGen)).' </td>
    </tr>
 </table><br><br>
 
';
$html=$html.'
<table border="0" width="100%">
    <tr>
        <td class="titulo"> MATRICULAS VERIFICADAS EN EL DIA </td>
    </tr>
 </table>
<table border="0" cellpadding="2" width="100%">
    <tr style="background-color:#dddddd;font-weight: bold;">
        <td class="textocentro hdTable" width="15"> Nº</td>
        <td class="textocentro hdTable" width="80"> TITULAR </td>
        <td class="textocentro hdTable" width="60"> EJECUTIVO DE PUBLICIDAD</td>
        <td class="textocentro hdTable" width="55"> FILIAL </td>
        <td class="textocentro hdTable" width="25"> PROG </td>
        <td class="textocentro hdTable" width="55"> PLAN </td>
        <td class="textocentro hdTable" width="30"> Nº CUENTA </td>
        <td class="textocentro hdTable" width="40">Nº CONTRATO</td>
        <td class="textocentro hdTable"> Nº RECORD </td>
        <td class="textocentro hdTable"> FECHA RECORD </td>
        <td class="textocentro hdTable"> MONTO DEPOSITADO </td>
        <td class="textocentro hdTable"> Nº FACTURA </td>
        <td class="textocentro hdTable"> NOM. VERIFICADOR </td>
        <td class="textocentro hdTable"> Nº PLANILLA. PROD. </td>
        <td class="textocentro hdTable"> FECHA ASIGNACION </td>
    </tr>';
$pdf->SetFont('helvetica', '', 6);
$i=1;
    foreach($vcontratodeta->mostrarTodo("codigo=3116 and fecha='$fechaGen' and idsede = $codsede") as $f){
        $dcont=$admcontrato->muestra($f['idcontrato']);
        $dtit=$vtitular->muestra($dcont['idtitular']);
        $dus=$usuario->muestra($f['usuariocreacion']);
        $deje=$vejecutivo->muestra($dcont['idadmejecutivo']);
        $nejecutivo=strtoupper(substr($deje['nombre'],0,1)).". ".strtoupper($deje['paterno']);
        $dcp=$vcontratoplan->muestra($f['idcontrato']);

        $records="";
        $facturas="";
        $planillas="";
        $ind=0;

        // obtiene todos los record hasta el moemento
        foreach($vcontratodeta->mostrarTodo("codigo=3113 and anulado=0 and idcontrato=".$f['idcontrato']."   and idsede = $codsede") as $g){
          $dfact=$factura->muestra($g['idfactura']);
          if ($ind==0) {
            $records=$g['record'];
            $facturas=$dfact['nro'];
            $planillas=diferenciaDias(date('Y')."-01"."-01", $g['fecha']);

            
            $ind=1;
          }
          else{
            $records=$records."-".$g['record'];
            $facturas=$facturas."-".$dfact['nro'];
            $planillas=$planillas."-".diferenciaDias(date('Y')."-01"."-01", $g['fecha']);
          }
        }
        // Obtiene  la ultima fecha de record de produccion
        $fult=$vcontratodeta->mostrarUltimo("codigo=3113 and anulado=0 and idcontrato=".$f['idcontrato']." and idsede = $codsede");
        $fechaRecord=$fult['fecha'];

        $html=$html.'
        <tr>
            <td class="textocentro sfila">'.$i.'</td>
            <td class="textocentro sfila">'.$dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'].'</td>
            <td class="textocentro sfila">'.$nejecutivo.'</td>
            <td class="textocentro sfila">'.$dsede['alias'].'</td>
            <td class="textocentro sfila"> EFE </td>
            <td class="textocentro sfila">'.$dcp['personas']." ".$dcp['nombre'].'</td>
            <td class="textocentro sfila">'.$dcont['cuenta'].'</td>
            <td class="textocentro sfila">'.$dcont['nrocontrato'].'</td>
            <td class="textocentro sfila">'.$records.'</td>
            <td class="textocentro sfila">'.$fechaRecord.'</td>
            <td class="textocentro sfila">'.$dcont['pagado'].'</td>
            <td class="textocentro sfila">'.$facturas.'</td>
            <td class="textocentro sfila">'.$dus['usuario'].'</td>
            <td class="textocentro sfila">'.$planillas.'</td>
            <td class="textocentro sfila">'.$dcont['fechainicio'].'</td>
        </tr>';
        $i++;
    }
  $html=$html.'

</table>
<br><br><br><br>
';
$html=$html.'
<table border="0" width="100%">
    <tr>
        <td class="titulo"> MATRICULAS RECHAZADAS EN EL DIA </td>
    </tr>
 </table>
<table border="0" cellpadding="2" width="100%">
    <tr style="background-color:#dddddd;font-weight: bold;">
        <td class="textocentro hdTable" width="15"> Nº</td>
        <td class="textocentro hdTable" width="80"> TITULAR </td>
        <td class="textocentro hdTable" width="60"> EJECUTIVO DE PUBLICIDAD</td>
        <td class="textocentro hdTable" width="55"> FILIAL </td>
        <td class="textocentro hdTable" width="25"> PROG </td>
        <td class="textocentro hdTable" width="55"> PLAN </td>
        <td class="textocentro hdTable" width="30"> Nº CUENTA </td>
        <td class="textocentro hdTable" width="40">Nº CONTRATO</td>
        <td class="textocentro hdTable"> Nº RECORD </td>
        <td class="textocentro hdTable"> FECHA RECORD </td>
        <td class="textocentro hdTable"> MONTO DEPOSITADO </td>
        <td class="textocentro hdTable"> Nº FACTURA </td>
        <td class="textocentro hdTable"> NOM. VERIFICADOR </td>
        <td class="textocentro hdTable"> Nº PLANILLA. PROD. </td>
        <td class="textocentro hdTable"> FECHA ASIGNACION </td>
    </tr>';
$pdf->SetFont('helvetica', '', 6);
$i=1;
    foreach($vcontratodeta->mostrarTodo("codigo=3123 and fecha='$fechaGen' and idsede = $codsede") as $f){
        $dcont=$admcontrato->muestra($f['idcontrato']);
        $dtit=$vtitular->muestra($dcont['idtitular']);
        $dus=$usuario->muestra($f['usuariocreacion']);
        $deje=$vejecutivo->muestra($dcont['idadmejecutivo']);
        $nejecutivo=strtoupper(substr($deje['nombre'],0,1)).". ".strtoupper($deje['paterno']);
        $dcp=$vcontratoplan->muestra($f['idcontrato']);

        $records="";
        $facturas="";
        $planillas="";
        $ind=0;

        // obtiene todos los record hasta el moemento
        foreach($vcontratodeta->mostrarTodo("codigo=3113 and anulado=0 and idcontrato=".$f['idcontrato']." and idsede = $codsede") as $g){
          $dfact=$factura->muestra($g['idfactura']);
          if ($ind==0) {
            $records=$g['record'];
            $facturas=$dfact['nro'];
            $planillas=diferenciaDias(date('Y')."-01"."-01", $g['fecha']);

            
            $ind=1;
          }
          else{
            $records=$records."-".$g['record'];
            $facturas=$facturas."-".$dfact['nro'];
            $planillas=$planillas."-".diferenciaDias(date('Y')."-01"."-01", $g['fecha']);
          }
        }
        // Obtiene  la ultima fecha de record de produccion
        $fult=$vcontratodeta->mostrarUltimo("codigo=3113 and anulado=0 and idcontrato=".$f['idcontrato']." and idsede = $codsede");
        $fechaRecord=$fult['fecha'];

        $html=$html.'
        <tr>
            <td class="textocentro sfila">'.$i.'</td>
            <td class="textocentro sfila">'.$dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'].'</td>
            <td class="textocentro sfila">'.$nejecutivo.'</td>
            <td class="textocentro sfila">'.$dsede['alias'].'</td>
            <td class="textocentro sfila"> EFE </td>
            <td class="textocentro sfila">'.$dcp['personas']." ".$dcp['nombre'].'</td>
            <td class="textocentro sfila">'.$dcont['cuenta'].'</td>
            <td class="textocentro sfila">'.$dcont['nrocontrato'].'</td>
            <td class="textocentro sfila">'.$records.'</td>
            <td class="textocentro sfila">'.$fechaRecord.'</td>
            <td class="textocentro sfila">'.$dcont['pagado'].'</td>
            <td class="textocentro sfila">'.$facturas.'</td>
            <td class="textocentro sfila">'.$dus['usuario'].'</td>
            <td class="textocentro sfila">'.$planillas.'</td>
            <td class="textocentro sfila">'.$dcont['fechainicio'].'</td>
        </tr>';
        $i++;
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
