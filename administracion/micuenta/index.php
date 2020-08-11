<?php
  $ruta="../../";
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/rol.php");
  $rol=new rol;

  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $codUs=$_SESSION["codusuario"];
  $dus=$usuario->muestra($codUs);



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="USUARIO Y CONTRASEÑA";
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
          $idmenu=80;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="row">
                <div class="col s12 m12 l5">
                  <h5 class="breadcrumbs-title">ADMINISTRAR MI CUENTA</h5>
                  <ol class="breadcrumbs">
                  </ol>
                </div>
            </div>
          </div>
          <div class="container">
            <!-- ver si es director -->
            <div class="row">
              <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <input type="hidden" value="<?php echo $deje['idvejecutivo'] ?>" name="idejecutivo" id="idejecutivo">
                <div class="row">
                  <div class="input-field col s2">
                    Asignar Usuario y Contraseña
                    <br><br><br><br><br><br><br>
                  </div>
                  <div class="input-field col s6">
                    <?php
                      if (count($dus)>0) {
                        ?>
                          <fieldset>
                            <legend>MODIFICAR CONTRASEÑA</legend>
                            <input type="hidden" name="idus" id="idus" value="<?php echo $dus['idusuario'] ?>">
                            <div class="input-field col s12">
                              <input id="idusmod" name="idusmod" type="text" readonly="" value="<?php echo $dus['usuario'] ?>" class="validate">
                              <label for="idusmod">USUARIO</label>
                            </div>
                            <div class="input-field col s12">
                              <input id="idusante" name="idusante" type="password" class="validate">
                              <label for="idusante">CONTRASEÑA ANTERIOR</label>
                            </div>                            
                            <div class="input-field col s12">
                              <input id="idpass1" name="idpass1" type="password" class="validate">
                              <label for="idpass1">NUEVA CONTRASEÑA</label>
                            </div>
                            <div class="input-field col s12">
                              <input id="idpass2" name="idpass2" type="password" class="validate">
                              <label for="idpass2">REPITA CONTRASEÑA</label>
                            </div>
                            <div class="input-field col s12">
                              <button style="width: 100%" id="btnEdit" class="btn green"><i class="fa fa-save"></i> GUARDAR CAMBIOS</button>
                            </div>
                          </fieldset>
                        <?php
                      }
                    ?>
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
      $("#idusante").blur(function(){
        nusuario=$("#idusmod").val();
        pass=$("#idusante").val();
        $.ajax({
            url: "valpass.php",
            type: "POST",
            data: 'idusmod='+nusuario+'&idusante='+pass,
            success: function(resp){
              console.log(resp);
              $("#idresultado").html(resp);
            }
          });
      });
      $("#btnEdit").click(function(){
        if (validar()) {          
          $('#btnSave').attr("disabled",true);
          swal({
            title: "CONFIRMACION",
            text: "Esta seguro de modificar la contraseña?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "Registrar",
            closeOnConfirm: true
          }, function () {
            var str = $( "#idform" ).serialize();
            //alert(str);
            $.ajax({
              url: "modificar.php",
              type: "POST",
              data: str,
              success: function(resp){
                console.log(resp);
                $("#idresultado").html(resp);
              }
            }); 
          });
        }
        else{
          Materialize.toast('<span>Las contraseñas no coinciden.</span>', 1500);
          $("#idpass1").focus();
        }
      });
      function validar(){
        retorno=false;
        pass1=$("#idpass1").val();
        pass2=$("#idpass2").val();
        if (pass1==pass2) {
          retorno=true;
        }
        return retorno;
      }
    </script>
</body>

</html>