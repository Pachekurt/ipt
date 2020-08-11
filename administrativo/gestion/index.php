<?php
  $ruta="../../";
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admgestion.php");
  $admgestion=new admgestion;
  include_once($ruta."funciones/funciones.php");
  session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Administrar Gestion";
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
          $idmenu=19;
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
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="input-field col s2">
                    <button id="idAdGestion" class="btn"><i class="fa fa-plus"></i> NUEVA GESTION</button>
                  </div>
                </div>
              </div>   
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>COD</th>
                      <th>Gestion</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>COD</th>
                      <th>Gestion</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $sw=true;
                    foreach($admgestion->mostrarTodo("") as $f)
                    {
                      $idgestion=ecUrl($f["idadmgestion"]);
                      switch ($f['estado']) {
                        case '0'://pendiente nueva gestion
                          $estilo="background-color: #ffad49;";
                        break;
                        case '1'://gestion activa
                          $estilo="background-color: #68ff49; color:#005b12; font-weight: bold;";
                        break;
                        case '2'://gestion pasada
                          $estilo="background-color: #dbdbdb;";
                        break;
                      }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['idadmgestion'] ?></td>
                      <td><?php echo $f['anio'] ?></td>
                      <td>
                        <?php
                          switch ($f['estado']) {
                            case '0'://pendiente nueva gestion
                              if($sw)
                              {
                                ?>
                                  <button onclick="activarGestion('<?php echo $f["idadmgestion"] ;?>');" class="btn-jh waves-effect waves-light green"><i class="fa fa-star-o"></i> Activar Gestion</button>
                                <?php
                              }
                              ?>
                                <a href="semana/?lblcode=<?php echo $idgestion ?>" class="btn-jh waves-effect waves-light blue"><i class="fa fa-gear"></i> Configurar Semanas</a>
                              <?php
                              $sw=false;
                            break;
                            case '1'://gestion activa
                              ?>
                                <i class="fa fa-star"></i> ACTIVO
                                <a href="semana/?lblcode=<?php echo $idgestion ?>" class="btn-jh waves-effect waves-light green"><i class="fa fa-eye"></i> Ver Semanas</a>
                                <button onclick="cerrarGestion('<?php echo $f["idadmgestion"] ;?>');"  class="btn-jh waves-effect waves-light red"><i class="fa fa-gear"></i> Cerrar Gestion</button>
                              <?php
                              $sw=false;
                            break;
                            case '2'://gestion pasada
                              ?>
                               <i class="fa fa-unlock-alt"></i> Gestion Pasado
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
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable();
      $('#idAdGestion').click(function(){
        swal({
          title: "Estas Seguro?",
          text: "Agregaras una nueva Gestion",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        },function(){      
          $.ajax({
            url: "nuevaGestion.php",
            type: "POST",
            success: function(resp){
              console.log(resp);
              $("#idresultado").html(resp);
            }
          });
        });
      });
    });
    function cerrarGestion(id){
      swal({
        title: "Estas Seguro?",
        text: "Cerraras la Gestion",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "cerrarGestion.php",
          type: "POST",
          data: "id="+id,
          success: function(resp){
            $("#idresultado").html(resp);
          }   
        });
      }); 
    }
    function activarGestion(id){
      swal({
        title: "Estas Seguro?",
        text: "Cerraras la Gestion",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "activarGestion.php",
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