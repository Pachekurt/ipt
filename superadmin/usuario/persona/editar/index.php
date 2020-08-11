<?php
  $ruta="../../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
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
  $ddom = $domicilio->mostrarTodo("idpersona = $valor"); 
  $ddom = array_shift($ddom);

  $_SESSION["codempresa"]=$valor;
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
                      <li class="tab col s3"><a class="white-text waves-effect waves-light active" href="#primera">Persona</a>
                      </li>
                     
                    </ul>
                  </div> 
                <div class="col s12">
                   <div class="col s12 m12 l1">
                      <p></p>
                    </div>
                  <div id="primera" class="col s10  cyan lighten-4">
                     <form class="col s12" id="idformp" action="return false" onsubmit="return false" method="POST">
                <div class="col s12 m12 l12">
                
                    <div class="formcontent">  
                      <div class="row">DATOS PERSONA
          <div class="divider">   </div>
                        <div id="valCarnet" class="col s12"></div>
                        <div class="input-field col s8">
                          <input id="idcarnet" name="idcarnet" type="text" readonly="" value="<?php echo $dper['carnet'] ?>" class="validate">
                          <label for="idcarnet">CARNET</label>
                        </div>
                        <div class="input-field col s4">
                          <label>Expedido</label>
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
                        <div class="input-field col s4">
                          <input id="idnombre" name="idnombre" value="<?php echo $dper['nombre'] ?>" type="text" class="validate">
                          <label for="idnombre">Nombre(s)</label>
                        </div>
                        <div class="input-field col s4">
                         <input id="idpaterno" name="idpaterno" value="<?php echo $dper['paterno'] ?>" type="text" class="validate">
                          <label for="idpaterno">Paterno</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="idmaterno" name="idmaterno" value="<?php echo $dper['materno'] ?>" type="text" class="validate active">
                          <label for="idmaterno">Materno</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="idnacimiento" name="idnacimiento" value="<?php echo $dper['nacimiento'] ?>" type="date" class="validate">
                          <label for="idnacimiento">Fecha Nacimiento</label>
                        </div>
                        <div class="input-field col s4"> 
                          <input id="idemail" name="idemail" value="<?php echo $dper['email'] ?>" type="email" class="validate">
                          <label for="idemail">Email</label>
                        </div>  
                        <div class="input-field col s4">
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
DATOS DOMICILIARIOS
          <div class="divider">   </div>
                          <div class="row">
                        <div class="input-field col s4">
                          <input id="iddom" name="iddom" type="hidden" readonly value="<?php echo $ddom['iddomicilio']; ?>">
                          <input id="idper" name="idper" type="hidden" readonly value="<?php echo $dper['idpersona']; ?>">
                          <input id="idzona" name="idzona"  type="text" value="<?php echo $ddom['idbarrio'] ?>" class="validate">
                          <label for="idzona">Zona</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="iddireccion" name="iddireccion" type="text"  value="<?php echo $ddom['nombre'] ?>" class="validate">
                          <label for="iddireccion">Direccion</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="idfono" name="idfono" type="text"  value="<?php echo $ddom['telefono'] ?>" class="validate">
                          <label for="idfono">telefono</label>
                        </div>
                         
                        
                         
                        <div class="input-field col s8">
                          <a id="btnLimpiarp" class="btn waves-effect waves-light orange"><i class="fa fa-save"></i> Limpiar</a>
                          <a class="waves-effect waves-light btn modal-trigger  cyan" href="#modal4">agregar foto  </a>
                          <a id="btnSavep" class="btn waves-effect waves-light blue"><i class="fa fa-save"></i> CONFIRMAR y Siguiente</a>
                           
                        </div> 


            </p>
                  </div>
   
                    </div>
                </div>
              </form>

                  </div>
                   
                      
                 
                </div>
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
                <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Cerrar</a>
              </div>
            </div>
          <?php
            include_once("../../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
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
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_foto.php");
    ?>

    <script type="text/javascript">
      $("#idcarnet").blur(function(){
        carnet=$('#idcarnet').val();
        if (carnet!="") {
          $.ajax({
            url: "verificarCI.php",
            type: "POST",
            data: "carnet="+carnet+"&lblcontrato=<?php echo $idcontrato ?>",
            success: function(resp){
              console.log(resp);
              $('#valCarnet').html(resp).slideDown(500);
            }
          });
        }
      });
      $("#btnSavep").click(function(){
        $('#btnSavep').attr("disabled",true);
        if (validar()) {          
          swal({
            title: "CONFIRMACION",
            text: "Se registraran los datos",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "Registrar",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idformp" ).serialize();
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
        else{
          Materialize.toast('<span>Datos incorrectos o faltantes</span>', 1500);
        }
      });
      function validar(){
        retorno=true;
        carnet=$('#idcarnet').val();
        if(carnet==""){
          retorno=false;
        }
        return retorno;
      }
      $("#idarea").change(function() {
        var idarea=$("#idarea").val();
        $("#idorg").empty().html(' ');
        $.post("cargaOrganizacion.php",{"idarea":idarea},function(ejecutivos){  
          console.log(ejecutivos);   
          var cmdejec=$("#idorg");
            cmdejec.empty();
            $.each(ejecutivos,function(idejecutivo,ejec){
              $("#idorg").append( $("<option></option>").attr("value",ejec.idejecutivo).text(ejec.nombre));
            });
            $("#idorg").material_select('update');
            $("#idorg").closest('.input-field').children('span.caret').remove();
        },'json');
      });
    </script>

</body>

</html>