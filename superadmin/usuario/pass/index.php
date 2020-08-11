<?php
  $ruta="../../../";
  include_once($ruta."class/vadmusuario.php");
  $vadmusuario=new vadmusuario;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/rol.php");
  $rol=new rol;

  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $valor=dcUrl($lblcode);
  $deje=$vadmusuario->mostrarUltimo("idusuario=".$valor);
  $dus=$usuario->mostrarUltimo("idusuario=$valor");



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="ASIGNAR USUARIO Y CONTRASEÑA";
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
          $idmenu=12;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="row">
                <div class="col s12 m12 l5">
                  <h5 class="breadcrumbs-title">MODIFICACION DE USUARIO</h5>
                  <ol class="breadcrumbs">
                  </ol>
                </div>
            </div>
          </div>
          <div class="container">
            <!-- ver si es director -->
            <div class="row">
              <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <input type="hidden" value="<?php echo $deje['idvadmusuario'] ?>" name="idejecutivo" id="idejecutivo"> 
                <input type="text" value="<?php echo $deje['nombre']." ".$deje['paterno'] ?>"  >
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
                            <legend>MODIFICAR USUARIO Y CLAVE</legend>
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
                                <label>ASIGNAR ROL</label>
                                <select id="idrol" name="idrol">
                                  <?php
                                   foreach($rol->mostrarTodo("") as $f)
                              {
                                $sw="";
                                if ($dus['idrol']==$f['idrol']) {
                                   $sw="selected";
                                }
                                ?>
                                  <option <?php echo $sw ?> value="<?php echo $f['idrol']; ?>"><?php echo $f['Nombre']; ?></option>
                                <?php
                              }
                                  ?>
                                </select>
                              </div>
                            <div class="input-field col s12">
                              <button style="width: 100%" id="btnEdit" class="btn green"><i class="fa fa-save"></i> GUARDAR CAMBIOS</button>
                            </div>
                          </fieldset>
                        <?php
                      }
                      else{
                        ?>
                          <fieldset>
                            <legend>NUEVO USUARIO Y CLAVE</legend>
                            <div class="input-field col s12">
                              <input id="idusuario" name="idusuario" type="text" class="validate">
                              <label for="idusuario">USUARIO</label>
                            </div>
                            <div class="input-field col s12">
                              <input id="idpass1" name="idpass1" type="password" class="validate">
                              <label for="idpass1">CONTRASEÑA</label>
                            </div>
                            <div class="input-field col s12">
                              <input id="idpass2" name="idpass2" type="password" class="validate">
                              <label for="idpass2">REPITA CONTRASEÑA</label>
                            </div>
                            <div class="input-field col s12">
                                <label>ASIGNAR ROL</label>
                                <select id="idrol" name="idrol">
                                  <?php
                                    foreach($rol->mostrarTodo("") as $f)
                                    {
                                      ?>
                                        <option value="<?php echo $f['idrol']; ?>"><?php echo $f['Nombre']; ?></option>
                                      <?php
                                    }
                                  ?>
                                </select>
                              </div>
                            <div class="input-field col s12">
                              <button style="width: 100%" id="btnSave" class="btn green"><i class="fa fa-save"></i> GUARDAR</button>
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
      $("#idusuario").blur(function(){
        nusuario=$("#idusuario").val();
        $.ajax({
            url: "validaUsuario.php",
            type: "POST",
            data: 'idusuario='+nusuario,
            success: function(resp){
              console.log(resp);
              $("#idresultado").html(resp);
            }
          });
      });
      $("#btnEdit").click(function(){
        if (validar()) {          
          $('#btnEdit').attr("disabled",true);
          swal({
            title: "CONFIRMACION",
            text: "Esta seguro de modificar la contraseña?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "Registrar",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idform" ).serialize();
           // alert(str);
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
          Materialize.toast('<span>Revise los datos por favor</span>', 1500);
          $("#idpass1").focus();
        }
      });
      $("#btnSave").click(function(){
        if (validar()) {          
          $('#btnSave').attr("disabled",true);
          swal({
            title: "CONFIRMACION",
            text: "Se registrara el usuario",
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