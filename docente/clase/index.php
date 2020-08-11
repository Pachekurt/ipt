<?php
  $ruta="../../";
   include_once($ruta."class/estudiante.php");
  $estudiante=new estudiante;
  include_once($ruta."class/vcurso.php");
  $vcurso=new vcurso;
  include_once($ruta."class/estudiantecurso.php");
  $estudiantecurso=new estudiantecurso;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  session_start(); 

  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede']; 
  $idejecutivo=$us['idadmejecutivo'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="CLASES DEL DOCENTE";
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
          $idmenu=1014;
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
                   <?php
                   //echo $idejecutivo." and ".$idusuario;
                   $fechaActual=date('Y-m-d');
                   $horaActual=date('H:i:s');//date("H:i:s");
                    $Horaactual10=date("H:i",strtotime($horaActual)-600);
                    $Horaactual2=date("H:i",strtotime($horaActual)-0);

                      $consulta="SELECT * FROM vcurso 
                                where idejecutivo=$idejecutivo 
                                and '$fechaActual' BETWEEN fechainicio and fechafin
                                and '$Horaactual10' < fin order by inicio";//and '08:00:00' BETWEEN inicio and fin
                      foreach($vcurso->sql($consulta) as $f)
                      {
                         //$idcurso=ecUrl($f['idvcurso']);
                        $idcurso=$f['idvcurso'];
                         $inicio=date($f['inicio']);
                         $fin=date($f['fin']);
                      ?>
                             <div class="col s12 m12 l3">
                               <section class="plans-container" id="plans">                
                                <article class="col s12 m6 l12">
                                  <div class="card z-depth-1 hoverable">
                                    <div class="card-image cyan waves-effect">
                                      <div class="card-title"><?php echo $f['modulo']." (".$f['mdescripcion'].")" ?></div>
                                      <div class="price" style="font-size:35px;"><?php echo $f['inicio'] ?></div>
                                      <div class="price" style="font-size:20px;"> a </div>
                                      <div class="price" style="font-size:35px;"><?php echo $f['fin'] ?></div>
                                      <div class="price-desc"><strong><?php echo "Inicio: ".$f['fechainicio']  ?></strong> </div>
                                    </div>
                                    <div class="card-content">
                                      <ul class="collection">
                                        <li class="collection-item">
                                           <?php 
                                          
                                         
                                              //if ($horaActual." BETWEEN (".$f['inicio'].",".$f['fin'].")" )
                                              if ($Horaactual2 > $inicio and $Horaactual10 < $fin ) 
                                              {
                                                ?>
                                                  <label style="color:green; font-size:18px;"><strong><i class="mdi-action-assignment-turned-in"></i>CLASE ACTIVA</strong> </label>
                                              <?php 
                                              }else{
                                                ?>
                                                <label>NO HABILITADO</label>
                                                
                                              <?php 
                                              }
                                              ?>
                                        </li>
                                      </ul>
                                    </div>
                                    <div class="card-action center-align">
                                     <?php 
                                      //if ($horaActual." BETWEEN (".$f['inicio'].",".$f['fin'].")" )
                                      if ($Horaactual2 > $inicio and $Horaactual10 < $fin ) 
                                      {
                                        ?>
                                        <button class="waves-effect waves-light  btn" onclick="cargarclase('<?php echo $idcurso ?>');">INGRESAR A CLASE</button>
                                      <?php 
                                      }else{
                                        ?>
                                        <button class="waves-effect waves-light  btn" disabled>INGRESAR A CLASE</button>
                                        
                                      <?php 
                                      }
                                      ?>
                                      
                                    </div>
                                  </div>
                                </article>                
                              </section>             
                            </div>
                      <?php
                      }
                      ?>
                
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
    
  
      function cargarclase(idcurso)
      {
        //alert(idcurso);
         $.ajax({
            url: "generarasistencia.php",
            type: "POST",
            data: "idcurso="+idcurso,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
      }
    </script>
</body>

</html>