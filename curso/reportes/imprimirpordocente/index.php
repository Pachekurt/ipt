<?php 
$ruta="../../../";
$folder="";
require $ruta."recursos/pdf/fpdf/fpdf.php";
extract($_GET);
$iddoc=$iddocente;
include_once($ruta."class/vdocente.php");
$vdocente=new vdocente;
include_once($ruta."class/vdocente.php");
$vdocente=new vdocente;
include_once($ruta."class/vcurso.php");
$vcurso=new vcurso;
//include_once($ruta."class/vestudiantefull.php");
//$vestudiantefull=new vestudiantefull;
 


class PDF extends FPDF
{
   //Cabecera de página
   function Header()
   {
        $linea=0;//definimos si el reporte tendra margenes
        $saltoLinea=5;//definimos cuantos pixeles saltara hacia abajo

        $this->Image('../../../imagenes/logo.png',10,8,40);
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
    
    $saltoLinea=4;
   
    $pdf->Ln(5);
    $pdf->Cell(20,4);
        
    $linea=0;//definimos si el reporte tendra margenes
    $saltoLinea=4;//definimos cuantos pixeles saltara hacia abajo

      $datodocente=   $vdocente->muestra($iddoc);
 
$pdf->Ln(5);
 $pdf->SetFont('Arial', '', 12  );
    $pdf->Ln(5);
    $pdf->Cell(20,4);
    $pdf->Cell(25, 4,"DOCENTE: ".$datodocente['nombre']." ".$datodocente['paterno'], $linea);
    $saltoLinea=4;
   
 $pdf->Ln(10);

         $pdf->SetFont('Arial', 'B', 10);
         $pdf->Cell(20,0);
         $pdf->Cell(20, $saltoLinea, 'MODULO', $linea);
         $pdf->Cell(30, $saltoLinea, 'DESCRIPCION', $linea);
         $pdf->Cell(30, $saltoLinea, 'HORARIO', $linea);
         $pdf->Cell(40, $saltoLinea, 'FECHA DE INICIO', $linea);
         $pdf->Cell(25, $saltoLinea, 'FECHA DE FIN', $linea);


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
    foreach($vcurso->mostrartodo("idejecutivo=$iddoc") as $dcurso)
    {
        
        $pdf->Ln($saltoLinea);
        $pdf->Cell(20,0);
        $pdf->Cell(20, $saltoLinea, $dcurso['modulo'],     $linea);      
        $pdf->Cell(30, $saltoLinea, $dcurso['mdescripcion'],     $linea);      
        $pdf->Cell(30, $saltoLinea, $dcurso['inicio'].' a '.$dcurso['fin'],     $linea);
        $pdf->Cell(40, $saltoLinea, $dcurso['fechainicio'],     $linea);
        $pdf->Cell(30, $saltoLinea, $dcurso['fechafin'],     $linea);
       
        $i++; 
       
    }



$pdf->Output();


?>

