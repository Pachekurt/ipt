<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admjerarquia.php");
  $admjerarquia=new admjerarquia;
  include_once($ruta."funciones/funciones.php");
  session_start();  

   extract($_GET);

  $valor=dcUrl($lblcode);
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
                      <li class="tab col s3"><a class="white-text waves-effect waves-light active" href="#persona">REGISTRO Persona</a>
                      </li>
                     
                    </ul>
                  </div>
               
           <div class="col s12">
 <div class="col s12 m12 l1">
                      <p></p>
                    </div>
            <div id="persona" class="col s10  cyan lighten-4">
                 <form class="col s12" id="idformp" action="return false" onsubmit="return false" method="POST">
                <div class="col s12 m12 l12">
                
                    <div class="formcontent">  
                      <div class="row">DATOS PERSONA
          <div class="divider">   </div>
                        <div id="valCarnet" class="col s12"></div>
                        <div class="input-field col s8">
                          <input id="idcarnet" name="idcarnet" value="<?php echo $valor ?>"   type="text" class="validate">
                          <label for="idcarnet">CARNET</label>
                        </div>
                        <div class="input-field col s4">
                          <label>Expedido</label>
                          <select id="idexp" name="idexp">
                            <option disabled value="">Seleccionar Departamento</option>
                            <?php
                              foreach($dominio->mostrarTodo("tipo='DEP'") as $f)
                              {
                                ?>
                                  <option value="<?php echo $f['short']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s4">
                          <input id="idnombre" name="idnombre" type="text" class="validate">
                          <label for="idnombre">Nombre(s)</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="idpaterno" name="idpaterno" type="text" class="validate">
                          <label for="idpaterno">Paterno</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="idmaterno" name="idmaterno" type="text" class="validate active">
                          <label for="idmaterno">Materno</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="idnacimiento" name="idnacimiento" type="date" class="validate">
                          <label for="idnacimiento">Fecha Nacimiento</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="idemail" name="idemail" type="email" class="validate">
                          <label for="idemail">Email</label>
                        </div>  
                        <div class="input-field col s4">
                          <input id="idcelular" name="idcelular" type="text" class="validate">
                          <label for="idcelular">Celular(es)</label>
                        </div>
                        <div class="input-field col s4">
                          <label>Sexo</label>
                          <select id="idsexo" name="idsexo">
                              <option value="1">MASCULINO</option>
                              <option value="2">FEMENINO</option>
                          </select>
                        </div>
                        <div class="input-field col s8">
                          <input id="idocupacion" name="idocupacion" type="text" class="validate">
                          <label for="idocupacion">Ocupacion</label>
                        </div>                       
                      </div>
DATOS DOMICILIARIOS
          <div class="divider">   </div>
                          <div class="row">
                        <div class="input-field col s4">
                          <input id="idzona" name="idzona"  type="text" class="validate">
                          <label for="idzona">Zona</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="iddireccion" name="iddireccion" type="text" class="validate">
                          <label for="iddireccion">Direccion</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="idfono" name="idfono" type="text" class="validate">
                          <label for="idfono">telefono</label>
                        </div>
                         
                        
                         
                        <div class="input-field col s6">
                          <a id="btnLimpiarp" class="btn waves-effect waves-light orange"><i class="fa fa-save"></i> Limpiar</a>
                          <a id="btnSavep" class="btn waves-effect waves-light blue"><i class="fa fa-save"></i> Guardar y Siguiente</a>
                        </div> 
                    </div>
                </div>
              </form>

            </div>
           
          </div>
                  
             


            </div> 
          <?php
           // include_once("../footer.php");
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
        $('#btnSave').attr("disabled",true);
        if (validar()) {          
          swal({
            title: "CONFIRMACION",
            text: "Se registrara ejecutivo",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "Registrar",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idform" ).serialize();
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
           swal("DATOS FALTANTES");
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


          $("#btnSavep").click(function(){
        $('#btnSavep').attr("disabled",true);
        $("#valCarnet").html("").slideUp(300);
        var nombreVal1 = $("#idnombre").val();
        var carnetVal1 = $("#idcarnet").val();
        if (nombreVal1 == '' || carnetVal1 == '') 
        {
           swal("DATOS FALTANTES,");
        }else {
          swal({
            title: "CONFIRMACION",
            text: "Se guardara la persona",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "GUARDAR",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idformp" ).serialize();
           // alert(str);
            $.ajax({
              url: "guardarp.php",
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