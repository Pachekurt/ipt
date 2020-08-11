<?php
  $ruta="../../";
  include_once($ruta."class/vcurso.php");
  $vcurso=new vcurso;
  include_once($ruta."class/estudiantecurso.php");
  $estudiantecurso=new estudiantecurso;
  include_once($ruta."class/estudiante.php");
  $estudiante=new estudiante;
  include_once($ruta."class/persona.php");
  $persona=new persona;
    include_once($ruta."class/vestudiantecurso.php");
  $vestudiantecurso=new vestudiantecurso;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;

  session_start(); 
  extract($_GET);
  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede'];
  //$idejecutivo=$us['idadmejecutivo'];

    $idcurso=dcUrl($idcurso); 
    $vcu=$vcurso->mostrar($idcurso);
    $vcu=array_shift($vcu);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="ASIGNAR";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
</head>
<body>
   
    <div id="main">
      <div class="wrapper">
       
        <section id="content">
          <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                   <div id="card-alert" class="card green lighten-5">
                      <div class="card-content green-text" style="font-size:17px;">
                      <label class="light center-align green-text" style="font-size:25px;"><strong>INFORMACIÓN DEL CURSO</strong></label>
                       <p><strong>Modulo: </strong> <?php echo $vcu['modulo'].' - '.$vcu['descripcion'] ?></p>
                       <p><strong>Hora: </strong> <?php echo $vcu['inicio'].' - '.$vcu['fin'] ?></p> 
                       <p><strong>Docente: </strong> <?php echo $vcu['nombre']." ".$vcu['paterno']." ".$vcu['materno'] ?></p>
                      </div>
                   </div>
               </div>

              </div>
          </div>

          <div class="container">
            <div class="section"> 
              <div id="table-datatables">
             <!-- <a href="../inicio" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> -->
              
               
              <div class="row">
              <div class="col s12 m12 l12" align="center">
                  <h5 class="breadcrumbs-title"><strong>LISTA DE ESTUDIANTE EN EL CURSO</strong></h5>
                </div>
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                       <th>Estudiante</th>
                       <th>Carnet</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Estudiante</th>
                        <th>Carnet</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      foreach($vestudiantecurso->mostrarTodo("idcurso=".$idcurso ) as $f)
                      {
                        
                      ?>
                      <tr>
                        <td><?php echo $f['estudiante'] ?></td>
                        <td><?php echo $f['carnet'] ?></td>
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

    function cerrar()
    {
     window.close(); 
    }
    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
      $('.btndel').tooltip({delay: 50});
    }); 
   
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
    
    </script>
</body>

</html>