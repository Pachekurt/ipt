<?php 
$ruta="../../../../../";
$folder="";
require $ruta."recursos/pdf/fpdf/fpdf.php";
extract($_GET);
include_once($ruta."class/vppt.php");
$vppt=new vppt;
include_once($ruta."class/vvinculado.php");
$vvinculado=new vvinculado;

include_once($ruta."funciones/funciones.php");

$pp= dcUrl($lblcode); 

$datosEst = $vppt->mostrarTodo("idvppt=$pp");
$datosEst = array_shift($datosEst);
class PDF extends FPDF
{
   //Cabecera de página
   function Header()
   {
        $linea=0;//definimos si el reporte tendra margenes
        $saltoLinea=5;//definimos cuantos pixeles saltara hacia abajo

        $this->Image('../../../../../imagenes/logo.png',10,8,40);
        $this->SetFont('Arial','I',8);
        $this->Cell(60,0);
        $this->Cell(20,0,'CENTRO DE CAPACITACION TECNICA',0,0,'C');
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
        $this->SetFont('Arial','B',10);
        $this->Cell(100, 1, 'REPORTE DE REGISTRO', 0);
        
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
    $pdf->Cell(25, 4,'DATOS DEL TITULAR: ' , $linea);
    $saltoLinea=4;
   
    $pdf->Ln(5);
    $pdf->Cell(20,4);
        $pdf->Cell(25, 4,'________________________________________________________________' , $linea);

    $linea=0;//definimos si el reporte tendra margenes
    $saltoLinea=4;//definimos cuantos pixeles saltara hacia abajo

    $pdf->SetFont('Arial', '', 8  );
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'NOMBRE: ' , $linea);
    $pdf->Cell(55, 4, $datosEst['nombre'].' '.$datosEst['paterno'].' '.$datosEst['materno'] , $linea);
    $pdf->Cell(25, 4,'CARNET: ' , $linea);
    $pdf->Cell(25, 4, $datosEst['carnet'] , $linea);
   
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'E-MAIL: ' , $linea);
    $pdf->Cell(55, 4,$datosEst['email'] , $linea);
    $pdf->Cell(25, 4,'CELULAR: ' , $linea);
    $pdf->Cell(25, 4, $datosEst['celular'] , $linea);
     
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'NACIMIENTO: ' , $linea);
    $pdf->Cell(55, 4,$datosEst['nacimiento'] , $linea);
    $pdf->Cell(25, 4,'OCUPACION: ' , $linea);
    $pdf->Cell(25, 4, $datosEst['ocupacion'] , $linea);
        
$pdf->SetFont('Arial', '', 12  );
    $pdf->Ln(12);
    $pdf->Cell(20,4);
    $pdf->Cell(25, 4,'DATOS DEL CONTRATO: ' , $linea);
    $saltoLinea=4;
   
    $pdf->Ln(5);
    $pdf->Cell(20,4);
    $pdf->Cell(25, 4,'________________________________________________________________' , $linea);


    $pdf->SetFont('Arial', '', 8  );
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'N° CONTRATO: ' , $linea);
    $pdf->Cell(55, 4,$datosEst['nrocontrato'] , $linea);
    $pdf->Cell(25, 4,'N° CUENTA: ' , $linea);
    $pdf->Cell(25, 4, $datosEst['numcuenta'] , $linea);
    
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'FECHA INICIO :' , $linea);
    $pdf->Cell(55, 4,$datosEst['fechainicio'] , $linea);
     
    $pdf->Cell(25, 4,'FECHA FIN: ' , $linea);
    $pdf->Cell(25, 4,$datosEst['fechafin'] , $linea);
    
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'PLAN: ' , $linea);
    $pdf->Cell(55, 4,$datosEst['nplan'] , $linea);
    $pdf->Cell(25, 4,'MESES: ' , $linea);
    $pdf->Cell(25, 4,$datosEst['cuotas'] , $linea);
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'PRECIO: ' , $linea);
    $pdf->Cell(55, 4,$datosEst['inversion'] , $linea);
    
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'FECHA REGISTRO: ' , $linea);
    $pdf->Cell(55, 4,$datosEst['fechacreacion'] , $linea);
    $pdf->Cell(25, 4,'HORA REGISTRO: ' , $linea);
    $pdf->Cell(25, 4,$datosEst['horacreacion'] , $linea);


$pdf->SetFont('Arial', '', 12  );
    $pdf->Ln(12);
    $pdf->Cell(20,4);
    $pdf->Cell(25, 4,'DATOS DOMICILIARIOS: ' , $linea);
    $saltoLinea=4;
   
    $pdf->Ln(5);
    $pdf->Cell(20,4);
        $pdf->Cell(25, 4,'________________________________________________________________' , $linea);

    $linea=0;//definimos si el reporte tendra margenes
    $saltoLinea=4;//definimos cuantos pixeles saltara hacia abajo

    $pdf->SetFont('Arial', '', 8  );
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'ZONA: ' , $linea);
    $pdf->Cell(55, 4, $datosEst['zona'] , $linea);
    $pdf->Cell(25, 4,'TELEFONO: ' , $linea);
    $pdf->Cell(25, 4, $datosEst['telefono'] , $linea);
   
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'DIRECCION: ' , $linea);
    $pdf->Cell(95, 4, $datosEst['direccion'] , $linea);
       
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'DESCRIPTIVA: ' , $linea);
    $pdf->Cell(95, 4,$datosEst['dirdesc'] , $linea);
    
    $pdf->SetFont('Arial', '', 12  );
    $pdf->Ln(12);
    $pdf->Cell(20,4);
    $pdf->Cell(25, 4,'DATOS LABORALES: ' , $linea);
    $saltoLinea=4;
   
    $pdf->Ln(5);
    $pdf->Cell(20,4);
        $pdf->Cell(25, 4,'________________________________________________________________' , $linea);

    $linea=0;//definimos si el reporte tendra margenes
    $saltoLinea=4;//definimos cuantos pixeles saltara hacia abajo

    $pdf->SetFont('Arial', '', 8  );
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'ZONA: ' , $linea);
    $pdf->Cell(55, 4, $datosEst['zonal'] , $linea);
    $pdf->Cell(25, 4,'TELEFONO: ' , $linea);
    $pdf->Cell(25, 4, $datosEst['telefonol'] , $linea);
   
    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'DIRECCION: ' , $linea);
    $pdf->Cell(55, 4, $datosEst['direccionl'] , $linea);
    $pdf->Cell(25, 4,'DESCRIPTIVA: ' , $linea);
    $pdf->Cell(25, 4,$datosEst['dirdescl'] , $linea);

    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'EMPRESA: ' , $linea);
    $pdf->Cell(55, 4, $datosEst['empresa'] , $linea);
    $pdf->Cell(25, 4,'CARGO: ' , $linea);
    $pdf->Cell(25, 4,$datosEst['cargo'] , $linea);

    $pdf->Ln(5);
    $pdf->Cell(30,4);
    $pdf->Cell(30, 4,'ANTIGUEDAD: ' , $linea);
    $pdf->Cell(55, 4, $datosEst['antiguedad']." Años" , $linea);
    $pdf->Cell(25, 4,'INGRESO: ' , $linea);
    $pdf->Cell(25, 4,$datosEst['ingresos']." Bs.-" , $linea);
    

    $pdf->SetFont('Arial', '', 12  );
    $pdf->Ln(12);
    $pdf->Cell(20,4);
    $pdf->Cell(25, 4,'BENEFICIARIOS: ' , $linea);
    $saltoLinea=4;
   
    $pdf->Ln(5);
    $pdf->Cell(20,4);
    $pdf->Cell(25, 4,'________________________________________________________________' , $linea);

    $pdf->SetFont('Arial', '', 7  );
    $pdf->Ln(10);
    $pdf->Cell(25, $saltoLinea,' ' , $linea);
    $pdf->Cell(5, $saltoLinea, 'N.', $linea);
    $pdf->Cell(70, $saltoLinea, 'NOMBRE', $linea);
    $pdf->Cell(20, $saltoLinea, 'CELULAR', $linea);
    $pdf->Cell(20, $saltoLinea, 'CONTRATO', $linea);
    $pdf->Cell(20, $saltoLinea, 'ESTADO', $linea);
     
    $pdf->Ln(1);
    $pdf->SetFont('Arial','',5);

    $pdf->Cell(20,4);
    $pdf->Cell(15, $saltoLinea, '_________________________________________________________________________________________________________________________________________________________', $linea);
    $pdf->Ln(1);

    $linea=0;//definimos si el reporte tendra margenes
    $saltoLinea=4;//definimos cuantos pixeles saltara hacia abajo

    $pdf->SetFont('Arial', '', 7);
    $i=1;
    foreach($vvinculado->mostrarTodo("idpersonaplan=".$pp) as   $dato)
    {
         switch ($dato['activo']) {
            case '1':
                    $estate= 'Habilitado';
                break;
            case '0':
                 $estate= 'Pendiente';
                break;
            case '2':
                 $estate= 'Baja';
                break;
            
        }      
        $pdf->Ln($saltoLinea);
        $pdf->Cell(25, $saltoLinea, '',     $linea);

        $pdf->Cell(5, $saltoLinea, $i,     $linea);
        $pdf->Cell(70, $saltoLinea, $dato['nombre'].' '.$dato['paterno'].' '.$dato['materno'],     $linea); 
        $pdf->Cell(20, $saltoLinea, $dato['celular'],     $linea);         
        $pdf->Cell(20, $saltoLinea, $dato['nrocontrato'],     $linea,'','C');
        $pdf->Cell(20, $saltoLinea, $estate,    $linea); 
        $i++; 
    }


$pdf->Output();


?>
