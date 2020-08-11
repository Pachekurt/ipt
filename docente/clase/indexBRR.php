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
  //$idejecutivo=$us['idadmejecutivo'];
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
                   $horaActual=date('08:45:01');//date("H:i:s");
                      $consulta="SELECT * FROM vcurso 
                                where idejecutivo=84 
                                and '$fechaActual' BETWEEN fechainicio and fechafin
                                and '$horaActual' < fin";//and '08:00:00' BETWEEN inicio and fin
                      foreach($vcurso->sql($consulta) as $f)
                      {
                         $idcurso=ecUrl($f['idvcurso']);
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
                                      <div class="price-desc"><strong><?php echo $f['fechainicio']."  a  ".$f['fechafin'] ?></strong> </div>
                                    </div>
                                    <div class="card-content">
                                      <ul class="collection">
                                        <li class="collection-item">
                                           <?php 
                                              //if ($horaActual." BETWEEN (".$f['inicio'].",".$f['fin'].")" )
                                              if ($horaActual > $inicio and $horaActual < $fin ) 
                                              {
                                                ?>
                                                  <label style="color:green; font-size:18px;"><strong><i class="mdi-action-assignment-turned-in"></i>CLASE ACTIVO</strong> </label>
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
                                     if ($f['estadoclase']==0 and $horaActual > $inicio) 
                                     {
                                       ?>
                                        <button class="waves-effect waves-light  btn">INICIAR</button>                                        
                                        <?php
                                      }elseif($f['estadoclase']==1 and $horaActual > $inicio)
                                      {
                                        ?>
                                          <a href="curso.php?codecurso=<?php echo $idcurso ?>" class="waves-effect waves-light  btn"><i class="mdi-action-assignment"></i> INGRESAR A CLASE</a>
                                      <?php
                                      }else{
                                            ?>
                                         <button class="waves-effect waves-light  btn" disabled>INICIAR</button> 
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
      function cursoactual(ide)
     {
        
        $('#idestudianteSel').val(ide);
        $.ajax({
            async: true,
            url: "cargarCursoEst.php?ide="+ide,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#idestudianteSel").val(json.idestudianteInport);
                $("#docenteEC").text(json.docenteEC);
                $("#moduloEC").text(json.moduloEC);
                $("#horarioEC").text(json.horarioEC);
                $("#fechainicioEC").text(json.fechainicioEC);
                $("#fechafinEC").text(json.fechafinEC);
                $("#estudianteEC").text(json.estudianteEC);
                $("#carnetEC").text(json.carnetEC);              
            }
            
          });
     }
    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
      $('.btndel').tooltip({delay: 50});
    }); 
      $("#btnSave").click(function(){        
        if (validar()) 
        {        
          $('#btnSave').attr("disabled",true);
          var str = $( "#idform" ).serialize();
          alert(str);
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
        retorno=true;
        mod=$('#idmodulo').val();
        doc=$('#iddocente').val();
        fechai=$('#idfechaini').val();
        fechaf=$('#idfechafin').val();
        horai=$('#idhoraini').val();
        horaf=$('#idhorafin').val();
        if(mod=="0" || doc=="0" || fechai=="" || fechaf=="" || horai=="" || horaf==""){
          retorno=false;
        }
        return retorno;
      }
      function Eliminar(id){
        swal({
          title: "Estas Seguro?",
          text: "El rol se eliminara",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {      
          $.ajax({
            url: "eliminar.php",
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