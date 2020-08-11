<?php
  $ruta="../../";
   include_once($ruta."class/vestudiante.php");
  $vestudiante=new vestudiante;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/estudiantereserva.php");
  $estudiantereserva=new estudiantereserva;
  include_once($ruta."class/examen.php");
  $examen=new examen;
  include_once($ruta."class/examenfinal.php");
  $examenfinal=new examenfinal;
  include_once($ruta."class/admestudiante.php");
  $admestudiante=new admestudiante;
  session_start(); 
   extract($_GET);
   extract($_POST);

  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);

  $us=array_shift($us);

  $dper=$admestudiante->muestra($idest);
  $idsede=$us['idsede']; 
  //echo $idsede;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="WRITING";
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
          $idmenu=1015;
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
            <div class="row"> 
              <div id="table-datatables">
              <a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> 
               

              <div class="row">
               <form id="idform" action="return false" onsubmit="return false" method="POST">
                 <div>
                  <div class="input-field col s4">
                    <input id="idnombre" name="idnombre" readonly="" value="<?php echo $dper['nombre'] ?>" type="text" >
                    <label for="idnombre">Nombre(s)</label>
                  </div>
                  <div class="input-field col s4">
                   <input id="idpaterno" name="idpaterno" readonly=""  value="<?php echo $dper['paterno'] ?>" type="text" >
                    <label for="idpaterno">Paterno</label>
                  </div>
                  </div>
      

              </form>
              </div>
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
     
    </script>
</body>

</html>