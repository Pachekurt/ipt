<?php
session_start();
$ruta="../../";
include_once($ruta."class/examen.php");
$examen=new examen;
include_once($ruta."class/examendetalle.php");
$examendetalle=new examendetalle;
include_once($ruta."class/pregunta.php");
$pregunta=new pregunta;
include_once($ruta."class/referencia.php");
$referencia=new referencia;
include_once($ruta."class/modulo.php");
$modulo=new modulo;
include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."class/estudiante.php");
$estudiante=new estudiante;


extract($_GET);

//$cotizacion=4126;

$ex=$examen->mostrarTodo("idestudiante=".$ides." and idestudiantereserva=".$ider); //idhis==idreservaestudiante
$ex=array_shift($ex);

     $est=$estudiante->mostrar($ides);
     $est=array_shift($est);
     $per=$persona->mostrar($est['idpersona']);
     $per=array_shift($per);

// create new PDF document

//$pdf->SetPrintHeader(false);


// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks

// set image scale factor

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/es.php')) {
    require_once(dirname(__FILE__).'/lang/es.php');
   
}

// ---------------------------------------------------------

// set default font subsetting mode

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
//$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.

// Set some content to print
$html=' 
<style>
.tituloFactura{
  font-size:12px;
}
.nombreestudiante{
  font-size:10px;
}
.tituloCenda{
  color:red;
}
</style>
<table width="100%" align="center">
                  <tr>
                    <td>
                      <center>
                        <img src="../../imagenes/logo.png"  width="110" height="40">
                        
                        <div>DIRECCION</div>
                        <b>Telefono: </b>2410650<br>
                        <b>Mail: </b>info@inglesgb.com
                      </center>
                    </td>
                    <td><br><br><br>
                    <div class="tituloFactura">EXAMEN DEL ESTUDIANTE</div>
                    <div class="nombreestudiante">'.$per['nombre'].' '.$per['paterno'].' '.$per['materno'].' CI: '.$per['carnet'].' '.$per['expedido'].'</div>

                    </td>
                    <td>
                      <table>
                        <tr>
                          <td align="right">
                            Código examen :
                          </td>
                          <td align="left">
                            <b>'.$ex['idexamen'].'</b>
                          </td>
                        </tr>
                      </table><br>
                      <br>
                    </td>
                  </tr>
                </table';

       
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
.det{
  text-align: left;
  
}
.sfila{
  padding:50px;
}

</style>

  <table border="1" width="704" cellpadding="3" cellspacing="0">
  <tr bgcolor="#f2f2f2">
    <td class="tituloCenda" width="350">
      Pregunta
    </td>
    <td class="tituloCenda" width="80">
      A
    </td>
    <td class="tituloCenda" width="80">B</td>
    <td class="tituloCenda" width="80">C</td>
    <td class="tituloCenda" width="80">Respuesta</td>
    <td class="tituloCenda" width="80">alumno</td>
  </tr>';
 
 // foreach($pedidodetalle->mostrarTodo("idpedido=".$cotizacion) as $m)
  foreach($examendetalle->mostrarTodo("idexamen=".$ex['idexamen']." and asignatura='grammar'") as $ed)
  { 
     $pre=$pregunta->mostrar($ed['idpregunta']);
     $pre=array_shift($pre);
   

   $html=$html.'
     <tr class="sfila">       
       <td class="det">'.$pre['detalle'].'</td>
       <td class="scenter">'.$pre['a'].'</td>
       <td class="scenter">'.$pre['b'].'</td>
       <td class="scenter">'.$pre['c'].'</td>
       <td class="scenter">'.$pre['respuesta'].'</td>
       <td class="scenter">'.$ed['respuestaest'].'</td>
     </tr>';
  }
  $html=$html.'
<tr>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
</tr>
 </table>
';

  $idref2=0;
  foreach($examendetalle->mostrarTodo("idexamen=".$ex['idexamen']." and asignatura='listening'") as $ex) //idreferencia por defecto
  {
     $idref2=$ex['referencia'];
  }
  $re=$referencia->mostrar($idref2);
  $re=array_shift($re);

  $html=$html."
<br><br>EXAMEN DE LISTENING.
<br>
Titulo del audio: ".$re['nombre'];


// Print text using writeHTMLCell()

// ---------------------------------------------------------
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
.det{
  text-align: left;
  
}
.sfila{
  padding:50px;
}
</style>

        <table border="1" width="704" cellpadding="3" cellspacing="0">
  <tr bgcolor="#f2f2f2">
    <td class="tituloCenda" width="350">
      Pregunta
    </td>
    <td class="tituloCenda" width="80">
      A
    </td>
    <td class="tituloCenda" width="80">B</td>
    <td class="tituloCenda" width="80">C</td>
    <td class="tituloCenda" width="80">Respuesta</td>
    <td class="tituloCenda" width="80">alumno</td>
  </tr>';
 
 // foreach($pedidodetalle->mostrarTodo("idpedido=".$cotizacion) as $m)


  foreach($examendetalle->mostrarTodo("idexamen=".$ex['idexamen']." and asignatura='listening'") as $ed)
  { 
     $pre=$pregunta->mostrar($ed['idpregunta']);
     $pre=array_shift($pre);
   

   $html=$html.'
     <tr class="sfila">       
       <td class="det">'.$pre['detalle'].'</td>
       <td class="scenter">'.$pre['a'].'</td>
       <td class="scenter">'.$pre['b'].'</td>
       <td class="scenter">'.$pre['c'].'</td>
       <td class="scenter">'.$pre['respuesta'].'</td>
       <td class="scenter">'.$ed['respuestaest'].'</td>
     </tr>';
  }
  $html=$html.'
<tr>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
</tr>
 </table>
';
  $idref=0;
  foreach($examendetalle->mostrarTodo("idexamen=".$ex['idexamen']." and asignatura='reading'") as $ex) //idreferencia por defecto
  {
     $idref=$ex['referencia'];
  }
  $re=$referencia->mostrar($idref);
  $re=array_shift($re);

  $html=$html."
<br><br>EXAMEN DE READING.
<br>
 <div>Titulo del texto: ".$re['nombre']."<br>".$re['descripcion']."<br></div>"

;


// Print text using writeHTMLCell()


//--------------------------------------------

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
.det{
  text-align: left;
  
}
.sfila{
  padding:50px;
}
</style>

        <table border="1" width="704" cellpadding="3" cellspacing="0">
  <tr bgcolor="#f2f2f2">
    <td class="tituloCenda" width="350">
      Pregunta
    </td>
    <td class="tituloCenda" width="80">
      A
    </td>
    <td class="tituloCenda" width="80">B</td>
    <td class="tituloCenda" width="80">C</td>
    <td class="tituloCenda" width="80">Respuesta</td>
    <td class="tituloCenda" width="80">alumno</td>
  </tr>';
 
 // foreach($pedidodetalle->mostrarTodo("idpedido=".$cotizacion) as $m)


  foreach($examendetalle->mostrarTodo("idexamen=".$ex['idexamen']." and asignatura='reading'") as $ed)
  { 
     $pre=$pregunta->mostrar($ed['idpregunta']);
     $pre=array_shift($pre);
   

   $html=$html.'
     <tr class="sfila">       
       <td class="det">'.$pre['detalle'].'</td>
       <td class="scenter">'.$pre['a'].'</td>
       <td class="scenter">'.$pre['b'].'</td>
       <td class="scenter">'.$pre['c'].'</td>
       <td class="scenter">'.$pre['respuesta'].'</td>
       <td class="scenter">'.$ed['respuestaest'].'</td>
     </tr>';
  }
  $html=$html.'
<tr>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
</tr>
 </table>
';




  $html=$html."
<br><br>EXAMEN DE READING.
<br>
";


// Print text using writeHTMLCell()

//--------------------------------------------------------
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
.det{
  text-align: left;
  
}
.sfila{
  padding:50px;
}
</style>

        <table border="1" width="704" cellpadding="3" cellspacing="0">
  <tr bgcolor="#f2f2f2">
    <td class="tituloCenda" width="350">
      Pregunta
    </td>
    <td class="tituloCenda" width="400">Respuesta del estudiante</td>
  </tr>';
 
 // foreach($pedidodetalle->mostrarTodo("idpedido=".$cotizacion) as $m)


  foreach($examendetalle->mostrarTodo("idexamen=".$ex['idexamen']." and asignatura='writing'") as $ed)
  { 
     $pre=$pregunta->mostrar($ed['idpregunta']);
     $pre=array_shift($pre);
   

   $html=$html.'
     <tr class="sfila">       
       <td class="det">'.$pre['detalle'].'</td>
       <td class="scenter" style="text-align:justify;" >'.$ed['respuestaest'].'</td>
     </tr>';
  }
  $html=$html.'
<tr>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
</tr>
 </table>
';

//-------
  $html=$html."
<br><br>NOTA.
";

// Print text using writeHTMLCell()

//-------------------------------------------


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
.det{
  text-align: left;
  
}
.sfila{
  padding:50px;
}
</style>

        <table border="1" width="704" cellpadding="3" cellspacing="0">
  <tr bgcolor="#f2f2f2">
    <td class="tituloCenda" width="80">Modulo</td>
    <td class="tituloCenda" width="40">Gr</td>
    <td class="tituloCenda" width="40">Li</td>
    <td class="tituloCenda" width="40">Re</td>
    <td class="tituloCenda" width="40">Sp</td>
    <td class="tituloCenda" width="40">Wr</td>
    <td class="tituloCenda" width="80">Promedio</td>
    <td class="tituloCenda" width="80">Estado</td>

  </tr>';
 
 // foreach($pedidodetalle->mostrarTodo("idpedido=".$cotizacion) as $m)


  foreach($examen->mostrar($ex['idexamen']) as $exam)
  { 

     $mo=$modulo->mostrar($exam['idmodulo']);
     $mo=array_shift($mo);
     if ($exam['aprobo']==1) 
     {
       $resultado='APROBADO';
     }else{
      $resultado='REPROBADO';
     }
   $html=$html.'
     <tr class="sfila">       
       <td class="scenter">'.$mo['nombre'].'</td>
       <td class="scenter">'.$exam['gr'].'</td>
       <td class="scenter">'.$exam['li'].'</td>
       <td class="scenter">'.$exam['re'].'</td>
       <td class="scenter">'.$exam['sp'].'</td>
       <td class="scenter">'.$exam['wr'].'</td>
       <td class="scenter">'.$exam['promedio'].'</td>
       <td class="scenter">'.$resultado.'</td>
     </tr>';
  }
  $html=$html.'
<tr>
  
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
  <td class="scenter">-</td>
</tr>
 </table>
';
  $html=$html."
<br><br>
";

// Print text using writeHTMLCell()
//-------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information. "D"
//echo "hola";
//echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";

 ?>
