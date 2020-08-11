<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($ruta."class/admdosificacion.php");
  $admdosificacion=new admdosificacion;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
  extract($_GET);
  $idsucursal=dcUrl($lblcode);
  $dsucursal=$admsucursal->muestra($idsucursal);
  $dciudad=$dominio->muestra($dsucursal['idciudad']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Sucursales INGLES PARA TODOS";
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
          $idmenu=30;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
                <div class="col s7 m7 l7">
                  <table class="csscontrato">
                    <thead>
                      <tr>
                        <th>Sucursal</th>
                        <th>Ciudad</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $dsucursal['nombre'] ?></td>
                        <td><?php echo $dciudad['nombre'] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
            <a href="nuevo/?lblcode=<?php echo $lblcode ?>" class="btn green darken-4"><i class="fa fa-plus"></i> Nueva Dosificacion</a>
              <div id="table-datatables">
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Fecha Registro</th>
                    <th>Fecha limite</th>
                    <th>Nro. Tramite</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Fecha Registro</th>
                    <th>Fecha limite</th>
                    <th>Nro. Tramite</th>
                    <th>Estado</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  foreach($admdosificacion->mostrarTodo("idadmsucursal=$idsucursal") as $f)
                  {
                    switch ($f['estado']) {
                      case '0'://pendiente nueva gestion
                        $estilo="background-color: #e8c999;";
                      break;
                      case '1'://gestion activa
                        $estilo="background-color: #79c684; color:#005b12; font-weight: bold;";
                      break;
                    }
                  ?>
                  <tr style="<?php echo $estilo ?>">
                    <td><?php echo $f['fechacreacion'] ?></td>
                    <td><?php echo $f['fechalimite'] ?></td>
                    <td><?php echo $f['tramite'] ?></td>
                    <td>
                      <?php
                        switch ($f['estado']) {
                          case '0'://pendiente nueva gestion
                            echo "Caducado";
                          break;
                          case '1'://gestion activa
                            echo "Vigente";
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
      $("#btnSave").click(function(){        
        if (validar()) {        
          $('#btnSave').attr("disabled",true);
          var str = $( "#idform" ).serialize();
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
      function validar(){
        return true;
      }
    </script>
</body>

</html>