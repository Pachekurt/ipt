<?php
  session_start();
  $idusuario=$_SESSION["codusuario"];
  $ruta="../../../";
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."funciones/funciones.php");
  $dusuario=$usuario->muestra($idusuario);
  $idejecutivo=$dusuario['idadmejecutivo'];
  $dejec=$vejecutivo->muestra($idejecutivo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Administrar Organizacion";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wradmorganizacionapper">
        <?php
          $idmenu=37;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?> - <?php echo $dejec['nombre'].' '.$dejec['paterno'].' '.$dejec['materno'] ?></h5>
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
                      <th>Organizacion</th>
                      <th>Sede</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Organizacion</th>
                      <th>Sede</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    //foreach($admorganizacion->mostrarTodo("idadmejecutivo=".$idejecutivo) as $f)
                    foreach($admorganizacion->mostrarTodo("idadmejecutivo>0") as $f)
                    {
                        $lblcode=ecUrl($f['idadmorganizacion']);
                    ?>
                    <tr>
                      <td><?php echo $f['nombre'] ?></td>
                      <td><?php 
                        $dsede=$sede->muestra($f['idsede']);
                        echo $dsede['nombre'];
                      ?></td>
                      <td><a href="organigrama/?lblcode=<?php echo $lblcode ?>" class="btn-jh darken-4 purple"> <i class="fa fa-sitemap"></i> Administrar Organigramas</a></td>
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
      $('#example').DataTable();
    });
    </script>
</body>

</html>