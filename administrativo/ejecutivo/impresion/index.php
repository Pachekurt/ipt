<?php
session_start();
$ruta="../../../";
$folder="";
include_once($ruta."class/dominio.php");
$dominio=new dominio;
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo;
include_once($ruta."class/files.php");
$files=new files;
include_once($ruta."funciones/funciones.php");
require_once($ruta.'recursos/pdf/tcpdf/tcpdf.php');
include($ruta."recursos/qr/qrlib.php"); 
/******************    SEGURIDAD *************/

//******* SEGURIDAD GET *************/
extract($_GET);
$valor=dcUrl($lblcode);
$deje=$vejecutivo->muestra($valor);
if (!ctype_digit(strval($valor))) {
  if (!isset($_SESSION["faltaSistema"]))
  {  $_SESSION['faltaSistema']="0"; }
  $_SESSION['faltaSistema']=$_SESSION['faltaSistema']+1;
  header('Location: '.$ruta.'login/salir.php');
}


/******** foto ***********/
$dfoto=$files->mostrarTodo("id_publicacion=".$valor." and tipo_foto='foto'");
$dfoto=array_shift($dfoto);
if (count($dfoto)>0) {
    $rutaFoto=$ruta."administrativo/ejecutivo/foto/server/php/".$valor."/".$dfoto['name'];
}
else{
    $rutaFoto=$ruta."imagenes/user.png";
}
                    


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf->SetPrintHeader(false);
$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Julio Vargas');
$pdf->SetTitle('EJECUTIVO');
$pdf->SetSubject('EJECUTIVO');
$pdf->SetKeywords('EJECUTIVO');


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
            Centro de Capacitación Técnica <br> GOLDEN BRIDGE
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
    <td width="35%"></td>
    <td><center><b style="font-size:15px;">REGISTRO DE EJECUTIVO</b></center></td>
  </tr>
</table>
<br>
<br>
<table class="sfila" width="704">
    <tr>
        <td width="140">
            <center>
                <img src="'.$rutaFoto.'"  width="130" >
            </center>
        </td>
        <td class="cabecera2" width="400">
            <table  cellpadding="2" width="100%">
                <tr>
                    <td width="30%">
                        NOMBRE
                    </td>
                    <td width="70%">: <b>
                        '.$deje["nombre"]." ".$deje["paterno"]." ".$deje["materno"].'</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        CARNET
                    </td>
                    <td>: <b>
                        '.$deje["carnet"]." ".$deje["expedido"].'</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        FECHA NACIMIENTO
                    </td>
                    <td>: <b>
                        '.$deje["nacimiento"].'</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        EMAIL
                    </td>
                    <td>: <b>
                        '.$deje["email"].'</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        CELULAR
                    </td>
                    <td>: <b>
                        '.$deje["celular"].'</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        SEXO
                    </td>
                    <td>: <b>
                        '.$deje["nsexo"].'</b>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<BR><BR><BR>
<b>DATOS LABORALES</b><BR>
____________________________________________________________________________________________________________________
<BR>
<table  cellpadding="4" width="704">
    <tr>
        <td width="110">
            AREA
        </td>
        <td width="160">: <b>
            '.$deje["narea"].'</b>
        </td>
        <td width="110">
            ORGANIZACION / DPTO.
        </td>
        <td width="160">: <b>
            '.$deje["norganizacion"].'</b>
        </td>
    </tr>
    <tr>
        <td width="110">
            CARGO
        </td>
        <td width="160">: <b>
            '.$deje["njerarquia"].'</b>
        </td>
        <td width="110">
            TIPO EJECUTIVO
        </td>
        <td width="160">: <b>
            '.$deje["ntipo"].'</b>
        </td>
    </tr>
    <tr>
        
        <td width="110">
            FECHA INGRESO
        </td>
        <td width="160">: <b>
            '.$deje["fechaingreso"].'</b>
        </td>
        <td width="110">
            HORARIO
        </td>
        <td width="160">: <b>
            '.$deje["nhora"].'</b>
        </td>
    </tr>
    <tr>
        <td width="110">
            SEDE
        </td>
        <td width="160">: <b>
            '.$deje["nsede"].'</b>
        </td>
        <td width="110">
            DET./OBS.
        </td>
        <td width="160">: <b>
            '.$deje["obser"].'</b>
        </td>
    </tr>
    <tr>
        <td width="110">
            FECHA REGISTRO
        </td>
        <td width="160">: <b>
            '.$deje["fechacreacion"].'</b>
        </td>
        <td width="110">
            HORA REGISTRO
        </td>
        <td width="160">: <b>
            '.$deje["horacreacion"].'</b>
        </td>
    </tr>
</table>
<BR><BR><BR>
<b>HISTORIAL DEL EJECUTIVO</b>
<BR>
____________________________________________________________________________________________________________________
<BR>

 ';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('Factura.pdf', 'I');

 ?>
