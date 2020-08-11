<?php
session_start();
$ruta="../../../../../";
$folder="";
include_once($ruta."class/vcontratodet.php");
$vcontratodet=new vcontratodet;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."class/vtitular.php");
$vtitular=new vtitular;
include_once($ruta."class/admcontratodelle.php");
$admcontratodelle=new admcontratodelle;
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo;
include_once($ruta."class/sede.php");
$sede=new sede;
include_once($ruta."class/admorgani.php");
$admorgani=new admorgani;
include_once($ruta."class/admorganizacion.php");
$admorganizacion=new admorganizacion;
include_once($ruta."class/admsucursal.php");
$admsucursal=new admsucursal;
include_once($ruta."class/miempresa.php");
$miempresa=new miempresa;
include_once($ruta."class/files.php");
$files=new files;
include_once($ruta."class/admdosificacion.php");
$admdosificacion=new admdosificacion;
include_once($ruta."class/vpagotit.php");
$vpagotit=new vpagotit;
include_once($ruta."class/vrecotit.php");
$vrecotit=new vrecotit;
include_once($ruta."class/personaplan.php");
$personaplan=new personaplan;
include_once($ruta."class/admplan.php");
$admplan=new admplan;
include_once($ruta."class/ctbdia.php");
  $ctbdia=new ctbdia;
include_once($ruta."funciones/funciones.php");
require_once($ruta.'recursos/pdf/tcpdf/tcpdf.php');
include($ruta."recursos/qr/qrlib.php"); 
/******************    SEGURIDAD *************/
//******* SEGURIDAD GET *************/
extract($_GET);
$valor=dcUrl($lblcode);

$dcontratodet=$vcontratodet->muestra($valor);
$dcontr=$admcontrato->muestra($dcontratodet['idadmcontrato']);
$dorg=$admorgani->muestra($dcontr['idorganigrama']);
$dorgz=$admorganizacion->muestra($dorg['idadmorganizacion']);
$norgz=$dorgz['nombre'];

$dejecutivo=$vejecutivo->muestra($dcontratodet['idadmejecutivo']);
$idcontrato=$dcontratodet['idadmcontrato'];
$dperplan=$personaplan->mostrarUltimo("idcontrato=".$idcontrato);
$dplan=$admplan->muestra($dperplan['idadmplan']);

$dpago=$vrecotit->muestra($valor);

$dsuc=$admsucursal->mostrarUltimo("idsede=".$dcontratodet['idsede']);
$demp=$miempresa->muestra($dsuc['idmiempresa']);
$dsede=$sede->muestra($dsuc['idsede']);
$dfoto=$files->mostrarUltimo("id_publicacion=".$dsuc['idmiempresa']." and tipo_foto='LogoEmpresa'");

$dct=$ctbdia->mostrarUltimo("estado=1");
$tc=number_format($dct['dolar'], 2, '.', '');
// **********  obtener organizacion      ***********************************************************/
// logo e info de golden

$rutaImg=$ruta."factura/miempresa/server/php/".$dsuc['idmiempresa']."/".$dfoto['name'];
$nombreG=$demp['nombre'];

$nsuc=$dsuc['nombre'];
$dirG=$dsuc['direccion'];
$zonaG=$dsuc['zona'];
$fonos="Telfs: ".$dsuc['telefonos'];
$nsede=$dsede['nombre'];

$lugarFecha=" ".$nsede.",". obtenerFechaLetra($dcontratodet['fecha']);

// SUCURSAL CASA MATRIZ
$sucMt=$admsucursal->muestra(5);
$nsucM=$sucMt['nombre'];
$dirGM=$sucMt['direccion'];
$zonaGM=$sucMt['zona'];
$fonosM="Telfs: ".$sucMt['telefonos'];
$ds=$sede->muestra(1);
$nsedeM=$ds['nombre'];






/***************************************************************************************************/

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
$html=' <br><br>
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
.letras1{
  font-size:8px;
}
.letras2{
  font-size:14px;
}
.letras3{
  font-size:8px;
}
</style>
<table width="100%"  align="center">
          <tr>
            <td width="40%" class="letras">
              <center>
                <img width="150px;" src="'.$rutaImg.'" ><br>
                <b>'.$nombreG.'</b><br>
                ';
                $html=$html.'

                '.$nsede.'-BOLIVIA
              </center>
            </td>
            <td width="30%"><br><br>
              <div class="tituloFactura">RECORD DE PRODUCCION</div>
            </td>
            <td width="30%">
              <table border="1">
                <tr>
                  <td>
                    <table class="letras1" cellpadding="1">
                      <tr>
                        <td align="right">
                          Nº RECORD :
                        </td>
                        <td align="left">
                          <b>'.$dcontratodet['record'].'</b>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">
                          Nº CONTRATO :
                        </td>
                        <td align="left">
                          <b>'.$dcontratodet['nrocontrato'].'</b>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">
                          FECHA:
                        </td>
                        <td align="left">
                          <b>'.$dcontratodet['fecha'].'</b>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">
                          HORA:
                        </td>
                        <td align="left">
                          <b>'.$dcontratodet['hora'].'</b>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">
                          T/C:
                        </td>
                        <td align="left">
                          <b>'.$tc.'</b>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>';
        $pdf->SetFont('helvetica', '', 10);
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
  border-right: solid 1px #fff;
  border-bottom: solid 1px #606060;
  border-left: solid 1px #fff;
}
.letras{
  font-size:6px;
  text-align: center;
}
.letras3{
  font-size:7px;
}
.letras4{
  font-size:8px;
}
.letras5{
  font-size:9px;
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
}
.cabecera3{
	border-top: solid 1px #606060;
	border-bottom: solid 1px #606060;
	border-left: solid 1px #606060;
	border-right: solid 1px #606060;
}
.cabecera4{
	border-top: solid 1px #606060;
	border-bottom: solid 1px #606060;
	border-left: solid 1px #606060;
	border-right: solid 1px #606060;
	margin-top: 20px;
}
.tabla{
  border-top: solid 1px #606060;
  border-bottom: solid 1px #606060;
  border-left: solid 1px #606060;
  border-right: solid 1px #606060;
}
</style>';
$html=$html.'
<table class="cabecera3" width="530">
  <tr>
    <td width="50%"><b> Lugar y Fecha : </b>'.$lugarFecha.'</td>
  
    <td width="50%"><b>Titular : </b>'.$dpago['nombre']." ".$dpago['paterno']." ".$dpago['materno'].'</td>
  </tr>
</table>
<br><br>
<table  width="530" class="tabla">
  <tr style="background-color:#f2f2f2; border:none;">
    <td class="cabecera4 tituloCenda" width="55%"><b>CONCEPTO</b></td>
    <td class="cabecera4  sMoneda" width="15%"><b>Monto</b></td>
    <td class="cabecera4  sMoneda" width="15%"><b>Saldo Prod.</b></td>
    <td class="cabecera4  sMoneda" width="15%"><b>Saldo Cartera</b></td>
  </tr>
  <tr>
    <td class=""></td>
    <td class=""></td>
  </tr>';
  $totalP=0;
  foreach($admcontratodelle->mostrarTodo("record=".$dcontratodet['record']." and idcontrato=".$dcontratodet['idadmcontrato']) as $f)
    {
      $totalP=$totalP+$f['monto'];
      if ($f['moneda']=="BS") {
        $detalle="Pago en Bolivianos";
      }else{
        $detalle="Pago en Dolares";
      }
   		$html=$html.'
		<tr>
			<td class="">'.$detalle.'</td>
			<td class="sMoneda">'.number_format($f['monto'], 2, '.', '').'</td>
      <td class="sMoneda">'.number_format($f['saldo'], 2, '.', '').'</td>
      <td class="sMoneda">'.number_format($f['saldocartera'], 2, '.', '').'</td>

		</tr>';
	}
$html=$html.'
  <tr>
    <td class=""></td>
    <td class=""></td>
  </tr>
	<tr style="background-color:#f2f2f2; border:none;">
      <td class="cabecera4 sMoneda"></td>
			<td class="cabecera4 sMoneda"><b>'.number_format($totalP, 2, '.', '').'</b></td>
      <td class="cabecera4 sMoneda"></td>
      <td class="cabecera4 sMoneda"></td>
		</tr>
</table>
Son:<b>'.strtoupper(num2letras(number_format($totalP, 2, '.', '')))." BOLIVIANOS ".'</b>
';
    $fechca = date_create($dcontratodet['fecha']);
    $fechaQr=date_format($fechca, 'd/m/Y');
    $costototal=$totalP;
    $codeContents = $valor.'|'.$dcontratodet['nrocontrato'].'|'.$dcontratodet['record'].'|'.$fechaQr.'|'.number_format($totalP, 2, '.', '').'|'.number_format($totalP, 2, '.', '').'|'; 
     
    // we need to generate filename somehow,  
    // with md5 or with database ID used to obtains $codeContents... 
    $fileName = 'qr/'.$valor.'.png'; 
     
    $pngAbsoluteFilePath = $fileName; 
    $urlRelativeFilePath = $fileName; 
    if (!file_exists($pngAbsoluteFilePath)) { 
        QRcode::png($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_L, 3);
    }
  $html=$html.'
  <br>
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
        <td class="letras4"><b> '.number_format($dcontratodet['pagado'], 2, '.', ',').' Bs.-</b></td>
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

// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
$pdf->Output('Record'.$valor.'.pdf', 'I');

 ?>
