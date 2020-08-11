<?php
  $ruta="../../";
   include_once($ruta."class/vestudiante.php");
  $vestudiante=new vestudiante;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/estudiantereserva.php");
  $estudiantereserva=new estudiantereserva;
  include_once($ruta."class/examen.php");
  $examen=new examen;
  include_once($ruta."class/examenfinal.php");
  $examenfinal=new examenfinal;


include_once($ruta."class/estudiantereserva.php");
$estudiantereserva=new estudiantereserva;
include_once($ruta."class/modulo.php");

$modulo=new modulo;
  session_start(); 
   extract($_GET);
 $valor=dcUrl($lblcode);
 //echo $valor;
   $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede']; 
  //echo $idsede;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="LISTADO EXAMENES";
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
          $idmenu=1015;
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
          <div id="modal1" class="modal">
                    <div class="modal-content">
                      <div class="row">
                      <div class="col s12 m12 l6" >
                        <h1 align="center">VER EXAMEN SIN DESCARGAR</h1>
                      </div>
                      <div class="col s12 m12 l6" align="right">
                        <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>
                      </div>
                     </div> 
                    
                  
                      <form class="col s12" id="idform" name="idform" action="return false" onsubmit="return false" method="POST">
                        <div class="row">

                          <div id="card-alert" class="col s12 m12 l12 card green lighten-5">
                            <div class="col s12 m12 l12" >
                              <label class="light center-align green-text" style="font-size:25px;"></i>ESTUDIANTE</label>
                       <label id="estudianteIF" style="color:#24AAff; font-size:25px;"></label>
                                <br>
                          
                              <label class="light center-align green-text" style="font-size:25px;"></i>MODULO</label>
                       <label id="idmoduloes" style="color:#24AAff; font-size:25px;"></label>

<br>




                                <table border="1">
                                <caption>NOTAS C.C.T.P INGLÉS PARA TODOS S.A</caption>
                                <tr>
                                <th>GRAMMAR</th>
                                <th>LISTENING</th>
                                <th>SPEAKING</th>
                                <th>READING</th>
                                <th>WRITING</th>
                                <th>PROMEDIO</th>
                                
                                </tr>
                                <tr>
                                <td> 
                                  <input id="idgrammar" name="idgrammar" type="text">


                                </td>
                                <td>
                               
                                <input id="LISTENING" name="idgrammar" type="text">

                              </td>
                                <td>
                                
                                <input id="SPEAKING" name="idmoduloe" type="text">
                              </td>
                                <td>
                               
                                <input id="READING" name="idmoduloe" type="text">
                              </td>
                                <td>
                               
                                <input id="WRITING" name="idmoduloe" type="text">
                              </td>

                              <td>
                              <input id="PROMEDIO" name="idmoduloe" type="text">
                              </td>

                                </tr>
                                </table>

 <br>
                          
                              <label class="light center-align green-text" style="font-size:25px;"></i>DETALLE</label>




                                <table border="1">
                                <caption>DETALLE NOTAS C.C.T.P INGLÉS PARA TODOS S.A</caption>
                                <tr>
                                <th>PREGUNTA</th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>RESPUESTA</th>
                                <th>ALUMNO</th>
                            
                                            </tr>
                                <tr>
                                <td> 
                                <input id="preg1" name="preg1a1" type="text">
                                </td>
                                <td>
                                <input id="a1" name="a1" type="text">
                              </td>
                                <td>
                                <input id="b1" name="b1" type="text">
                              </td>
                                <td>
                                <input id="c1" name="c1" type="text">
                              </td>
                                <td>
                                <input id="respuesta1" name="respuesta1" type="text">
                              </td>
                              <td>
                              <input id="respuestaestudiante1" name="respuestaestudiante1" type="text">
                              </td>
                                </tr>
                                </table>
 <br>
                             <label class="light center-align green-text" style="font-size:30px;"><i class="mdi-action-highlight-remove"></i>EN DESARROLLO DISCULPE LAS MOLESTIAS</label>

                          





































                            </div>
                            <div class="col s12 m12 l12">
                            <div class="card-content green-text">
        

                            </div>
                             </div>
                          </div>
                              






























































                            
                        </div>
                      </form>
                    </div>
               <!--     <div class="modal-footer">
        </div> -->
            </div>
          <div class="container">
            <div class="section">
              <div id="table-datatables">









          <div class="container">
            <div class="section">
            <div class="row">
            <div class="col s12 m12 l2">&nbsp;</div>
            <div class="col s12 m12 l8">
              <div id="table-datatables">
              <a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> 
               

              <div class="row">
               <form id="idform" action="return false" onsubmit="return false" method="POST">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                     <th>N</th>
                      <th>Fecha Examen</th>
                      <th>Modulo</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>N</th>
                        <th>Fecha Examen</th>
                        <th>Modulo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                     <tbody> 
                                  <?php
                              $n=0;
                           //foreach (($sphistorialtest->sql("call sphistorialtest('$idestudiante' , 1)"))as $d)
                                 $consulta="SELECT * FROM estudiantereserva 
                                      where idestudiante=$valor and idtipoclase in (1,2) ORDER BY idestudiantereserva DESC";
                            foreach($estudiantereserva->sql($consulta) as $f) 
                            //foreach($estudiantereserva->mostrarTodo("idestudiante=".$idestudiante." and idtipoclase=1") as $f)                            
                           {
                                   $n = $n+1;
                                     ?>
                                      <tr>
                                        <td>
                                          <?php echo $n ?>
                                        </td>
                                        <td>
                                          <?php
                                            echo $f['fechacreacion'];
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                          switch ($f['idtipoclase']) {
                                            case '1':
                                              # code...normal
                                              $mo=$modulo->mostrar($f['idmodulo']);
                                              $mo=array_shift($mo);
                                                echo $mo['nombre'].' - '.$mo['descripcion'];
                                              break;
                                           case '2':
                                            # code...fijnal
                                                      switch ($f['idleccion']) {
                                                          case '0':
                                                              echo "FINAL LISTENING";                                                                   
                                                            break;
                                                          case '1':
                                                              echo "FINAL GRAMMAR";   
                                                                   
                                                            break;
                                                          case '2':
                                                              echo "FINAL READING";   
                                                                   
                                                          break;
                                                          case '3':
                                                              echo "FINAL WRITING";   
                                                          
                                                            break;
                                                          case '4':
                                                              echo "FINAL SPEECH";   
                                                            break; 
                                                      }
                                            break; 
                                             
                                          }

                                        
                                          ?>
                                        </td>                                         <td>
                                          <?php
                                          switch ($f['evaluado']) {
                                            case '0':
                                            echo "<font color='#006dba'>Examen Habilitado</font>";
                                            break;
                                            case '1':
                                            echo "<font color='#ef7600'>Solicite a un docente evaluar Writing y Speaking</font>";
                                            break;
                                            case '2':
                                            echo "<font color='#00879b'>Examen Completado</font>";
                                            break;
                                            case '3':
                                            echo "<font color='#b82121'>Examen Cancelado</font>";
                                            break;
                                            
                                          }
                                         
                                          ?>
                                        </td>
                                        <td>
                                         <?php

                                           switch ($f['idtipoclase']) {
                                            case '1':
                                                                 switch ($f['evaluado']) {
                                                                          case '0':
                                                                          ?>
                                                                          <button type="button" class="btn btn-success" onclick="engresar_a_examen('<?php echo $f["idestudiantereserva"] ;?>');" ><i class="fa fa-desktop"></i> Realizar TEST</button>
                                                                          <?php                                           
                                                                          break;
                                                                          case '1':
                                                                          ?>
                                                                          <button type="button" class="btn btn-warning" style="opacity:0.5;" ><i class="fa fa-clock-o"></i> En proceso...</button>
                                                                          <?php
                                                                          break;
                                                                          case '2':
                                                                          ?>
                                                                        <button type="button" class="btn btn-info" onclick="reportePDF('<?php echo $f["idestudiante"] ;?>','<?php echo $f["idestudiantereserva"] ;?>');"><i class="fa fa-file-text-o"></i> Descargar PDF</button> 


                                                                         <a href="#modal1" class="btn-jh waves-effect light-green darken-4 indigo modal-trigger" onclick="verexamen('<?php echo $f['idestudiantereserva'] ?>');"><i class="mdi-action-visibility"></i> EXAMEN POPUP</a>

                                                                       
                                                                      
                                                                          <?php


                                                                          break;
                                                                          case '3':
                                                                           ?>
                                                                          <button type="button" class="btn btn-danger" style="opacity:0.5;" ><i class="fa fa-times"></i> Test cancelado</button>
                                                                          <?php
                                                                          break;
                                                                        }
                                            
                                              break;
                                           case '2':
                                            # code...fijnal

                                                 switch ($f['idleccion']) {
                                                          case '0':
                                                                  switch ($f['evaluado']) {
                                                                      case '0':
                                                                      ?>
                                                                      <button type="button" class="btn btn-success" onclick="engresar_a_examenfinalL('<?php echo $f["idestudiantereserva"] ;?>');" ><i class="fa fa-desktop"></i>TEST FINALL</button>
                                                                      <?php                                           
                                                                      break;
                                                                      case '2':
                                                                         ?>
                                                                      <button type="button" class="btn btn-success" onclick="ver('<?php echo $f["idestudiantereserva"] ;?>');" ><i class="fa fa-desktop"></i>Ver listening</button>
                                                                      <?php                                                                          break;
                                                                    }                                                                  
                                                            break;
                                                          case '1':
                                                                      switch ($f['evaluado']) {
                                                                        case '0':
                                                                        ?>
                                                                        <button type="button" class="btn btn-success" onclick="engresar_a_examenfinalG('<?php echo $f["idestudiantereserva"] ;?>');" ><i class="fa fa-desktop"></i>TEST FINAL</button>
                                                                        <?php                                           
                                                                        break;
                                                                        case '2':
                                                                           ?>
                                                                      <button type="button" class="btn btn-success" onclick="ver('<?php echo $f["idestudiantereserva"] ;?>');" ><i class="fa fa-desktop"></i>Ver Grammar</button>
                                                                      <?php  
                                                                          break;
                                                                      }
                                                                   
                                                            break;
                                                          case '2':
                                                                     switch ($f['evaluado']) {
                                                                        case '0':
                                                                        ?>
                                                                        <button type="button" class="btn btn-success" onclick="engresar_a_examenfinalR('<?php echo $f["idestudiantereserva"] ;?>');" ><i class="fa fa-desktop"></i>TEST FINAL</button>
                                                                        <?php                                           
                                                                        break;
                                                                        case '2':
                                                                           ?>
                                                                      <button type="button" class="btn btn-success" onclick="ver('<?php echo $f["idestudiantereserva"] ;?>');" ><i class="fa fa-desktop"></i>Ver Reading</button>
                                                                      <?php  
                                                                          break;
                                                                      } 
                                                                   
                                                          break;
                                                          case '3':
                                                                switch ($f['evaluado']) {
                                                                        case '0':
                                                                        ?>
                                                                        <button type="button" class="btn btn-success" onclick="engresar_a_examenfinalW('<?php echo $f["idestudiantereserva"] ;?>');" ><i class="fa fa-desktop"></i>TEST FINAL</button>
                                                                        <?php                                           
                                                                        break;
                                                                        case '2':
                                                                           ?>
                                                                      <button type="button" class="btn btn-success" onclick="ver('<?php echo $f["idestudiantereserva"] ;?>');" ><i class="fa fa-desktop"></i>Ver Writting</button>
                                                                      <?php  
                                                                          break;
                                                                      }   
                                                          
                                                            break;
                                                          case '4':
                                                              echo "FINAL SPEECH";   
                                                            break; 
                                                      }

                                                 
                                                        
                                            break; 
                                             
                                          }

 
                                        
                                          ?>
                                          
                                        </td>
                                     
                                      </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
              </table>

              </form>
              </div>
            </div>  
           </div>
              <div class="col s12 m12 l2">&nbsp;</div>
               </div>   
            </div>
          </div> <div class="row">
                <div id="modal2" class="modal">
                  <div class="modal-content">
                  <h1 align="center">Observación</h1>
                    <form class="col s12" id="idform2" action="return false" onsubmit="return false" method="POST">
                    <input id="idestudianteSel2" name="idestudianteSel2" type="hidden">
                    <input id="idejecutivo" name="idejecutivo" type="hidden" value="<?php echo $us['idadmejecutivo'] ?>">
                    <div id="card-alert" class="col s12 m12 l12 card deep-purple lighten-5">
                          <div class="col s12 m12 l12" >
                            <label class="light center-align blue-text" style="font-size:25px;"><i class="mdi-social-person"></i>ESTUDIANTE</label>
                            </div>
                            <div class="col s12 m12 l12">
                            <div class="card-content deep-purple-text">                             
                               <p> <strong>CARNET: </strong><label id="idcarnet" style="color:#252525; font-size:15px;"></label></p>
                               <p> <strong>ESTUDIANTE: </strong><label id="idestudiantenombre" style="color:#252525; font-size:15px;"></label></p>
                                <input id="idest" type="hidden">
                            </div>
                              <div     class="row">
                             <div class="input-field col s12 m3">
                               <strong>INGRESE NOTA DE WRITING:</strong>
                            </div>
                        <div class="input-field col s9">
                          <input  id="idnota" name="idnota" class="materialize-textarea"> 
                           
                        </div>
                        </div>
                             </div>
                          </div>
                      
                    </form>
                  </div>
                  <div class="modal-footer">
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardarnota();"><i class="fa fa-save"></i> GUARDAR</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
                  </div>
                </div>
             </div>
             <div class="row">
                <div id="modal3" class="modal">
                  <div class="modal-content">
                  <h1 align="center">Observación</h1>
                    <form class="col s12" id="idform3" action="return false" onsubmit="return false" method="POST">
                    <input id="idestudianteSel3" name="idestudianteSel3" type="hidden">
                    <input id="idejecutivo" name="idejecutivo" type="hidden" value="<?php echo $us['idadmejecutivo'] ?>">
                    <div id="card-alert" class="col s12 m12 l12 card light-blue lighten-5">
                          <div class="col s12 m12 l12" >
                            <label class="light center-align blue-text" style="font-size:25px;"><i class="mdi-social-person"></i>ESTUDIANTE</label>
                            </div>
                            <div class="col s12 m12 l12">
                            <div class="card-content deep-purple-text">                             
                               <p> <strong>CARNET: </strong><label id="idcarnet3" style="color:#252525; font-size:15px;"></label></p>
                               <p> <strong>ESTUDIANTE: </strong><label id="idestudiantenombre3" style="color:#252525; font-size:15px;"></label></p>
                                <input id="idest3" type="hidden">
                            </div>
                              <div     class="row">
                             <div class="input-field col s12 m3">
                               <strong>INGRESE NOTA DE SPEECH:</strong>
                            </div>
                        <div class="input-field col s9">
                          <input  id="idnota3" name="idnota3" class="materialize-textarea"> 
                           
                        </div>
                        </div>
                             </div>
                          </div>
                      
                    </form>
                  </div>
                  <div class="modal-footer">
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardarnota3();"><i class="fa fa-save"></i> GUARDAR</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
                  </div>
                </div>
             </div>
          <?php
            include_once("../../footer.php");
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
      $('.btndel').tooltip({delay: 50});
    });















 function ver(ides)
     {
       window.open("../examen/verdatosexamen10.php?ides="+ides);

     }











      function reportePDF(ides,ider)
     {
       popup=window.open("../reporte/examenpdf.php?ides="+ides+"&ider="+ider);


     }

     function verexamen(idr)
     { 
        $('#ider').val(idr);
        $.ajax({
            async: true,
            url: "verdatosexamen.php?idres="+idr,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#idmoduloe").val(json.modulo);
                $("#estudianteIF").text(json.nombre); 
                $("#idmoduloes").text(json.modulo);
   $("#idgrammar").val(json.gra);
      $("#LISTENING").val(json.lis);
         $("#SPEAKING").val(json.spk);
            $("#READING").val(json.read);
               $("#WRITING").val(json.wri);
                 $("#PROMEDIO").val(json.pro);





              
            }
            
          });
     }  


    
     // function reportePHP(ides,ider)
    // {
     //  popup=window.open("../reporte/imprimirpantalla.php?ides="+ides+"&ider="+ider);
    // }


    </script>
</body>


</html>