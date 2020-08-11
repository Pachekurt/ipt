<?php
  $ruta="../../";
  include_once($ruta."class/curso.php");
  $curso=new curso;
   include_once($ruta."class/estudiante.php");
  $estudiante=new estudiante;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/modulo.php");
  $modulo=new modulo;
   include_once($ruta."class/estudiantecurso.php");
  $estudiantecurso=new estudiantecurso;
   include_once($ruta."class/horario.php");
  $horario=new horario;
   include_once($ruta."class/vcurso.php");
  $vcurso=new vcurso;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  session_start(); 
  extract($_GET);
  $idestudiante=dcUrl($lblcode); 
  //echo $idestudiante;

  $est=$estudiante->mostrar($idestudiante);
  $est=array_shift($est);
  $per=$persona->mostrarTodo("idpersona=".$est['idpersona']);
  $per=array_shift($per);
   $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede'];

  $EC=$estudiantecurso->mostrarTodo("idestudiante=".$idestudiante." and estado=1");
  $EC=array_shift($EC);
  $vcu=$vcurso->mostrar($EC['idcurso']);
  $vcu=array_shift($vcu);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="TRASPASO";
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
          $idmenu=1012;
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
              <div class="row">
               <div class="col s12 m12 l12">
               <a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>
               </div>
                 
                   <div class="col s12 m12 l6">
                        <div id="card-alert" class="card" style="background:#00A8A2">
                          <div class="card-content white-text">
                            <p style="font-size:18px;"><strong>ESTUDIANTE</strong></p>
                             <div id="card-alert2" class="card deep-purple lighten-5">
                              <div class="card-content deep-purple-text">
                               <p><strong>NOMBRE: </strong> <?php echo $per['nombre']." ".$per['paterno']." ".$per['materno'] ?></p>
                                <p><strong>CARNET: </strong> <?php echo $per['carnet']." ".$per['expedido'] ?></p>
                              </div>
                             </div>
                          </div>
                        </div>
                   </div>
                    <div class="col s12 m12 l6">   
                   <div id="card-alert2" class="card"  style="background:#00A8A2">
                          <div class="card-content white-text">
                            <p style="font-size:18px;"><strong>CURSO ACTUAL DEL ESTUDIANTE</strong></p>
                             <div id="card-alert2" class="card deep-purple lighten-5">
                              <div class="card-content deep-purple-text">
                                  <div class="col s12 m12 l12">
                                    <input id="idestudiantecurso" name="idestudiantecurso" type="hidden" value="<?php echo $EC['idestudiantecurso'] ?>">
                                    <p> <strong>DOCENTE: </strong><?php echo $vcu['nombre']." ".$vcu['paterno']." ".$vcu['materno'] ?></p>
                                  </div>
                                  <div class="col s12 m12 l12">
                                    <p> <strong>MODULO: </strong><?php echo $vcu['modulo']." (".$vcu['mdescripcion'].")" ?></p>
                                  
                                  <p> <strong>HORARIO: </strong><?php echo $vcu['inicio']." a ".$vcu['fin'] ?></p>
                                  </div>
                                  
                              </div>
                             </div>
                          </div>
                        </div>
                  </div>
                  
              </div>
            </div>
          <div class="container">
            <div class="section">
              <div id="table-datatables">               
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Modulo</th>
                        <th>Docente</th>
                        <th>Horario</th> 
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Modulo</th>
                        <th>Docente</th>
                        <th>Horario</th> 
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      foreach($vcurso->mostrarTodo("idsede=".$idsede." and idmodulo=".$est['idmodulo']) as $f)
                      {
                        $idcurso=ecUrl($f['idvcurso']);
                        
                        $estC=$estudiantecurso->mostrarTodo("idcurso=".$f['idvcurso']." and estado =1");
                        $EC=$estudiantecurso->mostrarTodo("idestudiante=".$idestudiante." and idcurso=".$f['idvcurso']." and estado =1");
                         $EC=array_shift($EC);
                      ?>
                      <tr 
                      <?php 
                        if ($f['idvcurso']==$EC['idcurso']) {
                          ?>
                          style="background-color:#ffe6ba;color: #ff6c00" 
                           <?php 
                        }
                       ?>
                      >
                        <td><?php echo $f['modulo']." (".$f['mdescripcion'].")" ?></td>
                        <td><?php echo $f['nombre']." ".$f['paterno'] ?></td>
                        <td><?php echo $f['inicio'].' a '.$f['fin'] ?></td>
                         
                        <td style="font-size:17px; color:green;"><strong><?php echo count($estC) ?></strong> </td>
                        <td>
                        <button class="btn-jh waves-effect waves-light red darken-4" onclick="traspasar('<?php echo $f['idvcurso'] ?>');"><i class="mdi-av-my-library-books"></i> Traspasar</button>
                         <button class="btn-jh waves-effect waves-light light-blue darken-4" onclick="ver('<?php echo $idcurso ?>');"><i class="mdi-av-my-library-books"></i> Ver Curso</button>
                        </td>
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
    ?>
    <script type="text/javascript">   
     function ver(idc)
     {
        popup=window.open("../asignar/ver.php?idcurso="+idc,"neo","width=800,height=600,enumerar=si;");
        popup.focus();
     }

     function traspasar(idc)
    {
      swal({
                  title: "¿Esta seguro?",
                  text: "Realizar el traspaso del curso seleccionado?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#28e29e",
                  confirmButtonText: "OK",
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true,
              }, function () {      
                           var idest='<?php echo $idestudiante ?>';
                           var idec=document.getElementById('idestudiantecurso').value;
                                //alert(idest+' '+idcur);     
                              $.ajax({
                                url: "guardar.php",
                                type: "POST",
                                data: "idcursoSel="+idc+"&idestudiante="+idest+"&idestudiantecurso="+idec,
                                success: function(resp){
                                 console.log(resp);
                                  $('#idresultado').html(resp);
                                 
                                }
                              });
              }); 
     
        
    }

    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
      $('.btndel').tooltip({delay: 50});
    }); 


    </script>
</body>

</html>