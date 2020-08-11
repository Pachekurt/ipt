<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/files.php");
  $files=new files;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admjerarquia.php");
  $admjerarquia=new admjerarquia;
  include_once($ruta."class/domicilio.php");
  $domicilio=new domicilio;
  include_once($ruta."funciones/funciones.php");
  include_once($ruta."class/persona.php");
  $persona=new persona;

  session_start();
   extract($_GET);
  $valor=dcUrl($lblcode);
  $_SESSION["codempresa"]=$valor;
  $dper=$persona->muestra($valor);
  $ddom = $domicilio->mostrarTodo("idpersona = '$valor'"); 
  $ddom = array_shift($ddom);
  /******** foto ***********/
$dfoto=$files->mostrarTodo("id_publicacion=".$valor." and tipo_foto='foto'");
$dfoto=array_shift($dfoto);
if (count($dfoto)>0) {
    $rutaFoto=$ruta."persona/editar/server/php/".$valor."/".$dfoto['name'];
}
else{
    $rutaFoto=$ruta."imagenes/user.png";
}
    /******** foto ***********/
     
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Registrar Titular";
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
          $idmenu=11;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
           
           <div class="row section">
                    <div class="col s12 m12 l1">
                      <p></p>
                    </div>
                    <div class="col s10">
                    <ul class="tabs tab-demo-active z-depth-1 cyan">
                      <li class="tab col s3"><a class="white-text waves-effect waves-light active" href="#primera">DATOS PERSONA</a>
                      </li>
                       
                     
                    </ul>
                  </div> 
                <div class="col s12">
                   <div class="col s12 m12 l1">
                      <p></p>
                    </div>
                  <div id="primera" class="col s10  cyan lighten-5">
<form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
    <input id="idpersona" name="idpersona" value="<?php echo $valor ?>" type="hidden" class="validate">
        <div class="col s12 m12 l12">
                   
                      
 <div class="col s12">.</div>
              <div class="row">
                           
                  <a class="label tooltipped  offset-s4 l2 offset-l1" data-position="right" data-delay="50" data-tooltip="Editar Datos" href="../editar/?lblcode=<?php echo $lblcode; ?>">DATOS PERSONA <i class="mdi-editor-border-color"></i></a> 
                  <div class="col s12">

                            <div class="col s10">

                                                <div id="valCarnet" class="col s12"></div>
                                                <div class="input-field col s2">
                                                  <input id="CC" name="CC" type="text" readonly="" value="<?php echo $dper['carnet'] ?>" >
                                                  <label for="idcarnet">CARNET</label>
                                                </div>
                                                <div class="input-field col s1">
                                                  <label>Exp.</label>
                                                  <select id="idexp" name="idexp" disabled="">
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
                                                <div class="input-field col s3">
                                                  <input id="idnombre" name="idnombre" readonly="" value="<?php echo $dper['nombre'] ?>" type="text" >
                                                  <label for="idnombre">Nombre(s)</label>
                                                </div>
                                                <div class="input-field col s3">
                                                 <input id="idpaterno" name="idpaterno" readonly=""  value="<?php echo $dper['paterno'] ?>" type="text" >
                                                  <label for="idpaterno">Paterno</label>
                                                </div>
                                                <div class="input-field col s3">
                                                  <input id="idmaterno" name="idmaterno" readonly="" value="<?php echo $dper['materno'] ?>" type="text"  >
                                                  <label for="idmaterno">Materno</label>
                                                </div>
                                            
                                                <div class="input-field col s4"> 
                                                  <input id="idemail" name="idemail" readonly=""  value="<?php echo $dper['email'] ?>" type="email" >
                                                  <label for="idemail">Email</label>
                                                </div>  
                                                <div class="input-field col s4">
                                                  <input id="idcelular" name="idcelular" readonly=""  value="<?php echo $dper['celular'] ?>" type="text" >
                                                  <label for="idcelular">Celular(es)</label>
                                                </div>
                                              
                                                <div class="input-field col s4">
                                                  <input id="idocupacion" name="idocupacion"  readonly="" value="<?php echo $dper['ocupacion'] ?>" type="text" >
                                                <label for="idocupacion">Ocupacion</label>
                                                </div>  
                                               <div class="input-field col s4">
                                                <input id="iddom" name="iddom" type="hidden" readonly value="<?php echo $ddom['iddomicilio']; ?>">
                                                <input id="idper" name="idper" type="hidden" readonly value="<?php echo $dper['idpersona']; ?>">
                                                <input id="idzona" name="idzona"  readonly=""  type="text" value="<?php echo $ddom['idbarrio'] ?>" class="validate">
                                                <label for="idzona">Zona</label>
                                              </div>
                                              <div class="input-field col s5">
                                                <input id="iddireccion"  readonly=""  name="iddireccion" type="text"  value="<?php echo $ddom['nombre'] ?>" class="validate">
                                                <label for="iddireccion">Direccion</label>
                                              </div>
                                              <div class="input-field col s3">
                                                <input id="idfono" name="idfono" readonly=""  type="text"  value="<?php echo $ddom['telefono'] ?>" class="validate">
                                                <label for="idfono">telefono</label>
                                              </div>

                                     </div>  
                                <div class="col s2"> 
                                   <a class="modal-trigger" style="height: 100px" href="#modal4"><img src="<?php echo $rutaFoto ?>"  width="100" > <br>
                                   AGREGAR FOTO </a>
                              </div> 
 <div class="col s12">.</div>
                    <div class="col s8 offset-s4 ">
                      <button id="btnSave" class="btn waves-effect waves-light blue btn-large" >CONFIRMAR DATOS Y CONTINUAR ASIGNACION   <i class="mdi-social-person-add"></i></button>
                      
                    </div>

                          </div> 

                     </div>
          <div class="divider">   </div>
                 
                </div>
              </form> 
                  </div> 
                         <div id="modal4" class="modal modal-fixed-footer cyan white-text">
            <div class="modal-content">
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
                                                <div class="col s12 m12 l12">
                                                  <span class="btn darken-4 green fileinput-button">
                                                    <i class="fa fa-folder-open-o"></i>
                                                    <span>Seleccionar Imagenes</span>
                                                    <input multiple="true" type="file" name="files[]" >
                                                  </span>
                                                  <button type="submit" class="btn orange darken-3 start">
                                                    <i class="fa fa-check"></i>
                                                    <span>Empezar</span>
                                                  </button>
                                                  <span class="fileupload-process"></span>
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
           <div class="modal-footer"> 
                <a href="javascript:location.reload()" class="waves-effect waves-green btn-flat modal-action modal-close">Cerrar</a>
              </div>
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
    <?php
      include_once($ruta."includes/script_basico.php");
    ?>
    <script type="text/javascript">
      $("#idcarnet").blur(function(){
        carnet=$('#idcarnet').val();
        if (carnet!="") {
          $.ajax({
            url: "verificarCI.php",
            type: "POST",
            data: "carnet="+carnet,
            success: function(resp){
              console.log(resp);
              $('#valCarnet').html(resp).slideDown(500);
            }
          });
        }
      });
  $("#btnSave").click(function(){ 
      location.href="../../administrativo/ejecutivo/nuevo?lblcode=<?php echo $lblcode; ?>";
          
      });


    
       $("#idarea").change(function() {
        var idarea=$("#idarea").val();
        $("#idorg").empty().html(' ');
        /*************************   ORGANIZACION  *********************************************************/
        $.post("cargaOrganizacion.php",{"idarea":idarea},function(ejecutivos){  
          console.log(ejecutivos);   
          var cmdejec=$("#idorg");
            cmdejec.empty();
            $.each(ejecutivos,function(idejecutivo,ejec){
              $("#idorg").append( $("<option></option>").attr("value",ejec.idejecutivo).text(ejec.nombre));
          //$("#idsedex").val(ejec.sede);
            });
            $("#idorg").material_select('update');
            $("#idorg").closest('.input-field').children('span.caret').remove();
        },'json');
        /*********   CARGO JERARQUIA  **********************************************************************/
        $("#idcargo").empty().html(' ');
        $.post("cargaJerarquia.php",{"idarea":idarea},function(ejecutivos){  
          console.log(ejecutivos);
          var cmdejec=$("#idcargo");
            cmdejec.empty();
            $.each(ejecutivos,function(id,ejec){
              $("#idcargo").append( $("<option></option>").attr("value",ejec.id).text(ejec.nombre));
            });
            $("#idcargo").material_select('update');
            $("#idcargo").closest('.input-field').children('span.caret').remove();
        },'json');
      });
    </script>
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
                             <a href="{%=file.url%}" target="_blank" title="{%=file.name%}" data-gallery>
                                <img class="col s12 m12 l8" src="{%=file.url%}">
                            </a>
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
      include_once($ruta."includes/script_foto.php");
    ?>
</body>

</html>
