<?php
  $ruta="../../../";
 include_once($ruta."class/invcategoria.php");
  $invcategoria=new invcategoria;
  include_once($ruta."class/invitem.php");
  $invitem=new invitem;
  include_once($ruta."class/modulo.php");
  $modulo=new modulo;
   include_once($ruta."class/horario.php");
  $horario=new horario;
  session_start(); 
  extract($_GET);
  $valor=dcUrl($lblcode);

  $ditem=$invcategoria->muestra($valor);



  $idusuario=$_SESSION["codusuario"];
  $adress=$_SERVER['REQUEST_URI'] ;
  $_SESSION["codempresa"]=$valor;


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="EDITAR CATEGORIA";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
      include_once($ruta."includes/head_foto.php");
    ?>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=91;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <a href="../" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>    
                </div>
              </div>   
            </div>
          </div>
          <div class="container">
              <div class="row">
                <div class="col s6 m6">
                 <!-- <h4 class="header">Actualizar Curso</h4> -->
                  <div class="titulo">Datos de la categoria</div>
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo"> <i class="fa fa-save"></i> Guardar Cambios </button>
                  <form class="col s12" id="idform" name="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="iditem" id="iditem" value="<?php echo $valor; ?>">
                    <div class="row">
                      <div class="row">
                        <div class="input-field col col s12 m12">
                          <input id="idnombre" name="idnombre" type="text" value="<?php echo $ditem['nombre'] ?>" class="validate">
                          <label for="idnombre">Nombre</label>
                        </div>
                        <div class="input-field col s12">
                          <textarea id="iddesc" name="iddesc" class="materialize-textarea"><?php echo $ditem['descripcion'] ?></textarea>
                          <label for="iddesc">Descripcion</label>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col s6 m6">
                  <div class="titulo">Establecer foto</div>
                  <div class="container">
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
                                                    <span>Seleccionar Imagen</span>
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
          </div>
          <?php
            //include_once("../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
                    <strong class="error text-danger"></strong>
                    <input name="description[]" value="foto de item" style="visibility: hidden;">
                    <input name="url_proc[]" value="<?php echo $adress;?>" style="visibility: hidden;" >
                    <input name="id_usuario[]" value="<?php echo $idusuario;?>" style="visibility: hidden;" >
                    <input name="tipo_foto[]" value="fotoItemInventarios" style="visibility: hidden;" >
                    <input name="tipo_usuario[]" value="1" style="visibility: hidden;" >
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
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_foto.php");
    ?>
    <script type="text/javascript">
      $("#btnSave").click(function(){
        swal({   
          title: "Estas Seguro?",   
          text: "Esta seguro de guardar cambios?",   
          type: "warning",   
          showCancelButton: true,   
          closeOnConfirm: false,   
          showLoaderOnConfirm: true,
        }, 
        function(){
          if (validarr()) {
            var str = $( "#idform" ).serialize();
            $.ajax({
              url: "guardar.php",
              type: "POST",
              data: str,
              success: function(resp){
                setTimeout(function(){     
                  console.log(resp);
                  $('#idresultado').html(resp);
                }, 1000); 
              }
            });
          }
          else{
            Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
          }
        });
      });
      function validarr(){
        retorno=true;
        nombre=$('#idnombre').val();
        precio=$('#idprecio').val();
        if(nombre=="" || precio=="0"){
          retorno=false;
        }
        return retorno;
      }
    </script>
</body>

</html>