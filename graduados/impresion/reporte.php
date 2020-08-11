<?php
$ruta="../../";
$folder="";
require $ruta."recursos/pdf/fpdf/fpdf.php";
include_once($ruta."class/vobservacion.php");
$vobservacion=new vobservacion;
include_once($ruta."class/vestudiante.php");
$vestudiante=new vestudiante;
include_once($ruta."class/files.php");
$files=new files;

include_once($ruta."class/asistencia.php");
$asistencia=new asistencia;
include_once($ruta."class/vasistencia.php");
$vasistencia=new vasistencia; 
include_once($ruta."class/vestudiantefull.php");
$vestudiantefull=new vestudiantefull;
include_once($ruta."class/modulo.php");
$modulo=new modulo;
include_once($ruta."class/vusuario.php");
$vusuario=new vusuario;
include_once($ruta."class/vcurso.php");
$vcurso=new vcurso;
include_once($ruta."funciones/funciones.php");
require_once($ruta.'recursos/pdf/tcpdf/tcpdf.php');
include($ruta."recursos/qr/qrlib.php");

extract($_GET);
$ide= dcUrl($idecod); 

//echo $ide;
$ves = $vestudiante->mostrarTodo("idvestudiante=$ide");
$ves = array_shift($ves);



// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf->SetPrintHeader(false);
$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Aaron Mejia');
$pdf->SetTitle('OBSERVACION');
$pdf->SetSubject('OBSERVACION');
$pdf->SetKeywords('OBSERVACION');


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
  font-size:10px;
  font-weight: bold;
}
.tituloCenda{
  color:red;
}
.letras{
  font-size:8px;
  text-align: left;
}
.letras2{
  font-size:18px;
}
</style>
<table width="100%"  align="center">
    <tr>
        <td>
          <center>
            <img src="'.$ruta.'imagenes/logofull.png"  width="110">
          </center>
        </td>
        <td class="tituloFactura" >
            Centro de Capacitación Técnica <br> INGLES PARA TODOS S.A.
        </td>
        <td><br><br>
            <table>
                <tr>
                    <td class="letras">FECHA:</td>
                    <td class="letras">'.date("Y-m-d").'</td>
                </tr>
                <tr>
                    <td class="letras">HORA:</td>
                    <td class="letras">'.date("H:i:s").'</td>
                </tr>
            </table>                
        </td>
    </tr>
</table>';
$pdf->SetFont('helvetica', '', 8);
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$html='
<br><br><br>
<table width="100%">
  <tr>
    <td><center><b align="center" style="font-size:15px;">DATOS ESTUDIANTE</b></center></td>
  </tr>
</table>
<br>
<br>
<table class="sfila" width="704">
    <tr>
        <td class="cabecera2" width="400">
            <table  cellpadding="2" width="100%">
                <tr>
                    <td width="30%">
                        NOMBRE
                    </td>
                    <td width="70%">: <b>
                        '.$ves["nombre"]." ".$ves["paterno"]." ".$ves["materno"].'</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        CARNET
                    </td>
                    <td>: <b>
                        '.$ves["carnet"]." ".$ves["expedido"].'</b>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<BR><BR><BR>
<b>OBSERVACIONES</b><BR>
____________________________________________________________________________________________________________________

<BR>
<div class="container">        
  <table class="table">
    <thead>
      <tr>
        
        
        <th>Nro.</th>
        <th>OBSERVACION</th>
        <th>REALIZADO POR</th>
        <th>FECHA</th>
        <th>HORA</th>
     
      </tr>
    </thead>
    <tbody>
    ';
$i=1;

$numero =$vobservacion->mostrarTodo("idestudiante=".$ide);

if(count($numero)==0) $html='SIN OBSERVACIONES'.$html;
 
foreach($vobservacion->mostrarTodo("idestudiante=".$ide) as $asis)
    {
        


        $html=$html.'
        <tr>
              <td>'.$i++.'</td>
              <td>'.$asis["detalle"].'</td>
              <td>'.$asis["nombreo"].' '.$asis["paternoo"].'</td>
              <td>'.$asis["fechacreacion"].'</td>
              <td>'.$asis["horacreacion"].'</td>
        </tr>';

    }

$html=$html.'
    </tbody>
  </table>
</div>
<BR>
<b>ASISTENCIAS</b><BR>
____________________________________________________________________________________________________________________

<BR>
<div class="container">        
  <table class="table">
    <thead>
      <tr>
        
         
        <th>FECHA ASISTENCIA</th>
        <th>DOCENTE</th>
        <th>SESION</th>
        <th>HORARIO</th>
        <th>ASISTENCIA</th>
     
      </tr>
    </thead>
    <tbody>
    ';
$i=1;
 
 
foreach($vasistencia->mostrarTodo("idestudiante=".$ide) as $asis)
    {
        


        $html=$html.'
        <tr> 
              <td>'.$asis["fechaasistencia"].'</td>
              <td>'.$asis["asesor"].'</td>
              <td>'.$asis["sesion"].'</td>
              <td>'.$asis["inicio"].'</td>
              <td>'.$asis["asistencia"].'</td>
        </tr>';

    }

$html=$html.'
    </tbody>
  </table>
</div>
<BR><BR><BR>
<BR>
____________________________________________________________________________________________________________________
<BR>

 ';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('Reporte Observaciones.pdf', 'I');

 ?>