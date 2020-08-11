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
$demp=$miempresa->muestra($dsuc['idmiempresa']);
$dsede=$sede->muestra($dsuc['idsede']);
$dfoto=$files->mostrarUltimo("id_publicacion=".$dsuc['idmiempresa']." and tipo_foto='LogoEmpresa'");

$ddos=$admdosificacion->mostrarUltimo("idadmsucursal=".$dfactura['idsucursal']." and estado=1");
// **********  obtener organizacion      ***********************************************************/
// logo e info de golden

$rutaImg=$ruta."factura/miempresa/server/php/".$dsuc['idmiempresa']."/".$dfoto['name'];
$nombreG=$demp['nombre'];
$nsuc=$dsuc['nombre'];
$dirG=$dsuc['direccion'];
$zonaG=$dsuc['zona'];
$fonos="Telfs: ".$dsuc['telefonos'];
$nsede=$dsede['nombre'];

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
// actualiza cantidad de impresiones
$valFactura=array(
  "impresion"=>$dfactura['impresion']+1
);  
$factura->actualizar($valFactura,$valor);

// cabecera factura
$dfecha = date_create($dfactura['fecha']);
$fechaPAgo=date_format($dfecha, 'd/m/Y');

$fechaPAgo=" ".$nsede.",". $fechaPAgo;
$matricula=$dfactura['matricula'];

$razonT="ERROR";
$nitT="ERROR";
if ($dfactura['tipotabla']=='CART') {
	$dpago=$vpagotit->muestra($dfactura['idtabla']);
	$razonT=$dpago['razon'];
	$nitT=$dpago['nit'];
}

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
// Set some content to print
    $pdf->SetFont('helvetica', '', 6);
$html='
<style>
	.tituloCenda{
	  font-size:7px;
	}
</style>
<table width="150" class="tituloCenda" border="1"  align="center">
	<tr>
		<td>
			<b>'.$nombreG.'</b><br>
			<center>
				'.$nsuc.'<br>
				'.$dirG.'<br>'.$zonaG.'<br>
				'.$fonos.'<br>
				'.$nsede.'-BOLIVIA <br>
				<b>FACTURA</b><br>
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
                  </table><br>
                  '.$actividad.'<br>
                  <b> Lugar y Fecha : </b>'.$fechaPAgo.'<br>
                  <b>Nº Matricula : </b>'.$matricula.'<br>
                  <b>Señor(es) : </b>'.$razonT.'<br>
                  <b>NIT/CI : </b>'.$nitT.'<br>
                  <table >
					  <tr>
						    <td width="80%"><b>Concepto</b></td>
						    <td width="20%"><b>Total</b></td>
						  </tr>';
						  foreach($facturadet->mostrarTodo("idfactura=$valor") as $f)
						    {
						    	$subtotal=$f['precio']*$f['cantidad'];
						   		$html=$html.'
								<tr>
									<td><br> <br>'.$f['detalle'].'<br></td>
									<td><br><br>'.number_format($subtotal, 2, '.', ',').'<br></td>
								</tr>';
							}
						$html=$html.'
						<tr style="background-color:#f2f2f2; border:none;">
						<td class="cabecera4"> 
							<b>TOTAL PAGO</b>
						</td>
						<td class="cabecera4 sMoneda"><b>'.number_format($dfactura['total'], 2, '.', '').'</b></td>
					</tr>
				</table><br>
				<b> SON: </b>'.strtoupper(num2letras(number_format($dfactura['total'], 2, '.', '')))." BOLIVIANOS ".'<br>
				<b>Codigo de Control: </b>'.$control.'<br>
				<b>Fecha Limite de Emision:</b> '.$fechalimite.'<br>
				<img width="100px" src="'.$urlRelativeFilePath.'" /><br>
				<b>
	        	"ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS. EL USO ILÍCITO DE ÉSTA SERÁ SANCIONADO DE ACUERDO A LEY"</b><br>
	        	'.$leyenda.'
        <h1>Sin Valor Legal</h1>
			</center>
		</td>
	</tr>
</table>';
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->Output('FacturaCod'.$valor.'.pdf', 'I');

 ?>
