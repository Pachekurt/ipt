<?php
  $ruta="../../";
  include_once($ruta."class/vactividadhabil.php");
  $vactividadhabil=new vactividadhabil;
    include_once($ruta."class/vactividadreserva.php");
  $vactividadreserva=new vactividadreserva;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;

  session_start(); 
  extract($_GET);
  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede'];
  //$idejecutivo=$us['idadmejecutivo'];

    $idactividadhabil=dcUrl($idvah); 
    $v_ar=$vactividadhabil->mostrar($idactividadhabil);
    $v_ar=array_shift($v_ar);

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
                           <div class="col s12 m12 l12">
                            <label class="light center-align green-text" style="font-size:25px;"><strong>INFORMACIÓN DE LA ACTIVIDAD</strong></label>
                           </div>
                           <div class="col s12 m6 l6">
                           <p><strong>Actividad: </strong> <?php echo $v_ar['actividad'] ?></p>
                           <p><strong>Fecha: </strong> <?php echo $v_ar['nombredia'].' - '.$v_ar['fecha'] ?></p>
                           <p><strong>Hora inicio: </strong> <?php echo $v_ar['horainicio'].':00 hrs' ?></p>  
                           </div>
                           <div class="col s12 m6 l6">
                              <p><strong>duracion: </strong> <?php echo $v_ar['duracion'].':00 hrs' ?></p>                       
                              <p><strong>Docente: </strong> <?php echo $v_ar['nombre']." ".$v_ar['paterno']." ".$v_ar['materno'] ?></p>
                           </div> 
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
                      foreach($vactividadreserva->mostrarTodo("idactividadhabil=".$idactividadhabil." and idsede=".$idsede) as $f)
                      {
                        
                      ?>
                      <tr>
                        <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td>
                        <td><?php echo $f['carnet'].' '.$f['expedido'] ?></td>
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