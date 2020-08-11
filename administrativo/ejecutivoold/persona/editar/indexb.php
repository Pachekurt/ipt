<?php
  $ruta="../../../../";
  include_once($ruta."class/vejecutivopersona.php");
  $vejecutivopersona=new vejecutivopersona;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/persona.php");
  $persona=new persona;
   include_once($ruta."class/titular.php");
  $titular=new titular;

  include_once($ruta."funciones/funciones.php");
  session_start();  
  extract($_GET);
  $valor=dcUrl($lblcode);
  if (!ctype_digit(strval($valor))) {
    if (!isset($_SESSION["faltaSistema"]))
    {  $_SESSION['faltaSistema']="0"; }
    $_SESSION['faltaSistema']=$_SESSION['faltaSistema']+1;
    ?>
      <script type="text/javascript">
        ruta="<?php echo $ruta ?>login/salir.php";
        window.location=ruta;
      </script>
    <?php
  }
  $dper=$persona->muestra($valor);
  $persona= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Registrar Titular";
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
          $idmenu=35;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="row">
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title">Registrar Titular</h5>
                  <ol class="breadcrumbs">
                    <li class="activoTab"><a href="../editar/?lblcode=<?php echo $lblcode ?>"> Datos de Persona </a></li>
                    <li><a href="../domlab/?lblcode=<?php echo $lblcode ?>"> Domicilios y Trabajos</a></li>
                  </ol>
                </div>
                <div class="col s7 m7 l7">
                  <table class="csscontrato">
                    <thead>
                      <tr>
                        <th>Carnet</th>
                        <th>Nombre</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $dper['carnet']." ".$dper['expedido'] ?></td>
                        <td><?php echo $persona ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <div class="col s8 m8 l8">
                    <input id="idpersona" name="idpersona" type="hidden" readonly value="<?php echo $lblcode; ?>">
                    <h4 class="header">Datos del Titular</h4>
                    <div class="formcontent">
                      <div class="row">
                        <div id="valCarnet" class="col s12"></div>
                        <div class="input-field col s6">
                          <input id="idcarnet" name="idcarnet" readonly value="<?php echo $dper['carnet'] ?>" type="text" class="validate">
                          <label for="idcarnet">CARNET</label>
                        </div>
                        <div class="input-field col s6">
                          <label>Expedido</label>
                          <select id="idexp" name="idexp">
                            <option disabled value="">Seleccionar Departamento</option>
                            <?php
                              foreach($dominio->mostrarTodo("tipo='DEP'") as $f)
                              {
                                $sw="";
                                if ($dper['expedido']==$f['short']) {
                                   $sw="selected";
                                }
                                ?>
                                  <option <?php echo $sw ?> value="<?php echo $f['short']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s6">
                          <input id="idnombre" name="idnombre" value="<?php echo $dper['nombre'] ?>" type="text" class="validate">
                          <label for="idnombre">Nombre(s)</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idpaterno" name="idpaterno" value="<?php echo $dper['paterno'] ?>" type="text" class="validate">
                          <label for="idpaterno">Paterno</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idmaterno" name="idmaterno" value="<?php echo $dper['materno'] ?>" type="text" class="validate active">
                          <label for="idmaterno">Materno</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idnacimiento" name="idnacimiento" value="<?php echo $dper['nacimiento'] ?>" type="date" class="validate">
                          <label for="idnacimiento">Fecha Nacimiento</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idemail" name="idemail" value="<?php echo $dper['email'] ?>" type="email" class="validate">
                          <label for="idemail">Email</label>
                        </div>  
                        <div class="input-field col s6">
                          <input id="idcelular" name="idcelular" value="<?php echo $dper['celular'] ?>" type="text" class="validate">
                          <label for="idcelular">Celular(es)</label>
                        </div>
                        <div class="input-field col s4">
                          <label>Sexo</label>
                          <select id="idsexo" name="idsexo">
                              <?php
                              foreach($dominio->mostrarTodo("tipo='SX'") as $f)
                              {
                                $sw="";
                                if ($dper['idsexo']==$f['iddominio']) {
                                   $sw="selected";
                                }
                                ?>
                                  <option <?php echo $sw ?> value="<?php echo $f['iddominio']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s8">
                          <input id="idocupacion" name="idocupacion" value="<?php echo $dper['ocupacion'] ?>" type="text" class="validate">
                          <label for="idocupacion">Ocupacion</label>
                        </div>                       
                      </div>
                      <div class="row">
                        <div class="input-field col s5"></div>
                        <div class="input-field col s7">
                          <a id="btnLimpiar" class="btn waves-effect waves-light orange"><i class="fa fa-save"></i> Limpiar</a>
                          <a id="btnSave" class="btn waves-effect waves-light blue"><i class="fa fa-save"></i> Actualizar Datos</a>
                        </div>
                      </div>
                    </div>
                </div>
              </form>
            </div>
          </div>
          <?php
            include_once("../../../footer.php");
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
        $("#valCarnet").html("").slideUp(300);
        var nombreVal1 = $("#idnombre").val();
        var carnetVal1 = $("#idcarnet").val();
        if (nombreVal1 == '' || carnetVal1 == '') 
        {
          $("#valCarnet").html("<div id='card-alert' class=' red'><div class=' white-text'><p><i class='mdi-navigation-check'></i> Datos Faltantes. Carnet o Nombre</p></div> </div>").slideDown(500);
        }else {
          swal({
            title: "CONFIRMACION",
            text: "Se guardara el titular",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "GUARDAR",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idform" ).serialize();
            $.ajax({
              url: "actualizar.php",
              type: "POST",
              data: str,
              success: function(resp){
                console.log(resp);
                 $("#idresultado").html(resp);
              }
            }); 
          });
        }  
      });
    </script>
</body>

</html>