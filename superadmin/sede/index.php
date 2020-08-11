<?php
  $ruta="../../";
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/rol.php");
  $rol=new rol;
  include_once($ruta."funciones/funciones.php");
  session_start();
  $idsede=$_SESSION["idsede"];
  $idusuario=$_SESSION["codusuario"];
  $dse=$sede->muestra($idsede);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="CAMBIAR DE SEDE";
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
          $idmenu=81;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <div id="breadcrumbs-wrapper">
            <div class="row">
                <div class="col s12 m12 l5">
                  <h5 class="breadcrumbs-title">SEDE <?php echo $dse['nombre'] ?> </h5>
                  <ol class="breadcrumbs">
                  </ol>
                </div>
            </div>
          </div>
          <div class="container">
            <!-- ver si es director -->
            <div class="row">
              <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <div class="row">
                  <div class="input-field col s2">
                    Cambiar de Sede
                    <br><br><br><br><br><br><br>
                  </div>
                  <div class="input-field col s6">
                  <fieldset>
                    <legend>MODIFICAR SEDE</legend>
                    <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $idusuario ?>">
                    <div class="input-field col s12">
                        <label>ASIGNAR ROL</label>
                        <select id="idsede" name="idsede">
                          <?php
                            foreach($sede->mostrarTodo("tipo=0") as $f)
                            {
                              $sel="";
                              if ($f['idsede']==$idsede) {
                                $sel="selected";
                              }
                              ?>
                                <option <?php echo $sel ?> value="<?php echo $f['idsede']; ?>"><?php echo $f['nombre']; ?></option>
                              <?php
                            }
                          ?>
                        </select>
                      </div>
                    <div class="input-field col s12">
                      <button style="width: 100%" id="btnEdit" class="btn green"><i class="fa fa-save"></i> GUARDAR CAMBIOS</button>
                    </div>
                  </fieldset>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <?php
            include_once("../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
    ?>
    <script type="text/javascript">
      $("#btnEdit").click(function(){
        if (validar()) {          
          $('#btnEdit').attr("disabled",true);
          swal({
            title: "CONFIRMACION",
            text: "Se Cambiaras de Sede",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "Registrar",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idform" ).serialize();
            //alert(str);
            $.ajax({
              url: "guardar.php",
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
        passX=$("#idusante").val();
        if (pass1==pass2) { 
            if (passX!='') {
                retorno=true;
              } 
        }
        return retorno;
      }
    </script>
</body>

</html>