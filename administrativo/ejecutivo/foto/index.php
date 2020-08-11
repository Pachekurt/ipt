<?php
  $ruta="../../../";
  include_once($ruta."class/admejecutivo.php");
  $admejecutivo=new admejecutivo;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/admjerarquia.php");
  $admjerarquia=new admjerarquia;

  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $valor=dcUrl($lblcode);
  $idusuario=$_SESSION["codusuario"];
  //echo $valor;
  $deje=$admejecutivo->muestra($valor);
  $dper=$persona->muestra($deje['idpersona']);
  $dorg=$admorganizacion->muestra($deje['idorganizacion']);
  $personan= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
  $dcargo=$admjerarquia->muestra($deje['idcargo']);
  $adress=$_SERVER['REQUEST_URI'] ;
  $_SESSION["codempresa"]=$valor;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Registrar Ejecutivo";
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
          $idmenu=12;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="row">
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title">Registrar Foto</h5>
                  <ol class="breadcrumbs">
                    <li><a href="../editar/?lblcode=<?php echo $lblcode ?>"> Ejecutivo </a></li>
                    <li class="activoTab"><a href="../foto/?lblcode=<?php echo $lblcode ?>"> Foto</a></li>
                    <li><a href="../administrar/?lblcode=<?php echo $lblcode ?>"> Administrar</a></li>
                    <li><a href="../administrar/?lblcode=<?php echo $lblcode ?>"> Acciones</a></li>
                  </ol>
                </div>
                <div class="col s7 m7 l7">
                  <table class="csscontrato">
                    <thead>
                      <tr>
                        <th>Carnet</th>
                        <th>Nombre</th>
                        <th>Cargo</th>
                        <th>Organizacion</th>
                        <th>IMPRIMIR</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $dper['carnet']." ".$dper['expedido'] ?></td>
                        <td><?php echo $personan ?></td>
                        <td><?php echo $dcargo['nombre'] ?></td>
                        <td><?php echo $dorg['nombre'] ?></td>
                        <td><a href="../impresion/?lblcode=<?php echo $lblcode ?>" target="_blank" class="btn-jh green"> <i class="fa fa-print"></i> </a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
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
              <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
                    <strong class="error text-danger"></strong>
                    <input name="description[]" value="foto ejecutivo" style="visibility: hidden;">
                    <input name="url_proc[]" value="<?php echo $adress;?>" style="visibility: hidden;" >
                    <input name="id_usuario[]" value="<?php echo $idusuario;?>" style="visibility: hidden;" >
                    <input name="tipo_foto[]" value="foto" style="visibility: hidden;" >
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
          <?php
            include_once("../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <!-- The template to display files available for upload -->

    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_foto.php");
    ?>
    <script type="text/javascript">
    </script>
</body>

</html>