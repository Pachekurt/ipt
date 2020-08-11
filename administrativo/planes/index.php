<?php
  $ruta="../../";
  include_once($ruta."class/admplanes.php");
  $admplanes=new admplanes;


  include_once($ruta."funciones/funciones.php");
  session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Administrar Planes ";
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
          $idmenu=34;
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
            <a href="#modal1" class="btn waves-effect waves-light indigo modal-trigger"><i class="fa fa-plus-square"></i> Nuevos Planes</a><br><br>
                <div id="modal1" class="modal">
                  <div class="modal-content">
                  <h1>Nuevos Planes</h1>
                    <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                      <div class="row">
                        <div class="input-field col s12">
                          <input id="idnombre" name="idnombre" id="first_name" type="text" class="validate">
                          <label for="first_name">Nombre del Plan</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idfinicio" name="idfinicio" type="date" class="validate">
                          <label for="idfinicio">Fecha Inicio</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idffin" name="idffin" type="date" class="validate">
                          <label for="idffin">Fecha Fin</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idobs" name="idobs" type="text" class="validate">
                          <label for="idobs">Observaciones</label>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <a href="#" class="btn waves-effect waves-light red modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</a>
                    <button id="btnSave" href="#" class="btn waves-effect waves-light green"><i class="fa fa-save"></i> CREAR PLAN</button>
                  </div>
                </div>
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Orden</th>
                      <th>Plan</th>
                      <th>Fecha Inicio</th>
                      <th>Fecha Fin</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Orden</th>
                      <th>Plan</th>
                      <th>Fecha Inicio</th>
                      <th>Fecha Fin</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $sw=true;
                    foreach($admplanes->mostrarTodo("") as $f)
                    {
                      $lblcode=ecUrl($f['idadmplanes']);
                      switch ($f['estado']) {
                        case '0':
                          $estilo="background-color: #f4a742;";
                        break;
                        case '1':
                          $estilo="background-color: #41f462;";
                        break;
                        case '2':
                          $estilo="background-color: #f46741;";
                        break;
                      }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['idadmplanes'] ?></td>
                      <td><?php echo $f['nombre'] ?></td>
                      <td><?php echo $f['fechainicio'] ?></td>
                      <td><?php echo $f['fechafin'] ?></td>
                      <td><?php 
                        switch ($f['estado']) {
                          case '0':
                            echo "PENDIENTE";
                          break;
                          case '1':
                            echo "VIGENTE";
                          break;
                          case '2':
                            echo "PASADO";
                          break;
                        }
                      ?></td>
                      <td> 
                        <?php
                          switch ($f['estado']) {
                            case '0'://pendiente nueva gestion
                              if($sw)
                              {
                                ?>
                                  <button onclick="activarplanes('<?php echo $f["idadmplanes"] ;?>');" class="btn-jh waves-effect waves-light green"><i class="fa fa-star-o"></i> Activar Planes</button>
                                <?php
                              }
                              ?>
                                <a href="administrar/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect waves-light blue"><i class="fa fa-gear"></i> Configurar Planes</a>
                              <?php
                              $sw=false;
                            break;
                            case '1'://gestion activa
                              ?>
                                <i class="fa fa-star"></i> ACTIVO
                                <a href="administrar/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect waves-light green"><i class="fa fa-eye"></i> Ver Planes</a>
                                <button onclick="cerrarPlanes('<?php echo $lblcode ?>');"  class="btn-jh waves-effect waves-light red"><i class="fa fa-gear"></i> Cerrar Planes</button>
                              <?php
                              $sw=false;
                            break;
                            case '2'://gestion pasada

                              ?>
                              <a href="administrar/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect waves-light green"><i class="fa fa-eye"></i> Ver Planes</a>
                               <i class="fa fa-unlock-alt"></i> Planes Pasados
                              <?php
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
              </div>
            </div>
          </div>
          <?php
            include_once("../footer.php");
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
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
      $('#btnSave').click(function(){
         var str=$("#idform").serialize();; 
          $.ajax({
            url: "guardar.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $("#idresultado").html(resp);
            }
          });
      });
    });
    function cerrarPlanes(id){
      swal({
        title: "Estas Seguro?",
        text: "Cerraras los planes",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "cerrarplanes.php",
          type: "POST",
          data: "id="+id,
          success: function(resp){
            $("#idresultado").html(resp);
          }   
        });
      }); 
    }
    function activarplanes(id){
      swal({
        title: "Estas Seguro?",
        text: "Activaras los planes",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "activarplanes.php",
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