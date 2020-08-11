<?php
  $ruta="../../";
  include_once($ruta."class/miempresa.php");
  $miempresa=new miempresa;
  session_start();
  extract($_GET);
  $valor=2;
  $idusuario=$_SESSION["codusuario"];
  $dempresa=$miempresa->muestra($valor);
  $adress=$_SERVER['REQUEST_URI'] ;
  $_SESSION["codempresa"]=$valor;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Datos";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_foto.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=28;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="row">
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title">Registrar Foto</h5>
                  <ol class="breadcrumbs">
                  </ol>
                </div>
            </div>
          </div>
          <div class="container">
            
          </div>
          <div class="container">
            <div class="row">
                <div class="col s6 m6 l6">
                  <h4 class="header">Datos INGLES PARA TODOS</h4>
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <div class="formcontent">
                      <div id="card-alert" class="card orange lighten-5">
                        <div class="card-content orange-text">
                          <p>ADVERTENCIA : Los cambios guardados afectarán a todo el Sistema de Facturación</p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <input id="idnombre" name="idnombre" type="text" value="<?php echo $dempresa['nombre'] ?>" class="validate">
                          <label for="idnombre">Nombre / Razon Social</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idnit" name="idnit" type="text" value="<?php echo $dempresa['nit'] ?>" class="validate">
                          <label for="idnit">Nit</label>
                        </div>             
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <a id="btnSave" class="btn waves-effect waves-light blue"><i class="fa fa-save"></i> Guardar Cambios</a>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col s6 m6 l6">
                    <h4 class="header"> Seleccionar Logo</h4>
                    <div class="formcontent">
                      <div style="margin-left: 50px;" class="row">
                        <div class="col-md-12">
                          <div class="editarfotoperfil">
                              <div class="ibox">
                                  <div class="ibox-content">
                                      <div class="clients-list">
                                        <!-- The file upload form used as target for the file upload widget -->
                                        <form id="fileupload"  method="POST" enctype="multipart/form-data">
                                            <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                                            <div class="row fileupload-buttonbar">
                                                <div class="col-lg-12">
                                                  <span class="btn green fileinput-button">
                                                      <i class="fa fa-folder-open-o"></i>
                                                      <span>Seleccionar Logo</span>
                                                      <input type="file" name="files[]" >
                                                  </span>
                                                </div>
                                            </div>
                                            <!-- The table listing the files available for upload/download -->
                                            <div id="scroll">
                                              <div id="scrollin">
                                                  <table role="presentation" class="table table-striped table-hover">
                                                  <tbody class="files"></tbody>
                                                  </table>
                                              </div>
                                            </div>
                                        </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
          </div>
          <?php
            include_once("../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
                    <strong class="error text-danger"></strong>
                    <input name="description[]" value="Logo Empresa" style="visibility: hidden;">
                    <input name="url_proc[]" value="<?php echo $adress;?>" style="visibility: hidden;" >
                    <input name="id_usuario[]" value="<?php echo $idusuario;?>" style="visibility: hidden;" >
                    <input name="tipo_foto[]" value="LogoEmpresa" style="visibility: hidden;" >
                    <input name="tipo_usuario[]" value="2" style="visibility: hidden;" >
                    <input name="id_publicacion[]" value="<?php echo $valor;?>" style="visibility: hidden;">
                    <input name="principal[]" value="1" style="visibility: hidden;">
                <br>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn blue start" disabled>
                        <i class="fa fa-save"></i>
                        <span>Confirmar</span>
                    </button>
                {% } %}

                {% if (!i) { %}
                    <button class="btn red cancel">
                        <i class="fa fa-trash"></i>
                        <span>Descartar</span>
                    </button>
                {% } %}
            </td>

        </tr>

        {% } %}
    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade" >
                <td>
                    <p>
                    <span>
                        {% if (file.url) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.url%}"></a>
                        {% } %}
                    </span>
                    </p>
                    {% if (file.error) { %}
                        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                    {% if (file.deleteUrl) { %}
                        <button class="btn red delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                            <i class="fa fa-trash"></i>
                            <span>Eliminar</span>
                        </button>
                        <input type="checkbox" style="visibility: hidden;" name="delete" value="1" class="toggle">
                    {% } else { %}
                        <button class="btn btn-warning cancel">
                            <i class="fa fa-trash"></i>
                            <span>Cancelar</span>
                        </button>
                    {% } %}
                </td>
            </tr>
        {% } %}
    </script>
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_foto.php");
    ?>
    <script type="text/javascript">
      $("#btnSave").click(function(){
        $('#btnSave').attr("disabled",true);
          swal({
            title: "CONFIRMACION",
            text: "Estas Seguri de Realizar los cambios?",
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
      });
    </script>
</body>

</html>