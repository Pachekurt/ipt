<?php
  $ruta="../../";
  include_once($ruta."class/invcategoria.php");
  $invcategoria=new invcategoria;
  include_once($ruta."funciones/funciones.php");
  session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Items de inventarios ";
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
          $idmenu=92;
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
              <a href="nuevo/" class="btn blue"><i class="fa fa-plus"></i> Nuevo Item</a><br><br>
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Descripcion</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sw=true;
                    foreach($invcategoria->mostrarTodo("") as $f)
                    {
                      $lblcode=ecUrl($f['idinvitem']);
                    ?>
                    <tr>
                      <td><?php echo $f['nombre'] ?></td>
                      <td><?php echo $f['descripcion'] ?></td>
                      
                      <td>
                        <a href="editar/?lblcode=<?php echo $lblcode ?>" class="btn-jh green"><i class="fa fa-edit"></i> EDITAR</a>
                        <button class="btn-jh red"><i class="fa fa-times"></i> ELIMINAR</button>
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
    <div class="row">
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
    });
    </script>
</body>

</html>