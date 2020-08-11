<?php
  $ruta="../";  
  session_start();
  include_once($ruta."funciones/funciones.php");

  include_once($ruta."class/vestudiantefull.php");
  $vestudiantefull=new vestudiantefull;

  include_once($ruta."class/estudiante.php");
  $estudiante=new estudiante;

  $lblcode=ecUrl(3898);
  //echo $lblcode;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Pagina para generar automaticos";
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
          $idmenu=1000;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <center>
                    
                  <h5 class="breadcrumbs-title titulo"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                  </center>
                  <ol></ol>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div class="row">
             
              <?php
          foreach($vestudiantefull->mostrarTodo() as $f)
          {
            $mysqli1 = mysqli_connect("localhost", "duartema_admin", "Jhulios20005", "duartema_nacional"); 

            $resultado = $mysqli1->query("call califica('".$f['idestudiante']."')");


          }               
?>
              </div>
              
            </div>
          </div>
          <!--start container-->
          <div class="container">
            <!-- //////////////////////////////////////////////////////////////////////////// -->
            <!-- Floating Action Button -->
            <div class="fixed-action-btn" style="bottom: 50px; right: 19px;">
              <a class="btn-floating btn-large">
                <i class="mdi-action-stars"></i>
              </a>
              <ul>
                <li><a href="css-helpers.html" class="btn-floating red"><i class="large mdi-communication-live-help"></i></a></li>
                <li><a href="app-widget.html" class="btn-floating yellow darken-1"><i class="large mdi-device-now-widgets"></i></a></li>
                <li><a href="app-calendar.html" class="btn-floating green"><i class="large mdi-editor-insert-invitation"></i></a></li>
                <li><a href="app-email.html" class="btn-floating blue"><i class="large mdi-communication-email"></i></a></li>
              </ul>
            </div>
          </div>
          <!--end container-->
        </section>
      </div>
    </div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    
    <!-- Toast Notification -->
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
    });
    // Toast Notification
    $(window).load(function() {
        
        setTimeout(function() {
            Materialize.toast('<span>Bienvenido</span>', 1500);
        }, 1500);
        setTimeout(function() {
            Materialize.toast('<span>En el boton izquierdo puede ver tus opciones en el sistema</span>', 3000);
        }, 5000);
        setTimeout(function() {
            Materialize.toast('<span>No dudes en consultar al departamento de sistemas</span>', 3000);
        }, 15000);
    });
    </script>
</body>

</html>