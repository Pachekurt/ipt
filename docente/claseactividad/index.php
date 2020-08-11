<?php
  $ruta="../../";
   include_once($ruta."class/estudiante.php");
  $estudiante=new estudiante;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
   include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/vactividadhabil.php");
  $vactividadhabil=new vactividadhabil;
  include_once($ruta."class/actividadreserva.php");
  $actividadreserva=new actividadreserva;
  session_start(); 
  extract($_GET);
 
  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede'];
  $idejecutivo=$us['idadmejecutivo'];//84;//
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="LISTA DE ACTIVIDADES";
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
          $idmenu=1018;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12" align="center">
                <div class="card-title" style="background:#0277bd; color:white; border-radius:5px;"><h5><strong><?php echo $hd_titulo; ?></strong> </h5></div>
                  
                </div>
              </div>
            </div>
          </div>
         
          <div class="container">
            <div class="section">
            <div class="row">
              <section class="plans-container" id="plans">
                <?php
                      $fechaactual=date('Y-m-d');    
                      $consulta="SELECT *
                                  FROM vactividadhabil vah
                                  where vah.idsede=$idsede and vah.fecha >='$fechaactual' and vah.idejecutivo=$idejecutivo order by vah.fecha,vah.horainicio ASC LIMIT 10";
                      foreach($vactividadhabil->sql($consulta) as $f)                   
                     // foreach($vactividadhabil->mostrarTodo("idsede=".$idsede." and fecha >='$fechaactual'") as $f)
                      {
                        $estC=$actividadreserva->mostrarTodo("idactividadhabil=".$f['idvactividadhabil']);
                        $idvah=ecUrl($f['idvactividadhabil']);
                       ?>
                            <article class="col s12 m6 l2">
                              <div class="card hoverable">
                                <div class="card-image light-blue darken-2 waves-effect">
                                  <div class="card-title"><strong><?php echo $f['actividad'] ?></strong></div>
                                  <div class="price" style="font-size:40px;" onclick="ver('<?php echo $idvah ?>');"><sup></sup><strong><?php echo count($estC) ?></strong></div>
                                 
                                </div>
                                <div class="card-content" align="center">
                                  <ul class="collection">
                                  <div style="color:#01579b; font-size:18px;"><?php echo $f['nombredia'].' '.$f['horainicio'].':00hrs' ?></div>
                                  <div><?php echo $f['literal'] ?></div>
                                  </ul>
                                </div>
                                <div class="card-action center-align">    
                                <?php 
                                  if ($f['fecha']==$fechaactual) 
                                  {
                                    ?>
                                     <button class="waves-effect waves-light  btn" onclick="cargarclase('<?php echo $f['idvactividadhabil'] ?>');">INGRESAR A CLASE</button>
                                    <?php
                                  }else{
                                    ?>
                                     <button class="waves-effect waves-light  btn" style="opacity:0.1;" >INGRESAR</button>
                                    <?php
                                  }
                                 ?>                  
                                 
                                </div>
                              </div>
                            </article>
                      <?php
                        }
                      ?>
              </section>
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


      
        function ver(idvah)
     {
        popup=window.open("../../recepcion/reserva/ver.php?idvah="+idvah,"neo","width=800,height=600,enumerar=si;");
        popup.focus();
     }  
      function cargarclase(idah)
      {
        //alert(idcurso);
         $.ajax({
            url: "generaasistenciaA.php",
            type: "POST",
            data: "idah="+idah,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
             // alert();
            }
          });
      }

    $(document).ready(function() {
      $('#example').DataTable({
        dom: 'Bfrtip',
        "order": [[ 2, "asc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
      $('.btndel').tooltip({delay: 50});
    }); 


    </script>
</body>

</html>