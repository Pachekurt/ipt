<?php
session_start();
$ruta="../../../";
$folder="";
include_once($ruta."class/dominio.php");
$dominio=new dominio;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."class/vtitular.php");
$vtitular=new vtitular;
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo;
include_once($ruta."class/sede.php");
$sede=new sede;
include_once($ruta."class/factura.php");
$factura=new factura;
include_once($ruta."class/facturadet.php");
$facturadet=new facturadet;
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
include_once($ruta."class/factcliente.php");
$factcliente=new factcliente;
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
$dfactura=$factura->muestra($valor);

$dsuc=$admsucursal->muestra($dfactura['idsucursal']);

$imgSinV="";
if ($dfactura['esprueba']==1) {
  $imgSinV='<img width="200px" src="'.$ruta.'imagenes/SinValor.png" />';
}

$demp=$miempresa->muestra($dsuc['idmiempresa']);
$dsede=$sede->muestra($dsuc['idsede']);
$dfoto=$files->mostrarUltimo("id_publicacion=".$dsuc['idmiempresa']." and tipo_foto='LogoEmpresa'");

$ddos=$admdosificacion->mostrarUltimo("idadmdosificacion=".$dfactura['iddosificacion']);
// **********  obtener organizacion      ***********************************************************/
// logo e info de golden

$rutaImg=$ruta."factura/miempresa/server/php/".$dsuc['idmiempresa']."/".$dfoto['name'];
$nombreG=$demp['nombre'];

$nsuc=$dsuc['nombre'];
$dirG=$dsuc['direccion'];
$zonaG=$dsuc['zona'];
$fonos="Telfs: ".$dsuc['telefonos'];
$nsede=$dsede['nombre'];


// SUCURSAL CASA MATRIZ
$sucMt=$admsucursal->muestra(8);
$nsucM=$sucMt['nombre'];
$dirGM=$sucMt['direccion'];
$zonaGM=$sucMt['zona'];
$fonosM="Telfs: ".$sucMt['telefonos'];
$ds=$sede->muestra(1);
$nsedeM=$ds['nombre'];


//datos de facturacion
$nitgolden=$demp['nit'];
$autorizacion=$ddos['autorizacion'];
$nrofactura=$dfactura['nro'];
$actividad=$dsuc['actividad'];

if ($dfactura['impresion']==0) {
	$dtipo="ORIGINAL";
}else{
	$dtipo="COPIA";
}
// Actualiza cantidad de impresiones
$valFactura=array(
  "impresion"=>$dfactura['impresion']+1
);  
$factura->actualizar($valFactura,$valor);

// cabecera factura
$lugarFecha=" ".$nsede.",". obtenerFechaLetra($dfactura['fecha']);
$matricula=$dfactura['matricula'];

$razonT="ERROR";
$nitT="ERROR";
$razonT=$dfactura['razon'];
$nitT=$dfactura['nit'];


//pie
$fechca = date_create($ddos['fechalimite']);
$fechaQr=date_format($fechca, 'd/m/Y');

$control=$dfactura['control'];
$fechalimite=$fechaQr;
$leyenda=$ddos['leyenda'];



/***************************************************************************************************/

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf->SetPrintHeader(false);
$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('INGLES PARA TODOS');
$pdf->SetTitle('FACTURA');
$pdf->SetSubject('SWCGB');
$pdf->SetKeywords('FACTURA');


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
  font-size:15px;
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
            <td width="45%" class="letras">
              <center>
                <img width="150px;" src="'.$rutaImg.'" ><br>
                <b>'.$nombreG.'</b><br>
                ';
                if ($dsuc['tipo']==0) {
                  $html=$html.'
                    <b>'.$nsucM.'</b><br>
                    '.$dirGM.'-'.$zonaGM.'<br>
                    '.$fonosM.'<br>
                    '.$nsedeM.'-BOLIVIA <br>
                  ';
                }
                $html=$html.'

                <b>'.$nsuc.'</b><br>
                '.$dirG.'-'.$zonaG.'<br>
                '.$fonos.'<br>
                '.$nsede.'-BOLIVIA
              </center>
            </td>
            <td width="20%"><br><br><br>
              <div class="tituloFactura">FACTURA</div>
            </td>
            <td width="35%">
              <table border="1">
                <tr>
                  <td>
                    <table class="letras1" cellpadding="1">
                      <tr>
                        <td align="right">
                          NIT :
                        </td>
                        <td align="left">
                          <b>'.$nitgolden.'</b>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">
                          FACTURA Nº :
                        </td>
                        <td align="left">
                          <b>'.$nrofactura.'</b>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">
                          AUTORIZACIÓN Nº:
                        </td>
                        <td align="left">
                          <b>'.$autorizacion.'</b>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <br>
              <center>
                <b>'.$dtipo.'</b><br>
                <span class="letras3">'.$actividad.'</span>
              </center>
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
    <td width="70%"><b> Lugar y Fecha : </b>'.$lugarFecha.'</td>
    <td width="30%"><b>Nº Matrícula : </b>'.$matricula.'</td>
  </tr>
  <tr>
    <td><b>Señor(es) : </b>'.$razonT.'</td>
    <td><b>NIT/CI : </b>'.$nitT.'</td>
  </tr>
</table>
<br><br>
<table  width="530" class="tabla">
  <tr style="background-color:#f2f2f2; border:none;">
    <td class="cabecera4 tituloCenda" width="80%"><b>CONCEPTO</b></td>
    <td class="cabecera4  sMoneda" width="20%"><b>SUBTOTAL</b></td>
  </tr>
  <tr>
    <td class=""></td>
    <td class=""></td>
  </tr>';
  foreach($facturadet->mostrarTodo("idfactura=$valor") as $f)
    {
    	$subtotal=$f['precio']*$f['cantidad'];
   		$html=$html.'
		<tr>
			<td class="">'.$f['detalle'].'</td>
			<td class="sMoneda">'.number_format($subtotal, 2, '.', '').'</td>
		</tr>';
	}
$html=$html.'
  <tr>
    <td class=""></td>
    <td class=""></td>
  </tr>
	<tr style="background-color:#f2f2f2; border:none;">
			<td class="cabecera4"> 
				<table>
				    <tr >
				      <td width="80%" >Son:<b>'.strtoupper(num2letras(number_format($dfactura['total'], 2, '.', '')))." BOLIVIANOS ".'</b></td>
				      <td><b>TOTAL A PAGAR</b></td>
				    </tr>
				</table>
			</td>
			<td class="cabecera4 sMoneda"><b>'.number_format($dfactura['total'], 2, '.', '').'</b></td>
		</tr>
</table>';
    $fechca = date_create($dfactura['fecha']);
    $fechaQr=date_format($fechca, 'd/m/Y');
    $costototal=$dfactura['total'];
    $codeContents = $nitgolden.'|'.$nrofactura.'|'.$autorizacion.'|'.$fechaQr.'|'.number_format($dfactura['total'], 2, '.', '').'|'.number_format($dfactura['total'], 2, '.', '').'|'.$control.'|'.$nitT.'|0|0|0|0'; 
     
    // we need to generate filename somehow,  
    // with md5 or with database ID used to obtains $codeContents... 
    $fileName = 'qr/'.$valor.'.png'; 
     
    $pngAbsoluteFilePath = $fileName; 
    $urlRelativeFilePath = $fileName; 
    if (!file_exists($pngAbsoluteFilePath)) { 
        QRcode::png($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_L, 3);
    }
  $html=$html.'<br>
  <br><table>
	  <tr>
	    <td width="440">
	      <table>
        <tr>
          <td class="letras5"><b>Saldo: </b>'.number_format($dfactura['saldo'], 2, '.', '').' Bolivianos</td>
          <td class="letras5"></td>
        </tr>
	      <tr>
	        <td class="letras5"><b>Código de Control: </b>'.$control.'</td>
	        <td class="letras5"><b>Fecha Límite de Emisión:</b> '.$fechalimite.'</td>
	      </tr>
	     </table><br>
	     <table align="center">
	      <tr>
	        <td class="letras"><br><br><b>
	        "ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS. EL USO ILÍCITO DE ÉSTA SERÁ SANCIONADO DE ACUERDO A LEY"</b><br>
	        	'.$leyenda.'
            <br>
            '.$imgSinV.'
	        </td>
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

/*****************************   IMPRESION COPIA  ****************************/
$html=' <br><br>
<style>
.tituloFactura{
  font-size:15px;
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
            <td width="45%" class="letras">
              <center>
                <img width="150px;" src="'.$rutaImg.'" ><br>
                <b>'.$nombreG.'</b><br>
                ';
                //si la factura es una sucursal
                if ($dsuc['tipo']==0) {
                  $html=$html.'
                    <b>'.$nsucM.'</b><br>
                    '.$dirGM.'-'.$zonaGM.'<br>
                    '.$fonosM.'<br>
                    '.$nsedeM.'-BOLIVIA <br>
                  ';
                }
                //normal cuando es sucursal central
                $html=$html.'

                <b>'.$nsuc.'</b><br>
                '.$dirG.'-'.$zonaG.'<br>
                '.$fonos.'<br>
                '.$nsede.'-BOLIVIA
              </center>
            </td>
            <td width="20%"><br><br><br>
            	<div class="tituloFactura">FACTURA</div>
            </td>
            <td width="35%">
              <table border="1">
                <tr>
                  <td>
                    <table class="letras1" cellpadding="1">
                      <tr>
                        <td align="right">
                          NIT :
                        </td>
                        <td align="left">
                          <b>'.$nitgolden.'</b>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">
                          FACTURA Nº :
                        </td>
                        <td align="left">
                          <b>'.$nrofactura.'</b>
                        </td>
                      </tr>
                      <tr>
                        <td align="right">
                          AUTORIZACIÓN Nº:
                        </td>
                        <td align="left">
                          <b>'.$autorizacion.'</b>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <br>
              <center>
              	<b>COPIA</b><br>
              	<span class="letras3">'.$actividad.'</span>
              </center>
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
    <td width="70%"><b> Lugar y Fecha : </b>'.$lugarFecha.'</td>
    <td width="30%"><b>Nº Matrícula : </b>'.$matricula.'</td>
  </tr>
  <tr>
    <td><b>Señor(es) : </b>'.$razonT.'</td>
    <td><b>NIT/CI : </b>'.$nitT.'</td>
  </tr>
</table>
<br><br>
<table  width="530" class="tabla">
  <tr style="background-color:#f2f2f2; border:none;">
    <td class="cabecera4 tituloCenda" width="80%"><b>CONCEPTO</b></td>
    <td class="cabecera4  sMoneda" width="20%"><b>SUBTOTAL</b></td>
  </tr>
  <tr>
    <td class=""></td>
    <td class=""></td>
  </tr>';
  foreach($facturadet->mostrarTodo("idfactura=$valor") as $f)
    {
    	$subtotal=$f['precio']*$f['cantidad'];
   		$html=$html.'
		<tr>
			<td class="">'.$f['detalle'].'</td>
			<td class="sMoneda">'.number_format($subtotal, 2, '.', '').'</td>
		</tr>';
	}
$html=$html.'
  <tr>
    <td class=""></td>
    <td class=""></td>
  </tr>
	<tr style="background-color:#f2f2f2; border:none;">
			<td class="cabecera4"> 
				<table>
				    <tr >
				      <td width="80%" >Son:<b> '.strtoupper(num2letras(number_format($dfactura['total'], 2, '.', '')))." BOLIVIANOS ".'</b></td>
				      <td><b>TOTAL A PAGAR</b></td>
				    </tr>
				</table>
			</td>
			<td class="cabecera4 sMoneda"><b>'.number_format($dfactura['total'], 2, '.', '').'</b></td>
		</tr>
</table>';
  $html=$html.'<br>
  <br><table>
	  <tr>
	    <td width="440">
	      <table>
        <tr>
          <td class="letras5"><b>Saldo: </b>'.number_format($dfactura['saldo'], 2, '.', '').' Bolivianos</td>
          <td class="letras5"></td>
        </tr>
	      <tr>
	        <td class="letras5"><b>Código de Control: </b>'.$control.'</td>
	        <td class="letras5"><b>Fecha Límite de Emisión:</b> '.$fechalimite.'</td>
	      </tr>
	     </table><br>
	     <table align="center">
	      <tr>
	        <td class="letras"><br><br><b>
	        "ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS. EL USO ILÍCITO DE ÉSTA SERÁ SANCIONADO DE ACUERDO A LEY"</b><br>
	        	'.$leyenda.'

            <br>
            '.$imgSinV.'
	        </td>
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
$pdf->Output('FacturaCod'.$valor.'.pdf', 'I');

 ?>
