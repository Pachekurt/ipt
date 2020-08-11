<?php
  $ruta="../../../";
  include_once($ruta."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  session_start();
  $dsuc=$admsucursal->mostrarTodo("tipo=1");
  if (count($dsuc)>0) {
    $tipo=0;
  }else{
    $tipo=1;
  }
  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Registrar Sucursal";
      include_once($ruta."includes/head_basico.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=29;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="row">
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title"><?php echo $hd_titulo ?></h5>
                </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <input id="idtipo" name="idtipo" value="<?php echo $tipo ?>" type="hidden" class="validate">
                <div class="col s6 m6 l6">
                    <h4 class="header">Datos de Sucursal</h4>
                    <div class="formcontent">
                      <div class="row">
                        <div class="input-field col s12">
                          <?php 
                          if ($tipo==1){
                            ?>
                              <input id="idnombre" name="idnombre" value="Casa Matriz" readonly="" type="text" class="validate">
                            <?php
                          }else{
                            ?>
                              <input id="idnombre" name="idnombre" value="Sucursal " type="text" class="validate">
                            <?php
                          }
                          ?>
                          
                          <label for="idnombre">Nombre Sucursal</label>
                        </div>
                        <div class="input-field col s12">
                          <label>Expedido</label>
                          <select id="idciudad" name="idciudad">
                            <?php
                              foreach($dominio->mostrarTodo("tipo='DEP'") as $f)
                              {
                                ?>
                                  <option value="<?php echo $f['iddominio']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12">
                          <input id="idzona" name="idzona" type="text" class="validate">
                          <label for="idzona">Zona/Barrio</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="iddireccion" name="iddireccion" type="text" class="validate">
                          <label for="iddireccion">Direccion</label>
                        </div>
                        
                        <div class="input-field col s12">
                          <input id="idfono" name="idfono" type="text" class="validate active">
                          <label for="idfono">Telefonos</label>
                        </div>
                        
                        <div class="input-field col s12">
                          <input id="idactividad" name="idactividad" type="text" class="validate">
                          <label for="idactividad">Actividad Ecónomica</label>
                        </div>                      
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <a id="btnLimpiar" class="btn waves-effect waves-light orange"><i class="fa fa-save"></i> Limpiar</a>
                          <a id="btnSave" class="btn waves-effect waves-light blue"><i class="fa fa-save"></i> Registrar Sucursal</a>
                        </div>
                      </div>
                    </div>
                </div>
              </form>
            </div>
          </div>
          <?php
            include_once("../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
    ?>
    <script type="text/javascript">
      $("#idcarnet").change(function(){
        carnet=$('#idcarnet').val();
          $.ajax({
            url: "validaCarnet.php",
            type: "POST",
            data: "carnet="+carnet+"&lblcontrato=<?php echo $idcontrato ?>",
            success: function(resp){
              console.log(resp);
              $('#valCarnet').html(resp).slideDown(500);
            }
          });
      });
      $("#btnSave").click(function(){
        $('#btnSave').attr("disabled",true);
          swal({
            title: "CONFIRMACION",
            text: "Se registrara la Sucursal",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "GUARDAR",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idform" ).serialize();
            //alert(str);
            $.ajax({
              url: "guardar.php",
              type: "POST",
              data: str+"&lblcode=<?php echo $valor ?>",
              success: function(resp){
                console.log(resp);
                 $("#idresultado").html(resp);
              }
            }); 
          });
      });
    </script>
</body>

</html>