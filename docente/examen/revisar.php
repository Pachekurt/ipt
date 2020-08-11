<?php
  $ruta="../../";
   include_once($ruta."class/estudiante.php");
  $estudiante=new estudiante;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/estudiantereserva.php");
  $estudiantereserva=new estudiantereserva;
  include_once($ruta."class/vestudiante.php");
  $vestudiante=new vestudiante;
  include_once($ruta."class/examen.php");
  $examen=new examen;
  include_once($ruta."class/examendetalle.php");
  $examendetalle=new examendetalle;
  include_once($ruta."class/pregunta.php");
  $pregunta=new pregunta;
  include_once($ruta."class/referencia.php");
  $referencia=new referencia;
  include_once($ruta."class/configuracion.php");
  $configuracion=new configuracion;
  session_start(); 
  extract($_GET);
  $idestudiantereserva=dcUrl($ider);

  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede']; 
  $idejecutivo=$us['idadmejecutivo'];

  $er=$estudiantereserva->mostrar($idestudiantereserva);
  $er=array_shift($er);

  $est=$vestudiante->mostrar($er['idestudiante']);
  $est=array_shift($est);

  $dUExamen=$examen->mostrarTodo("idestudiante=".$er['idestudiante']." and idestudiantereserva=".$idestudiantereserva);
  $dUExamen=array_shift($dUExamen);
  $uGR=$dUExamen['gr'];
  //echo $uGR;
  $uLI=$dUExamen['li'];
  $uSP=$dUExamen['sp'];
  $uRE=$dUExamen['re'];
  $uWR=$dUExamen['wr'];
 
  /******** parametros de evaluacion *******/
$dGramar=$configuracion->mostrar(1);
$dGramar=array_shift($dGramar);

$dListening=$configuracion->mostrar(2);
$dListening=array_shift($dListening);

$dSpeaking=$configuracion->mostrar(3);
$dSpeaking=array_shift($dSpeaking);

$dReading=$configuracion->mostrar(4);
$dReading=array_shift($dReading);

$dWriting=$configuracion->mostrar(5);
$dWriting=array_shift($dWriting);

$promediominimo=$configuracion->mostrar(7);
$promediominimo=array_shift($promediominimo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Revisar examen del estudiante";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1014;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
              </div>
            </div>
          </div>
          
          
          <div class="container">
            <div class="section">
                <div class="row">
                 <form class="col s12" id="idform" name="idform" action="return false" onsubmit="return false" method="POST">
                 <input type="hidden" id="idexamen" name="idexamen"  value="<?php echo $dUExamen['idexamen']; ?>" />
                    <input type="hidden" id="idestudiante" name="idestudiante"  value="<?php echo $er['idestudiante']; ?>" />
                    <input type="hidden" id="idestudiantereserva" name="idestudiantereserva"  value="<?php echo $idestudiantereserva; ?>" />
                  <div class="col s12 m12 12">
                  
                    <ul id="issues-collection" class="collection ">
                                    <li class="collection-item avatar card green lighten-5 green-text">
                                        <i class="mdi-action-account-box green circle"></i>

                                        <span class="collection-header">Estudiante: <strong><?php echo $est['nombre'].' '.$est['paterno'].' '.$est['materno']; ?></strong></span>
                                        <p>Carnet: <strong><?php echo $est['carnet'].' '.$est['expedido']; ?></strong> </p>
                                        <a href="#" class="secondary-content"><i class="mdi-action-grade"></i></a>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s3 valGramar"> 
                                            <strong>GRAMMAR:</strong>                                                                   
                                            </div>
                                            <div class="col s1"> 
                                            <span class="task-cat orange accent-6">Pts</span>                                                                    
                                            </div>
                                            <div class="col s2">
                                                
                                                <div class="input-field">
                                                  <input id="idgramar" name="gr" value="<?php echo $uGR ?>" type="number" readonly class="validate">
                                                  <label for="idgramar"></label>
                                                </div>
                                            </div>
                                            <div class="col s4">
                                                <div class="progress">
                                                     <div class="determinate" style="width: <?php echo $uGR ?>%"></div>   
                                                </div>                                                
                                            </div>
                                            <div class="col s2">
                                            <a href="#modal1" class="btn-jh waves-effect waves-light green indigo modal-trigger"><i class="mdi-hardware-desktop-mac"></i> Revisar....</a>                                                
                                           
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s3 valListening"> 
                                            <strong>LISTENING:</strong>                                                                   
                                            </div>
                                            <div class="col s1"> 
                                            <span class="task-cat blue accent-6">Pts</span>                                                                    
                                            </div>
                                            <div class="col s2">
                                                
                                                <div class="input-field">
                                                  <input id="idlistening" name="li" value="<?php echo $uLI ?>" readonly type="number" class="validate">
                                                  <label for="idlistening"></label>
                                                </div>
                                            </div>
                                            <div class="col s4">
                                                <div class="progress">
                                                     <div class="determinate" style="width: <?php echo $uLI ?>%"></div>   
                                                </div>                                                
                                            </div>
                                            <div class="col s2">
                                             <a href="#modal2" class="btn-jh waves-effect waves-light green indigo modal-trigger"><i class="mdi-hardware-desktop-mac"></i> Revisar....</a>
                                               
                                               <button class="btn-jh waves-effect waves-light red" onclick="recetearaudio();"><i class="mdi-navigation-refresh"></i> Restablecer audio</button>                                                  
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s3 valReading"> 
                                            <strong>READING:</strong>                                                                   
                                            </div>
                                            <div class="col s1"> 
                                            <span class="task-cat green accent-6">Pts</span>                                                                    
                                            </div>
                                            <div class="col s2">
                                                
                                                <div class="input-field">
                                                  <input id="idreading" name="re" value="<?php echo $uRE ?>" readonly type="number" class="validate">
                                                  <label for="idreading"></label>
                                                </div>
                                            </div>
                                            <div class="col s4">
                                                <div class="progress">
                                                     <div class="determinate" style="width: <?php echo $uRE ?>%"></div>   
                                                </div>                                                
                                            </div>
                                            <div class="col s2">
                                               <a href="#modal3" class="btn-jh waves-effect waves-light green indigo modal-trigger"><i class="mdi-hardware-desktop-mac"></i> Revisar....</a>                                                 
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s3 valSpeaking"> 
                                            <strong>SPEAKING:</strong>                                                                   
                                            </div>
                                            <div class="col s1"> 
                                            <span class="task-cat teal darken-4">Pts</span>                                                                    
                                            </div>
                                            <div class="col s2">                                                
                                                <div class="input-field">
                                                  <input id="idspeaking" name="sp" value="<?php echo $uSP ?>" type="number" class="validate" value="0">
                                                  <label for="idspeaking"></label>
                                                </div>
                                            </div>
                                            <div class="col s4">
                                                <div class="progress">
                                                     <div class="determinate pocentajeSPK" style="width: <?php echo $uSP ?>%"></div>   
                                                </div>                                                
                                            </div>
                                            <div class="col s2">
                                               &nbsp;                            
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row">
                                            <div class="col s3 valWriting"> 
                                            <strong>WRITING:</strong>                                                                   
                                            </div>
                                            <div class="col s1"> 
                                            <span class="task-cat pink accent-6">Pts</span>                                                                    
                                            </div>
                                            <div class="col s2">                                                
                                                <div class="input-field">
                                                  <input id="idwriting" name="wr" value="<?php echo $uWR ?>" type="number" class="validate" value="0">
                                                  <label for="idwriting"></label>
                                                </div>
                                            </div>
                                            <div class="col s4">
                                                <div class="progress">
                                                     <div class="determinate  pocentajeWRT" style="width: <?php echo $uWR ?>%"></div>   
                                                </div>                                                
                                            </div>
                                            <div class="col s2">
                                                <a href="#modal5" class="btn-jh waves-effect waves-light green indigo modal-trigger"><i class="mdi-hardware-desktop-mac"></i> Revisar....</a>                                                
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                
                </div>
                <div class="col s12 m12 12">
                    <ul id="issues-collection" class="collection ">
                         <li class="collection-item">
                            <div class="row" id="repro">
                                       <div class="col s2" align="right"> 
                                            <strong>ESTADO:</strong>                                                                   
                                        </div>
                                      <div class="col s4">
                                                <div class="input-field">
                                                  <input id="idestado" name="estado" style="font-size:20px;" style="font-size:20px;" readonly type="text" class="validate">
                                                  <label for="idreading"></label>
                                                </div>                                           
                                        </div>
                                         <div class="col s2" align="right"> 
                                            <strong>PROMEDIO:</strong>                                                                   
                                            </div>
                                        <div class="col s4">
                                              <div class="input-field">
                                                <input id="idpromedio" name="promedio" readonly type="number" class="validate" style="font-size:25px; font-weight: bold;">
                                                <label for="idpromedio"></label>
                                              </div>                                            
                                        </div>
                               
                                      <?php 
                                          if ($er['evaluado']==1)
                                          {
                                            ?>
                                               <div class="col s12" align="right"><button id="btnClean" class="btn waves-effect waves-light red"><i class="mdi-content-backspace"></i> Limpiar</button> 
                                                <button id="btnSave" class="btn waves-effect waves-light teal" onclick="habilitarexamen('<?php echo $f['idvestudiante'] ?>');"><i class="mdi-content-save"></i> Guardar</button> 
                                              </div>
                                            <?php
                                          }else{
                                             ?>
                                               <div class="col s12" align="right"><button  class="btn waves-effect waves-light red" style="opacity:0.5"><i class="mdi-content-backspace"></i> Limpiar</button> 
                                                <button  class="btn waves-effect waves-light teal" style="opacity:0.5"><i class="mdi-content-save"></i> Guardar</button> 
                                               </div>
                                            <?php
                                          }
                                      ?>
                                                                                  
                                
                            </div>
                          </li>
                     </ul>
                </div>

                </form> 
             </div>
            </div> 
          </div> 
          
          <div id="modal1" class="modal" style="width:90%;">
                    <div class="modal-content">                        
                           <div class="row">
                           <div id="card-alert" class="col s12 m12 l12 card green lighten-5">
                              <table id="example" class="display" cellspacing="0" width="100%">
                                <div class="col s12 m12 l6" >
                                  <h5>GRAMMAR</h5>
                                </div>
                                <div class="col s12 m12 l6" align="right">
                                  <button class="btn-jh waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>
                                </div>
                              <thead>
                                  <tr>
                                     <th>Nro</th>
                                      <th>Pregunta</th>
                                      <th>A</th>
                                      <th>B</th>
                                      <th>C</th>
                                      <th>Respuesta</th>
                                      <th>Alumno</th>
                                  </tr>
                              </thead>
                              <tfoot>
                                  <tr>
                                       <th>Nro</th>
                                      <th>Pregunta</th>
                                      <th>A</th>
                                      <th>B</th>
                                      <th>C</th>
                                      <th>Respuesta</th>
                                      <th>Alumno</th>
                                  </tr>
                              </tfoot>
                              <tbody>
                                   <?php
                                    foreach($examendetalle->mostrarTodo("idexamen=".$dUExamen['idexamen']." and asignatura='grammar'") as $ed)
                                    {

                                        $pre=$pregunta->mostrar($ed['idpregunta']);
                                        $pre=array_shift($pre);
                                    ?>
                                      <tr>
                                      <td>
                                          <?php
                                            echo $ed['idpregunta'];
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                            echo $pre['detalle'];
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                            echo $pre['a'];
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                            echo $pre['b'];
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                            echo $pre['c'];
                                          ?>
                                        </td>
                                        <td>
                                        <?php                                         
                                           echo $pre['respuesta'];
                                        ?>
                                        </td>

                                         <?php
                                            if ($pre['respuesta']==$ed['respuestaest']) 
                                            {
                                              ?>
                                                  <td style="background-color:#c8e6c9; color:green;">
                                                   <?php                                         
                                                     echo $ed['respuestaest'];
                                                   ?>
                                                  </td>
                                              <?php
                                            }else{
                                               ?>
                                                  <td style="background-color:#ffebee; color:red;">
                                                   <?php                                         
                                                     echo $ed['respuestaest'];
                                                   ?>
                                                  </td>
                                              <?php

                                            }
                                          ?>
                                        

                                        
                                      </tr>
                                    <?php
                                    }
                                    ?>
                                  </tbody>
                            </table>
                            </div>
                            </div>
                            
                     
                    </div>
               <!--     <div class="modal-footer">
                                    
                    </div> -->
            </div>
            <div id="modal2" class="modal" style="width:90%;">
                    <div class="modal-content">                        
                           <div class="row">
                           <div id="card-alert" class="col s12 m12 l12 card green lighten-5">
                              <table id="example2" class="display" cellspacing="0" width="100%">
                                <div class="col s12 m12 l6" >
                                <?php
                       
                                  foreach($examendetalle->mostrarTodo("idexamen=".$dUExamen['idexamen']." and asignatura='listening'") as $ex) //idreferencia por defecto
                                  {
                                     $idref=$ex['referencia'];
                                  }
                                  $re=$referencia->mostrar($idref);
                                  $re=array_shift($re);
                                  ?>
                                  <h5>LISTENING - Titulo del audio: <?php echo $re['nombre']; ?></h5>
                                </div>
                                <div class="col s12 m12 l6" align="right">
                                  <button class="btn-jh waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>
                                </div>
                                 
                              <thead>
                                  <tr>
                                     <th>Nro</th>
                                      <th>Pregunta</th>
                                      <th>A</th>
                                      <th>B</th>
                                      <th>C</th>
                                      <th>Respuesta</th>
                                      <th>Alumno</th>
                                  </tr>
                              </thead>
                              <tfoot>
                                  <tr>
                                       <th>Nro</th>
                                      <th>Pregunta</th>
                                      <th>A</th>
                                      <th>B</th>
                                      <th>C</th>
                                      <th>Respuesta</th>
                                      <th>Alumno</th>
                                  </tr>
                              </tfoot>
                              <tbody>
                                   <?php
                                    foreach($examendetalle->mostrarTodo("idexamen=".$dUExamen['idexamen']." and asignatura='listening'") as $ed)
                                    {

                                        $pre=$pregunta->mostrar($ed['idpregunta']);
                                        $pre=array_shift($pre);
                                    ?>
                                      <tr>
                                      <td>
                                          <?php
                                            echo $ed['idpregunta'];
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                            echo $pre['detalle'];
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                            echo $pre['a'];
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                            echo $pre['b'];
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                            echo $pre['c'];
                                          ?>
                                        </td>
                                        <td>
                                        <?php                                         
                                           echo $pre['respuesta'];
                                        ?>
                                        </td>

                                         <?php
                                            if ($pre['respuesta']==$ed['respuestaest']) 
                                            {
                                              ?>
                                                  <td style="background-color:#c8e6c9; color:green;">
                                                   <?php                                         
                                                     echo $ed['respuestaest'];
                                                   ?>
                                                  </td>
                                              <?php
                                            }else{
                                               ?>
                                                  <td style="background-color:#ffebee; color:red;">
                                                   <?php                                         
                                                     echo $ed['respuestaest'];
                                                   ?>
                                                  </td>
                                              <?php

                                            }
                                          ?>
                                        

                                        
                                      </tr>
                                    <?php
                                    }
                                    ?>
                                  </tbody>
                            </table>
                            </div>
                            </div>
                            
                     
                    </div>
               <!--     <div class="modal-footer">
                                    
                    </div> -->
            </div>
            <div id="modal3" class="modal" style="width:90%;">
                    <div class="modal-content">                        
                           <div class="row">
                           <div id="card-alert" class="col s12 m12 l12 card green lighten-5">
                              <table id="example3" class="display" cellspacing="0" width="100%">
                                <div class="col s12 m12 l6" >
                                <?php
                       
                                  foreach($examendetalle->mostrarTodo("idexamen=".$dUExamen['idexamen']." and asignatura='reading'") as $ex) //idreferencia por defecto
                                  {
                                     $idref=$ex['referencia'];
                                  }
                                  $re=$referencia->mostrar($idref);
                                  $re=array_shift($re);
                                  ?>
                                  <h5>READING - Titulo del audio: <?php echo $re['nombre']; ?></h5>
                                  
                                </div>                                
                                <div class="col s12 m12 l6" align="right">
                                  <button class="btn-jh waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>
                                </div>
                                <div class="col s12 m12 l12" >
                                <h6 style="text-align:justify;"><strong>TEXTO: </strong><?php echo $re['descripcion']; ?> </h6>
                                </div>
                                 
                              <thead>
                                  <tr>
                                     <th>Nro</th>
                                      <th>Pregunta</th>
                                      <th>A</th>
                                      <th>B</th>
                                      <th>C</th>
                                      <th>Respuesta</th>
                                      <th>Alumno</th>
                                  </tr>
                              </thead>
                              <tfoot>
                                  <tr>
                                       <th>Nro</th>
                                      <th>Pregunta</th>
                                      <th>A</th>
                                      <th>B</th>
                                      <th>C</th>
                                      <th>Respuesta</th>
                                      <th>Alumno</th>
                                  </tr>
                              </tfoot>
                              <tbody>
                                   <?php
                                    foreach($examendetalle->mostrarTodo("idexamen=".$dUExamen['idexamen']." and asignatura='reading'") as $ed)
                                    {

                                        $pre=$pregunta->mostrar($ed['idpregunta']);
                                        $pre=array_shift($pre);
                                    ?>
                                      <tr>
                                      <td>
                                          <?php
                                            echo $ed['idpregunta'];
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                            echo $pre['detalle'];
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                            echo $pre['a'];
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                            echo $pre['b'];
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                            echo $pre['c'];
                                          ?>
                                        </td>
                                        <td>
                                        <?php                                         
                                           echo $pre['respuesta'];
                                        ?>
                                        </td>

                                         <?php
                                            if ($pre['respuesta']==$ed['respuestaest']) 
                                            {
                                              ?>
                                                  <td style="background-color:#c8e6c9; color:green;">
                                                   <?php                                         
                                                     echo $ed['respuestaest'];
                                                   ?>
                                                  </td>
                                              <?php
                                            }else{
                                               ?>
                                                  <td style="background-color:#ffebee; color:red;">
                                                   <?php                                         
                                                     echo $ed['respuestaest'];
                                                   ?>
                                                  </td>
                                              <?php

                                            }
                                          ?>
                                        

                                        
                                      </tr>
                                    <?php
                                    }
                                    ?>
                                  </tbody>
                            </table>
                            </div>
                            </div>
                            
                     
                    </div>
               <!--     <div class="modal-footer">
                                    
                    </div> -->
            </div>

            <div id="modal5" class="modal" style="width:70%;">
                    <div class="modal-content">                        
                           <div class="row">
                           <div id="card-alert" class="col s12 m12 l12 card green lighten-5">
                            <div class="col s12 m12 l6" >
                                  <h5>WRITING</h5>
                                </div>
                                <div class="col s12 m12 l6" align="right">
                                  <button class="btn-jh waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>
                                </div>
                                <?php 

                                    $examDet=$examendetalle->mostrarTodo("idexamen=".$dUExamen['idexamen']." and asignatura='writing'");
                                    $examDet=array_shift($examDet);
                                   ?>
                               <div class="col s12 m12 l12" style="color:#212121;">
                                  <label style="font-size:18px; color:#212121;"><strong>Texto del estudante:</strong> </label>
                                </div>
                                <div class="col s12 m12 l12" style="color:#212121;">
                                   <label style="font-size:18px; color:#212121; text-align:justify;"><?php echo $examDet['respuestaest'] ?></label>
                                </div>
                            </div>
                            
                            </div>
                            
                     
                    </div>
               <!--     <div class="modal-footer">
                                    
                    </div> -->
            </div>
          <?php
            //include_once("../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
<script type="text/javascript"> 
     
    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
       $('#example2').DataTable({
        responsive: true
      });
        $('#example3').DataTable({
        responsive: true
      });
      $('.btndel').tooltip({delay: 50});
    }); 
    
 </script> 
 <script type="text/javascript"> 
      function cargarclase(idcurso)
      {
        //alert(idcurso);
         $.ajax({
            url: "generarasistencia.php",
            type: "POST",
            data: "idcurso="+idcurso,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
      }

function recetearaudio()
{
  var IDexamen="<?php echo $dUExamen['idexamen'] ?>";
  swal({
        title: "Estas Seguro?",
        text: "Restablecer el listening",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Estoy Seguro!",
        closeOnConfirm: false
    }, function () {
                       $.ajax({
                          url: "recetearaudio.php",
                          type: "POST",
                          data: "idexamen="+IDexamen,
                          success: function(resp){
                            if (resp==1) 
                            {
                              swal({
                                    title: "Se restablecio el listening",
                                    text: "Pedir al estudiante actualizar la pagina para proceguir con listening",
                                    type: "success"
                                });
                            }
                            if (resp==2) 
                            {
                                   swal({
                                        title: "Error",
                                        text: "no se pudo realizar la acción, consultar con sistemas",
                                        type: "warning"
                                    });
                            }
                            if (resp==3) 
                            {
                                   swal({
                                        title: "Señal baja de internet",
                                        text: "Intente de nuevo",
                                        type: "warning"
                                    });
                            }
                          }
                        });

    });
                    
}

  $("#btnSave").click(function(){
          swal({
              title: "Estas Seguro?",
              text: "Si Guardas el resultado no podras modificarlos!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Si, Estoy Seguro !",
              closeOnConfirm: false
          }, function () {
            var str = $( "#idform" ).serialize();
            //alert(str);
            $.ajax({
              url: "guardarCalificacion.php",
              type: "POST",
              data: str,
              success: function(resp){
                $( "#idresultado" ).html(resp);
                if (resp==1) 
                {
                     swal({
                          title: "EXITO",
                          text: "Calificación realizada correctamente",
                          type: "success",
                          //showCancelButton: true,
                          confirmButtonColor: "#DD6B55",
                          confirmButtonText: "OK",
                          closeOnConfirm: false
                      }, function () {                                       
                               location.href = "index.php";
                      });
         
                }
                if (resp==2) 
                {
                      swal({
                          title: "ERROR",
                          text: "No se registro, consultar con de sistemas",
                          type: "error",
                          //showCancelButton: true,
                          confirmButtonColor: "#DD6B55",
                          confirmButtonText: "OK",
                          closeOnConfirm: false
                      }, function () {                                       
                                location.reload();
                      });
                }
              }
            });

          });

  });
  $("#btnClean").click(function(){
    //$("#idgramar").val("0");
    //$("#idlistening").val("0");
    $("#idspeaking").val("0");
    //$("#idreading").val("0");
    $("#idwriting").val("0");
    eveluar();
  });

  $("#idgramar").blur(function(){
    var notaGramar="<?php echo $dGramar['valor'] ?>";
    if (parseFloat($("#idgramar").val())>=parseFloat(notaGramar)) {
      $(".valGramar").css("color", "#167511");
    }
    else{
      $(".valGramar").css("color", "#F00");
    }
    eveluar();
  });

  $("#idlistening").blur(function(){
    var nota="<?php echo $dListening['valor'] ?>";
    if (parseFloat($("#idlistening").val())>=parseFloat(nota)) {
      $(".valListening").css("color", "#167511");
    }
    else{
      $(".valListening").css("color", "#F00");
    }

    eveluar();
  });
  $("#idspeaking").blur(function(){
    var nota="<?php echo $dSpeaking['valor'] ?>";
    if (parseFloat($("#idspeaking").val())>=parseFloat(nota)) {
      $(".valSpeaking").css("color", "#167511");
    }
    else{
      $(".valSpeaking").css("color", "#F00");      
    }

    eveluar();
  });
  $("#idreading").blur(function(){
    var nota="<?php echo $dReading['valor'] ?>";
    if (parseFloat($("#idreading").val())>=parseFloat(nota)) {
      $(".valReading").css("color", "#167511");
    }
    else{
      $(".valReading").css("color", "#F00");
    }

    eveluar();
  });
  $("#idwriting").blur(function(){
    var nota="<?php echo $dWriting['valor'] ?>";
    if (parseFloat($("#idwriting").val())>=parseFloat(nota)) {
      $(".valWriting").css("color", "#167511");
    }
    else{
      $(".valWriting").css("color", "#F00");
    }

    eveluar();
  });
  
  eveluar();

  function eveluar(){
    var ntgr = $("#idgramar").val();
    if (!validaNum(ntgr)) {
      ntgr=0;
      $("#idgramar").val("0");
      $("#idgramar").css("color", "#F00");
    }
    else{
      $("#idgramar").css("color", "#000");
    }
    if (ntgr=='') {
      ntgr=0;
    }

    var ntli = $("#idlistening").val();
    if (!validaNum(ntli)) {
      ntli=0;
      $("#idlistening").val("0");
      $("#idlistening").css("color", "#F00");
    }
    else{
      $("#idlistening").css("color", "#000");
    }
    if (ntli=='') {
      ntli=0;
    }

    var ntsp = $("#idspeaking").val();
    if (!validaNum(ntsp)) {
      ntsp=0;
      $("#idspeaking").val("0");
      $("#idspeaking").css("color", "#F00");
      $(".pocentajeSPK").css("width", ntsp+"%");
    }
    else{
      $("#idspeaking").css("color", "#000");
      $(".pocentajeSPK").css("width", ntsp+"%");
    }
    if (ntsp=='') {
      ntsp=0;
    }

    var ntre = $("#idreading").val();
    if (!validaNum(ntre)) {
      ntre=0;
      $("#idreading").val("0");
      $("#idreading").css("color", "#F00");
    }
    else{
      $("#idreading").css("color", "#000");
    }
    if (ntre=='') {
      ntre=0;
    }


    var ntwr = $("#idwriting").val();
    if (!validaNum(ntwr)) {
      ntwr=0;
      $("#idwriting").val("0");
      $("#idwriting").css("color", "#F00");
      $(".pocentajeWRT").css("width", ntwr+"%");
    }
    else{
      $("#idwriting").css("color", "#000");
      $(".pocentajeWRT").css("width", ntwr+"%");
    }
    if (ntwr=='') {
      ntwr=0;
    }

    var flag=true;
    /******* evaluamos que toda las lecciones esten aprobadas********/
   
   /*
    var notaGR="<?php echo $dGramar['valor'] ?>";
    if (parseFloat(notaGR)>parseFloat(ntgr)) {
      flag=false;
    }
    var notaLI="<?php echo $dListening['valor'] ?>";
    if (parseFloat(notaLI)>parseFloat(ntli)) {
      flag=false;
    }
    var notaSP="<?php echo $dSpeaking['valor'] ?>";
    if (parseFloat(notaSP)>parseFloat(ntsp)) {
      flag=false;
    }
    var notaRE="<?php echo $dReading['valor'] ?>";
    if (parseFloat(notaRE)>parseFloat(ntre)) {
      flag=false;
    }
    var notaWR="<?php echo $dWriting['valor'] ?>";
    if (parseFloat(notaWR)>parseFloat(ntwr)) {
      flag=false;
    }


*/

    var promedio=(parseFloat(ntgr)+parseFloat(ntli)+parseFloat(ntsp)+parseFloat(ntre)+parseFloat(ntwr))/5;
    $("#idpromedio").val(promedio);


var minimo ="<?php echo $promediominimo['valor'] ?>";
    if (promedio<minimo) {flag=false;}

    if (flag) {
      $("#idestado").val("APROBADO");
      $("#idestado").css("color", "#028005");
      $("#repro").css("background-color", "#c8e6c9");
      $("#idpromedio").css("color", "#028005");
    }
    else{
      $("#idestado").val("REPROBADO");
      $("#idestado").css("color", "#F00");
      $("#repro").css("background-color", "#ffcdd2");
      $("#idpromedio").css("color", "#F00");
    }

  }
  function validaNum(num){
    sw=true;
    if (num<0) {
      swal({ title: "Error!",   
                         text: "El numero no es válido. Ingrese numero un mayor a 0",
                         type: "error",   
                         timer: 3000,   
                         showConfirmButton: false 
                    }); 
      sw=false;
    }
    if (num>100) {
                  swal({ title: "Error!",   
                         text: "El numero no es válido. Ingrese un numero menor o igual a 100", 
                         type: "error",   
                         timer: 3000,   
                         showConfirmButton: false 
                    });
     sw=false;
    }
    if (isNaN(num)) {
       swal({ title: "Error!",   
                         text: "El numero no es válido. Ingrese un Numero correcto",  
                         type: "error", 
                         timer: 3000,   
                         showConfirmButton: false 
                    }); 
      sw=false;
    }
    if (num=='') {
       swal({ title: "Error!",   
                         text: "NO dejar vacio, ingrese una nota",  
                         type: "error", 
                         timer: 3000,   
                         showConfirmButton: false 
                    }); 
      sw=false;
    }
    return sw;
  }
         $(document).ready(function () {
     //var ntgr = '<?php echo $uGR ?>';
                 var notaGramar="<?php echo $dGramar['valor'] ?>";
                if (parseFloat($("#idgramar").val())>=parseFloat(notaGramar)) {
                  $(".valGramar").css("color", "#167511");
                }
                else{
                  $(".valGramar").css("color", "#F00");
                }

                var nota="<?php echo $dListening['valor'] ?>";
                if (parseFloat($("#idlistening").val())>=parseFloat(nota)) {
                  $(".valListening").css("color", "#167511");
                }
                else{
                  $(".valListening").css("color", "#F00");
                }
             var nota="<?php echo $dReading['valor'] ?>";
                if (parseFloat($("#idreading").val())>=parseFloat(nota)) {
                  $(".valReading").css("color", "#167511");
                }
                else{
                  $(".valReading").css("color", "#F00");
                }

            });
    </script>
</body>

</html>