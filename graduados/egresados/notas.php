<?php
  $ruta="../../";
   include_once($ruta."class/vestudiantefull.php");
  $vestudiantefull=new vestudiantefull;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/notas.php");
  $notas=new notas;
  session_start(); 

  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede']; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Lista de estudiante";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    include_once($ruta."includes/head_tablax.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1052;
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
              <div id="table-datatables">
                   <div id="modal2" class="modal">
                  <div class="modal-content">
               
                    <form class="col s12" id="idform2" action="return false" onsubmit="return false" method="POST">
                    <input id="idestudianteSel" name="idestudianteSel" type="hidden">
                    <input id="idejecutivo" name="idejecutivo" type="hidden" value="<?php echo $us['idadmejecutivo'] ?>">
                    <div id="card-alert" class="col s12 m12 l12 card deep-purple lighten-5">
                         
                            <div class="col s12 m12 l12">
                            <div class="card-content deep-purple-text">                             
                               <p> <strong>CARNET: </strong><label id="idcarnet" style="color:#252525; font-size:15px;"></label></p>
                               <p> <strong>ESTUDIANTE: </strong><label id="idestudiantenombre" style="color:#252525; font-size:15px;"></label></p>
                                <input id="idest" type="hidden">
                            </div>
                             </div>
                          </div>
                        <div    class="row">
                        <div class="input-field col s12 m3">
                               <strong>GRAMMAR:</strong>
                            </div>
                        <div class="input-field col s9">
                           <input id="idgrammar" name="idgrammar" readonly=""    type="text" >
                           
                        </div>
                         <div class="input-field col s12 m3">
                               <strong>LISTENING:</strong>
                            </div>
                        <div class="input-field col s9">
                           <input id="idlistening" name="idlistening"  readonly=""   type="text" >
                           
                        </div>
                         <div class="input-field col s12 m3">
                               <strong>SPEECH:</strong>
                            </div>
                        <div class="input-field col s9">
                           <input id="idspeech" name="idspeech"     type="text" >
                           
                        </div>
                         <div class="input-field col s12 m3">
                               <strong>READING:</strong>
                            </div>
                        <div class="input-field col s9">
                           <input id="idreading" name="idreading"  readonly=""   type="text" >
                           
                        </div>
                         <div class="input-field col s12 m3">
                               <strong>WRITING:</strong>
                            </div>
                        <div class="input-field col s9">
                           <input id="idwriting" name="idwriting"     type="text" >
                           
                        </div>
                        </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardarObs();"><i class="fa fa-save"></i> GUARDAR</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
                  </div>
                </div>
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                         <th>Estudiante</th>
                        <th>1</th>
                        <th>2</th> 
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th> 
                        <th>7</th>
                        <th>8</th> 
                        <th>9</th>
                        <th>Grammar</th>
                        <th>Listening</th> 
                        <th>Speech</th>
                        <th>Reading</th> 
                        <th>Writing</th> 
                        <th>FINAL</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Estudiante</th>
                        <th>1</th>
                        <th>2</th> 
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th> 
                        <th>7</th>
                        <th>8</th> 
                        <th>9</th>
                        <th>Grammar</th>
                        <th>Listening</th> 
                        <th>Speech</th>
                        <th>Reading</th> 
                        <th>Writing</th> 
                        <th>FINAL</th>
                        <th></th>
                          
                    </tr>
                </tfoot>
                <tbody>
          <?php
                      foreach($notas->sql('call notas(1)') as $f){
                      //foreach($vestudiantefull->mostrarTodo("idsede=".$idsede." and estado in(1,2)   and estadoacademico in             (150) ") as $f)
                      
                        $idest=ecUrl($f['idestudiante']);
                      ?>
                      
                      <tr style="<?php echo $style ?>" >
                        <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td> 
                        <td><?php echo $f['prom1'] ?></td>
                        <td><?php echo $f['prom2'] ?></td> 
                        <td><?php echo $f['prom3'] ?></td>
                        <td><?php echo $f['prom4'] ?></td>
                        <td><?php echo $f['prom5'] ?></td>

                        <td><?php echo $f['prom6'] ?></td>

                        <td><?php echo $f['prom7'] ?></td>
                        <td><?php echo $f['prom8'] ?></td>
                        <td><?php echo $f['prom9'] ?></td> 
                        <td><?php echo $f['Grammar'] ?></td> 
                        <td><?php echo $f['Listening'] ?></td> 
                        <td><?php echo $f['finalspeech'] ?></td> 
                        <td><?php echo $f['Reading'] ?></td> 
                        <td><?php echo $f['Writing'] ?></td> 
                        <td><?php echo $f['promediofinal'] ?></td> 
                        <td>  <a href="#modal2" class="btn-jh waves-effect waves-light red modal-trigger tooltipped" onclick="cargar('<?php echo $f['idestudiante'] ?>');" data-position="bottom" data-delay="50" data-tooltip="MODIFICAR NOTA"><i class="mdi-image-remove-red-eye"></i> </a></td> 
                        
                      </tr>
                      <?php
                        }
                      ?>
                    </tbody>
              </table>
              </div>
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
      include_once($ruta."includes/script_tablax.php");
    ?>
<script type="text/javascript"> 



      $(document).ready(function() {
        $('#example').DataTable({
          "bFilter": true,
          "bInfo": false,
          "bAutoWidth": false,
          responsive: true,
          dom: 'Bfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ]
        });
      });

 
      function cargar(ide)
     {
        $('#idestudianteSel').val(ide);
        $.ajax({
            async: true,
            url: "cargarestudiante.php?ide="+ide,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#idestudiantenombre").text(json.estudiante);
                $("#idcarnet").text(json.carnet);
                
                $("#idest").text(json.idperson);
               
                $("#idgrammar").val(json.grammar);
                $("#idlistening").val(json.listening);
                $("#idspeech").val(json.speech);
                $("#idreading").val(json.reading);
                $("#idwriting").val(json.writing);
               
            }
          });
     }   
     
   
      
    </script>
</body>

</html>