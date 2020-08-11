<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/modulo.php");
  $modulo=new modulo;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/horario.php");
  $horario=new horario;
  include_once($ruta."class/estudiantecurso.php");
  $estudiantecurso=new estudiantecurso;
  
  include_once($ruta."class/vcurso.php");
  $vcurso=new vcurso;

  session_start();
  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $ID_sede=$us['idsede'];

extract($_GET);
$idmod=$idmodulo;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Administrar Curso";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
 <style type="text/css">   
.btn, .btn-large {
  background-color: #2196F3;
}

button:focus {
   outline: none;
   background-color: #2196F3;
}

.btn:hover, .btn-large:hover {
   background-color: #64b5f6;
}
</style>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1028;
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
             <!-- <a href="../inicio" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> -->
              <h1><?php echo "MODULO: ",$idmod; ?></h1>
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Docente</th>
                        <th>Horario</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Inscritos</th>
                        <th>VER</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Docente</th>
                        <th>Horario</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Inscritos</th>
                        <th>VER</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      foreach($vcurso->mostrarTodo("idmodulo=$idmod") as $f)
                      {
                        $idcurso=ecUrl($f['idvcurso']);
                        $estC=$estudiantecurso->mostrarTodo("idcurso=".$f['idvcurso']." and estado =1");
                      ?>
                      <tr>
                        <td><?php echo $f['nombre']." ".$f['paterno'] ?></td>
                        <td><?php echo $f['inicio'].' a '.$f['fin'] ?></td>
                        <td><?php echo $f['fechainicio'] ?></td>
                        <td><?php echo $f['fechafin'] ?></td>
                        <td style="font-size:17px; color:green;"><strong><?php echo count($estC) ?></strong> </td>
                        <td><button class="btn-jh waves-effect waves-light light-blue darken-4" onclick="ver('<?php echo $idcurso ?>');"><i class="mdi-av-my-library-books"></i> Ver Curso</button></td>                      </tr>
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
            include_once("../../../footer.php");
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
      $("#btnSave").click(function(){        
        if (validar()) 
        {               
          var str = $( "#idform" ).serialize();
         // alert(str);
          $.ajax({
            url: "guardar.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
        }
        else{
          Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
        }
      });

      function ver(idc)
     {
        popup=window.open("../../asignar/ver.php?idcurso="+idc,"neo","width=800,height=600,enumerar=si;");
        popup.focus();
     }
      function validar(){
        retorno=true;
        mod=$('#idmodulo').val();
        doc=$('#iddocente').val();
        fechai=$('#idfechaini').val();
        fechaf=$('#idfechafin').val();
        horai=$('#idhoraini').val();
        horaf=$('#idhorafin').val();
        if(mod=="0" || doc=="0" || fechai=="" || fechaf=="" || horai=="" || horaf==""){
          retorno=false;
        }
        return retorno;
      }
      function Eliminar(id){
        swal({
          title: "Estas Seguro?",
          text: "Se Finalizara el curso",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {      
          $.ajax({
            url: "eliminar.php",
            type: "POST",
            data: "id="+id,
            success: function(resp){
              $("#idresultado").html(resp);
            }   
          });
        }); 
      }

      function anyThing() {
        setTimeout(function(){ $('.stepper').nextStep(); }, 1500);
      }

      $(function(){
         $('.stepper').activateStepper();
      });




   $(document).ready(function(){
      $('.toc-wrapper').pushpin({ top: $('.toc-wrapper').offset().top, offset: 77 });
      $('.scrollspy').scrollSpy();
      $('.stepper').activateStepper();
   });

    </script> 
</body>

</html>