<?php
  $ruta="../";  
  session_start();
  include_once($ruta."funciones/funciones.php");


  include_once($ruta."class/controlautomatico.php");
  $controlautomatico=new controlautomatico;

  include_once($ruta."class/vestudiantefull.php");
  $vestudiantefull=new vestudiantefull;
  $lblcode=ecUrl(3898);
  //echo $lblcode;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Bienvenido a Administracion del Sistema";
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
                <div class="col s12 m12 l6">
                  <div class="slider">
                    <ul class="slides">
                      <li>
                        <img src="<?php echo $ruta ?>imagenes/slide/0.jpg"> <!-- random image -->
                      </li>
                      <li>
                        <img src="<?php echo $ruta ?>imagenes/slide/1.jpg"> <!-- random image -->
                      </li>
                      <li>
                        <img src="<?php echo $ruta ?>imagenes/slide/2.jpg"> <!-- random image -->
                        
                      </li>
                      <li>
                        <img src="<?php echo $ruta ?>imagenes/slide/4.jpg"> <!-- random image -->
                        
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="col s12 m12 l6">

                  <?php 
  $fechaactual =  "'".date('Y-m-d')."'" ;
     $dato=$controlautomatico->mostrarTodo( "fechacreacion = $fechaactual");

        if (count($dato)==0){
           //echo "NO existe";
                $valores=array(
                  "estado"=>"'1'"
                 ); 
           $controlautomatico->insertar($valores);

           $consulta = "call duartema_nacional.actualizacontrato()";
           $resultado = $controlautomatico->sql($consulta);

           $consulta2 = "call duartema_nacional.actualizaacademico()";
           $resultado2 = $controlautomatico->sql($consulta2);


            
           ?>

              <script type="text/javascript">
                  
                              location.reload();
                  
              </script>
              <?php
        }
         else
          {
           //echo "  existe";
        }
          
                   ?>
                  <ul class="round" style="font-size: 15px;">
                    <li style="text-align: justify;" class="one">
                        <h5>
                            <i class="fa fa-check"></i> Bienvenido al Sistema Administrativo Contable</h5>
                        Usted se encuentra autentificado en donde podrá realizar operaciones según su perfil de trabajo. En caso de tener algún inconveniente o sugerencia con este sistema, deberá contactarse con el departamento de sistemas en la brevedad posible según sea el caso.
                    </li>
                    <li style="text-align: justify;" class="two"><br>
                        <h5>
                            <i class="fa fa-check"></i> Capacitación para uso del Sistema</h5>
                       Usted deberá ser capacitado por personal autorizado en donde deberá tener cuidado de tomar nota de las opciones que ofrece el sistema.
        
                    </li>
                    <li style="text-align: justify;" class="three"><br>
                        <h5>
                            <i class="fa fa-check"></i> Uso del Sistema</h5>
                        Una vez capacitado usted quedara como responsable de los datos generados por su persona y por consecuente el usuario y contraseña quedan de su propiedad que ningún caso deberá divulgar dicha informacion a terceras personas.
                    </li>
                  </ul>
                </div>
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