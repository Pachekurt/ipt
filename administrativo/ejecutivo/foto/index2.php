<?php 
$ruta="../../../../";
$folder="";
include_once($ruta."class/dominio.php");
$dominio=new dominio;
include_once($ruta."class/miempresa.php");
$miempresa=new miempresa;
include_once($ruta."funciones/funciones.php");
/******************    SEGURIDAD *************/
session_start();
if (!isset($_SESSION["bool"])) {
if ($_SESSION["tipoSession"]!=1) header("Location: ".$ruta);
}
elseif ($_SESSION["tipoSession"]!=1) {
if (!isset($_SESSION["faltaSistema"]))
{  $_SESSION['faltaSistema']="0"; }
$_SESSION['faltaSistema']=$_SESSION['faltaSistema']+1;  
header("Location: ".$ruta);
}
/********************************************/
extract($_GET);
$valor=dcUrl($lblcode);
//echo $valor;
$_SESSION["codempresa"]=$valor;
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
$adress=$_SERVER['REQUEST_URI'] ;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $ruta; ?>imagenes/favicon.ico" />
    <title>LOGO DE EMPRESA | FACTURA +</title>

    <link href="<?php echo $ruta; ?>recursos/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $ruta; ?>recursos/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="<?php echo $ruta; ?>recursos/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <!-- Gritter -->
    <link href="<?php echo $ruta; ?>recursos/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="<?php echo $ruta; ?>recursos/css/animate.css" rel="stylesheet">
    <link href="<?php echo $ruta; ?>recursos/css/style.css" rel="stylesheet">

    <link href="<?php echo $ruta; ?>recursos/css/template.css" rel="stylesheet">
    <link href="<?php echo $ruta; ?>recursos/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="<?php echo $ruta; ?>recursos/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="<?php echo $ruta; ?>recursos/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    

<link rel="stylesheet" href="<?php echo $ruta;?>recursos/plugins/foto/Gallery/css/blueimp-gallery.min.css">
<link rel="stylesheet" href="<?php echo $ruta;?>recursos/plugins/foto/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo $ruta;?>recursos/plugins/foto/css/jquery.fileupload-ui.css">
<noscript><link rel="stylesheet" href="<?php echo $ruta;?>recursos/plugins/foto/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?php echo $ruta;?>recursos/plugins/foto/css/jquery.fileupload-ui-noscript.css"></noscript>

</head>

<body>
    <div id="wrapper">
      <?php
        $tab=3;
        include_once("../../../aside.php");
      ?>
      <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php
           include_once("../../../head.php");
        ?>
        <div class="row  border-bottom white-bg dashboard-header">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i> ESTABLECER LOGO DE LA EMPRESA</h3>               
            </div>                            
        
            <div class="row">
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
                                          <a href="../" class="btn btn-warning" ><i class="fa fa-mail-reply"></i> Volver</a>
                                          <a href="../" class="btn btn-info" ><i class="fa fa-file-pdf-o"></i> Previsualizar en factura</a>
                                            <span class="btn btn-primary fileinput-button">
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
        <div id="idresultado"></div>
        <?php
            $tab=0;
            include_once("../../../footer.php");
        ?>
      </div>
    </div>
    <!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
                    <strong class="error text-danger"></strong>
                    <input name="description[]" value="foto perfil" hidden>
                    <input name="url_proc[]" value=<?php echo $adress;?> hidden >
                    <input name="id_usuario[]" value=<?php echo $valor;?> style="visibility: hidden;" >
                    <input name="tipo_foto[]" value="logo" hidden >
                    <input name="tipo_usuario[]" value="1" hidden >
                    <input name="id_publicacion[]" value="<?php echo $valor;?>" hidden>
                    <input name="principal[]" value="1" hidden>
                <br>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-primary start" disabled>
                        <i class="fa fa-save"></i>
                        <span>Confirmar</span>
                    </button>
                {% } %}

                {% if (!i) { %}
                    <button class="btn btn-warning cancel">
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
                        <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
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
     <script src="<?php echo $ruta; ?>recursos/js/jquery-2.1.1.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/bootstrap.min.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Flot -->
    <script src="<?php echo $ruta; ?>recursos/js/plugins/flot/jquery.flot.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/jquery.numeric.js"></script>

    <!-- Peity -->
    <script src="<?php echo $ruta; ?>recursos/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo $ruta; ?>recursos/js/inspinia.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="<?php echo $ruta; ?>recursos/js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/gritter/jquery.gritter.min.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/demo/sparkline-demo.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/chartJs/Chart.min.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/toastr/toastr.min.js"></script>
    
    <!-- Data Tables -->
    <script src="<?php echo $ruta; ?>recursos/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/dataTables/dataTables.tableTools.min.js"></script>
    
    <script src="<?php echo $ruta; ?>recursos/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/switchery/switchery.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/iCheck/icheck.min.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/cropper/cropper.min.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/iCheck/icheck.min.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>



<script src="<?php echo $ruta;?>recursos/plugins/foto/js/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo $ruta;?>recursos/plugins/foto/JavaScript-Templates/js/tmpl.min.js"></script>
<script src="<?php echo $ruta;?>recursos/plugins/foto/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="<?php echo $ruta;?>recursos/plugins/foto/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="<?php echo $ruta;?>recursos/plugins/foto/js/jquery.iframe-transport.js"></script>
<script src="<?php echo $ruta;?>recursos/plugins/foto/js/jquery.fileupload.js"></script>
<script src="<?php echo $ruta;?>recursos/plugins/foto/js/jquery.fileupload-process.js"></script>
<script src="<?php echo $ruta;?>recursos/plugins/foto/js/jquery.fileupload-image.js"></script>
<script src="<?php echo $ruta;?>recursos/plugins/foto/js/jquery.fileupload-validate.js"></script>
<script src="<?php echo $ruta;?>recursos/plugins/foto/js/jquery.fileupload-ui.js"></script>
<script src="<?php echo $ruta;?>recursos/plugins/foto/js/main.js"></script>

</body>
</html>
