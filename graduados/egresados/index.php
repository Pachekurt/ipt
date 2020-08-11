<?php
  $ruta="../../";
   include_once($ruta."class/vestudiantefull.php");
  $vestudiantefull=new vestudiantefull;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
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
             <a href="notas.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> IMPRIMIR NOTAS</a> 
             
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Cuenta</th>
                        <th>Contrato</th> 
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Modulo</th>
                        <th>Horario</th> 
                        <th>Estado</th> 
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Estudiante</th>
                        <th>Cuenta</th>
                        <th>Contrato</th> 
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Modulo</th>
                        <th>Horario</th> 
                        <th>Estado</th>
                         
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      foreach($vestudiantefull->mostrarTodo("idsede=".$idsede." and estado in(1,2)   and estadoacademico in (150) ") as $f)
                      {
                        $idest=ecUrl($f['idestudiante']);
                      ?>
                      
                      <tr style="<?php echo $style ?>" >
                        <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td> 
                        <td><?php echo $f['cuenta'] ?></td>
                        <td><?php echo $f['nrocontrato'] ?></td> 
                        <td><?php echo $f['fechainicio'] ?></td>
                        <td><?php echo $f['fechafin'] ?></td>
                        <td><?php echo $f['mdescripcion'] ?></td>

                        <td><?php echo $f['inicio'] ?></td>

                        <td><?php echo $f['nestadoacademico'] ?></td>
                        <td>
                           
                            <button id="btngradua" class="btn waves-effect light-blue darken-4 indigo" onclick="titular('<?php echo $f['idestudiante'] ?>');"><i class="mdi-action-assignment-turned-in"></i>TITULADO</button>
                       </td>
                      
                          <td>
                             <a href="../impresion/reporte.php?idecod=<?php echo $idest ?>" class="btn-jh waves-effect waves-light blue tooltipped" target="_blank" data-position="bottom" data-delay="50" data-tooltip="VER REPORTE OBSERVACIONES"><i class="mdi-action-print"></i> </a>
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

 
     
     $("#btnSsaveV2").click(function(){
             
        iddocente=$("#idest").val();
        window.open("vistapordocente/?iddocente="+$("#iddocente").val(),"_blank");
         
      });
        
   

   
      function validar(){
        retorno=true;
        
        return retorno;
      }
      
   
     
      function titular(id){
        //alert(id);
        swal({
          title: "Estas Seguro?",
          text: "El estudiante pasara a graduados",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {      
          $.ajax({
            url: "titular.php",
            type: "POST",
            data: "id="+id,
            success: function(resp){
              $("#idresultado").html(resp);
            }   
          });
        }); 
      }
    </script>
</body>

</html>