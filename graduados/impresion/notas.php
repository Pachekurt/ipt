<?php 
$ruta="../../";
$folder="";
require $ruta."recursos/pdf/fpdf/fpdf.php";
 
require_once($ruta.'recursos/pdf/tcpdf/tcpdf.php');
//include($ruta."recursos/qr/qrlib.php");
include_once($ruta."class/vobservacion.php");
$vobservacion=new vobservacion;
extract($_GET);
include_once($ruta."class/asistencia.php");
$asistencia=new asistencia;
include_once($ruta."class/vasistencia.php");
$vasistencia=new vasistencia;
include_once($ruta."class/vasistenciatotal.php");
$vasistenciatotal=new vasistenciatotal;
include_once($ruta."class/vestudiante.php");
$vestudiante=new vestudiante;
include_once($ruta."class/vestudiantefull.php");
$vestudiantefull=new vestudiantefull;
include_once($ruta."class/modulo.php");
$modulo=new modulo;
include_once($ruta."class/vusuario.php");
$vusuario=new vusuario;
include_once($ruta."class/vcurso.php");
$vcurso=new vcurso;

include_once($ruta."funciones/funciones.php");

$ide= dcUrl($idecod); 

$ves = $vestudiante->mostrarTodo("idvestudiante=$ide");
$ves = array_shift($ves);


$datoe = $vestudiantefull->mostrarTodo("idestudiante=$ide");
$datoe = array_shift($datoe);
class PDF extends FPDF
{
   //Cabecera de página
   function Header()
   {
        $linea=0;//definimos si el reporte tendra margenes
        $saltoLinea=5;//definimos cuantos pixeles saltara hacia abajo

        $this->Image('../../imagenes/logo.png',10,8,40);
        $this->SetFont('Arial','I',8);
        $this->Cell(60,0);
        $this->Cell(20,0,'CENTRO DE CAPACITACION TECNICA PRIVADO',0,0,'C');
        $this->SetFont('Arial','B',8);
        $this->Cell(45,0);
        $this->Cell(20,0,'Fecha: ',0,0,'C');
        $this->SetFont('Arial','',10);
        $this->Cell(23,0);
        $this->Cell(1,0,date('Y-m-d'),0,0,'C');  

    
        $this->Ln(5);
        $this->Cell(50,1);
        $this->Cell(40,1,'INGLES PARA TODOS S.A.',0,0,'C');
        $this->SetFont('Arial','B',10);
        $this->Cell(25,0);
       /* $this->Cell(10,0,'Usuario :',0,0,'C');   
        $this->SetFont('Arial','',10);
        $this->Cell(15,0);
        $this->Cell(1,0,"Administrador",0,0,'C');   
        */         
        $this->SetFont('Arial','B',10); 
        $this->Cell(14,0);
        $this->Cell(12,0,'Hora: ',0,0,'C');
        $this->SetFont('Arial','',10);
        $this->Cell(23,0);
        $this->Cell(1,0, date("H:i:s"),0,0,'C');   
        
        $this->Ln(10);
        $this->Cell(75,1);
        $this->SetFont('Arial','B',14);
        $this->Cell(100, 1, 'Reporte de asistencia', 0);
        
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 7);

   }

   function Footer() 
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(128);
        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
    }  
}


$pdf = new PDF();
$pdf->AddPage();


        $linea=0;//definimos si el reporte tendra margenes
    $saltoLinea=4;//definimos cuantos pixeles saltara hacia abajo

    $pdf->SetFont('Arial', '', 12  );
    $pdf->Ln(5);
    $pdf->Cell(20,4);
    $pdf->Cell(25, 4,'DATOS DEL ESTUDIANTE: ' , $linea);
    $saltoLinea=4;
   
    $pdf->Ln(5);
    $pdf->Cell(20,4);
        $pdf->Cell(25, 4,'________________________________________________________________' , $linea);

    $linea=0;//definimos si el reporte tendra margenes
    $saltoLinea=4;//definimos cuantos pixeles saltara hacia abajo

    $pdf->SetFont('Arial', '', 8  );
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(25, 4,'NOMBRE: ' , $linea);
    $pdf->Cell(60, 4, $ves['nombre'].' '.$ves['paterno'].' '.$ves['materno'] , $linea);
    $pdf->Cell(20, 4,'CARNET: ' , $linea);
    $pdf->Cell(25, 4, $ves['carnet'] , $linea);
   
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(25, 4,'E-MAIL: ' , $linea);
    $pdf->Cell(60, 4,$ves['email'] , $linea);
    $pdf->Cell(20, 4,'CELULAR: ' , $linea);
    $pdf->Cell(25, 4, $ves['celular'] , $linea);
     
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(25, 4,'NACIMIENTO: ' , $linea);
    $pdf->Cell(60, 4,$ves['nacimiento'] , $linea);
    $pdf->Cell(20, 4,'OCUPACION: ' , $linea);
    $pdf->Cell(25, 4, $ves['ocupacion'] , $linea);    
 
$pdf->Ln(5);
 $pdf->SetFont('Arial', '', 12  );
    $pdf->Ln(5);
    $pdf->Cell(20,4);
    $pdf->Cell(25, 4,'DATOS DEL CONTRATO: ' , $linea);
    $saltoLinea=4;
   
    $pdf->Ln(5);
    $pdf->Cell(20,4);
        $pdf->Cell(25, 4,'________________________________________________________________' , $linea);

    $linea=0;//definimos si el reporte tendra margenes
    $saltoLinea=4;//definimos cuantos pixeles saltara hacia abajo

    $pdf->SetFont('Arial', '', 8  );

    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(25, 4,'TITULAR: ' , $linea);
    $pdf->Cell(60, 4, $datoe['nombret'].' '.$datoe['paternot'].' '.$datoe['maternot'] , $linea);
    
    
    $pdf->Cell(20, 4,'CELULAR: ' , $linea);
    $pdf->Cell(25, 4, $datoe['celular'] , $linea);

    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(25, 4,'NUMERO: ' , $linea);
    $pdf->Cell(60, 4, $datoe['nrocontrato']  , $linea);
    $pdf->Cell(20, 4,'CUENTA: ' , $linea);
    $pdf->Cell(25, 4, $datoe['cuenta'] , $linea);
   
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(25, 4,'FECHA INICIO: ' , $linea);
    $pdf->Cell(60, 4,$datoe['fechainicio'] , $linea);
    $pdf->Cell(20, 4,'FECHA FIN: ' , $linea);
    $pdf->Cell(25, 4, $datoe['fechafin'] , $linea);
     
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(25, 4,'MODULO ACTUAL: ' , $linea);
    $pdf->Cell(60, 4,$datoe['modulo'] , $linea);
   
    $pdf->Cell(20, 4,'TUTOR: ' , $linea);
    $pdf->Cell(25, 4, $datoe['docente'] , $linea);
 $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20,0);
        $pdf->Cell(10, $saltoLinea, 'N.', $linea);
         $pdf->Cell(35, $saltoLinea, 'Fecha asistencia', $linea);
         $pdf->Cell(40, $saltoLinea, 'Docente', $linea);
        $pdf->Cell(20, $saltoLinea, 'Sesion', $linea);
        $pdf->Cell(25, $saltoLinea, 'Horario', $linea);
        $pdf->Cell(25, $saltoLinea, 'asistencia', $linea);

    $pdf->Ln(1);
    $pdf->SetFont('Arial','',5);

    $pdf->Cell(20,4);
    $pdf->Cell(15, $saltoLinea, '_________________________________________________________________________________________________________________________________________________________', $linea);
    $pdf->Ln(1);

    $linea=0;//definimos si el reporte tendra margenes
    $saltoLinea=4;//definimos cuantos pixeles saltara hacia abajo

    $pdf->SetFont('Arial', '', 7);
    $i=1;

    
      $Casis=0;
      $Cfaltas=0;
    foreach($vasistencia->mostrarTodo("idestudiante=".$ide) as $xf)
    {
         
        $pdf->Ln($saltoLinea);
        $pdf->Cell(20,0);
        $pdf->Cell(10, $saltoLinea, $i, $linea);
        $pdf->Cell(35, $saltoLinea, $xf['fechaasistencia'],     $linea); 
        $pdf->Cell(40, $saltoLinea, $xf['asesor'],     $linea);     
        $pdf->Cell(20, $saltoLinea, $xf['sesion'],     $linea);
        $pdf->Cell(25, $saltoLinea, $xf['inicio'] ,     $linea);  

        if ($xf['asis']==1)
       {
         $Casis=$Casis+1;
         $pdf->SetTextColor(50,142,59);
         $pdf->Cell(20, $saltoLinea, $xf['asistencia'] ,     $linea);   
         $pdf->SetTextColor(28,28,28);
       }
       if ($xf['asis']==0)
       {
          $Cfaltas=$Cfaltas+1;
          $pdf->SetTextColor(237,44,6);
          $pdf->Cell(20, $saltoLinea, $xf['asistencia'] ,     $linea);   
          $pdf->SetTextColor(28,28,28);
       }
        $i++; 
       
    }



$pdf->Output();


?>
