<?php
  $ruta="../../";
   include_once($ruta."class/vestudiantefull.php");
  $vestudiantefull=new vestudiantefull;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  session_start(); 
  include_once($ruta."class/vestudiante.php");
  $vestudiante=new vestudiante;

include_once($ruta."class/licencia.php");
  $licencia=new licencia;
include_once($ruta."class/vlicencia.php");
  $vlicencia=new vlicencia;
include_once($ruta."class/vasistencia.php");
  $vasistencia=new vasistencia;
include_once($ruta."class/configuracion.php");
$configuracion=new configuracion;



  include_once($ruta."class/vestudiantecurso.php");
  $vestudiantecurso=new vestudiantecurso;




  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede']; 


extract($_GET);
$ide= dcUrl($idecod);

$ves = $vestudiante->muestra($ide);
//echo $ves["nombre"]." ".$ves["paterno"];
$dato = $vestudiantecurso->mostrarTodo("idestudiante=$ide");
$dato = array_shift($dato);

$limite = $configuracion->mostrarTodo("tipo=1");
$limite = array_shift($limite);

//echo $limite['valor'];
$datofalta=$vasistencia->mostrarTodo("idestudiante=$ide and asis=0");
$faltas=count($datofalta);

$datoasistencia=$vasistencia->mostrarTodo("idestudiante=$ide and asis=1");
$asistencias=count($datoasistencia);

$datodias=0;
foreach($lic=$vlicencia->mostrarTodo("idestudiante=$ide") as $lic)
                      {
                        $datodias=$datodias+$lic['dias']; 
                      }
if($datodias<$limite['valor'])
{
    $dias=$limite['valor']-$datodias;
    $btn="";
}
else
{    
    $dias="YA NO TIENE DIAS DISPONIBLES ";
    $btn="disabled";
}
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
          $idmenu=1025;
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
     </section>
<section>
<div class="container">           
<h1>INFORMACION</h1>
<div class="row"> 
    <div class="form-group">
      <div class="col s4 m4 l4">
           <h6 class="control-label" for="email">Estudiante:<?php echo $ves["nombre"]." ".$ves["paterno"]." ".$ves["materno"];?></h6>
      </div>
      <div class="col s4 m4 l4">
           <h6 class="control-label" for="email">Faltas:<?php echo $faltas;?></h6>
      </div>
      <div class="col s4 m4 l4"></div>
    </div>
</div>
<div class="row"> 
    <div class="form-group">
   
      <div class="col s4 m4 l4">
           <h6 class="control-label" for="email">Celular:<?php echo $ves["celular"];?></h6>
      </div>
      <div class="col s4 m4 l4">
           <h6 class="control-label" for="email">Asistencias:<?php echo $asistencias;?></h6>
      </div>
      <div class="col s4 m4 l4"></div>
    </div>
</div>
<div class="row"> 
    <div class="form-group">
      <div class="col s4 m4 l4">
           <h6 class="control-label" for="email"></h6>
      </div>
      <div class="col s4 m4 l4">
           <h6 class="control-label" for="email">Licencias disponibles:<?php echo $dias;?></h6>
      </div>
      <div class="col s4 m4 l4"></div>
    </div>
</div>
<div class="row"> 
    <div class="form-group">
      <div class="col-sm-4">
         <button href="#modal2" class="btn-jh waves-effect waves-light green modal-trigger" onclick="cargar('<?php echo $f['idestudiante'] ?>');"><i class="mdi-action-input"></i><?php echo" "?>Agregar licencia</button>
      </div>
      <div class="col-sm-4">
           
      </div>
      <div class="col-sm-4"></div>
    </div>
</div>
</div>

          

            <div class="container">
            <div class="section">
             <div class="row">
                <div id="modal2" class="modal">
                  <div class="modal-content">
                  <h1 align="center">LICENCIA</h1>
                    <form class="form-horizontal" id="idform2" action="/action_page.php">
                        <div class="container">
                        <div class="row">
                        <div class="form-group">
                            <div class="col s6 m6 l6">
                                <input type="hidden" class="form-control" name="idest" id="idest" placeholder="" value="<?php echo $ves['idvestudiante'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col s6 m6 l6">
                                <input type="hidden" class="form-control" name="idestcurso" id="idestcurso" placeholder="" value="<?php echo $dato['idvestudiantecurso'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col s12 m12 l12">
                            <?php $date=date('Y-m-d') ?>
                                Fecha:<input type="date" class="form-control" value="<?php echo $date ?>" name="fecha" id="fecha" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col s12 m12 l12"> 
                                Motivo:<textarea name="motivo" id="motivo" name="iddescripcion" class="materialize-textarea"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col s12 m12 l12"> 
                                Dias:<input type="number" maxlength="2" class="form-control" name="diassolicitud" id="diassolicitud" placeholder="Cantidad de dias">
                                <input  type="hidden"  class="control-label col-sm-8" for="pwd" name="diasdisponibles" id="diasdisponibles" value="<?php echo $dias?>">
                            </div>
                        </div>
                        </div>
                        </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardarObs();"><i class="fa fa-save"></i> GUARDAR</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
                  </div>
                </div>
             </div>
                </div> </div>
            
          <div class="container">
            <div class="section">
              <div id="table-datatables">
             <!-- <a href="../inicio" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> -->
             
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nro.licencia</th>
                        <th>Motivo</th>
                        <th>Por dias</th> 
                        <th>Fecha</th>
                        <th>Realizado por:</th>
                        <th>Creado</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                       <th>Nro.licencia</th>
                       <th>Motivo</th>
                       <th>Por dias</th> 
                       <th>Fecha</th>
                       <th>Realizado por:</th>
                       <th>Creado</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                        $i=1;
                      foreach($lic=$vlicencia->mostrarTodo("idestudiante=$ide") as $lic)
                      {
                        
                      ?>
                      <tr style="<?php echo $style ?>" >
                        <td><?php echo $i++?></td> 
                        <td><?php echo $lic['motivo'] ?></td>
                        <td><?php echo $lic['dias'] ?></td>
                        <td><?php echo $lic['fecha'] ?></td>
                        <td><?php echo $lic['nombreu']." ".$lic['paternou'] ?></td>
                        <td><?php echo $lic['fechacreacion'] ?></td>
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
          
        });
      });

 
     
     $("#btnSsaveV2").click(function(){
             
        iddocente=$("#idest").val();
        window.open("vistapordocente/?iddocente="+$("#iddocente").val(),"_blank");
         
      });
    

    
     function guardarObs()
    {
              
          //$('#btnSave').attr("disabled",true);
          var str = $( "#idform2" ).serialize();
       //  alert(str);
          $.ajax({
            url: "guardarObs.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });

    } 
     
    </script>
</body>

</html>