<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admjerarquia.php");
  $admjerarquia=new admjerarquia;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;

  include_once($ruta."class/domicilio.php");
  $domicilio=new domicilio;
  include_once($ruta."funciones/funciones.php");
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;

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
  $deje=$vejecutivo->mostrarFull("idpersona = $valor and activo=1");
  $deje=array_shift($deje);

  $ddom = $domicilio->mostrarTodo("idpersona = $valor"); 
  $ddom = array_shift($ddom);

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
                    <ul class="tabs tab-demo-active z-depth-1 green">
                      <li class="tab col s3"><a class="white-text waves-effect waves-light active" href="#primera">PERSONAL  REGISTRADO</a>
                      </li>
                       
                     
                    </ul>
                  </div> 
                <div class="col s12">
                   <div class="col s12 m12 l1">
                      <p></p>
                    </div>
                  <div id="primera" class="col s10  green lighten-4">
                       <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <input id="idpersona" name="idpersona" value="<?php echo $valor ?>" type="hidden" class="validate">
                <div class="col s12 m12 l12">
                     
                    
                          
                    <div class="formcontent" >  
                      <div class="row">   
               <a class="label tooltipped  offset-s4 l2 offset-l1" data-position="right" data-delay="50" data-tooltip="Editar Datos Persona" href="../persona/editar/?lblcode=<?php echo $lblcode; ?>"> DATOS PERSONA <i class="mdi-editor-border-color"></i></a>

                        <div id="valCarnet" class="col s12"></div>
                        <div class="input-field col s2">
                          <input id="CC" name="CC" type="text" readonly="" value="<?php echo $deje['carnet'] ?>" >
                          <label for="idcarnet">CARNET</label>
                        </div>
                        <div class="input-field col s2">
                          <label>Expedido</label>
                          <select id="idexp" name="idexp" disabled="">
                            <option disabled value="">Seleccionar Departamento</option>
                            <?php
                              foreach($dominio->mostrarTodo("tipo='DEP'") as $f)
                              {
                                $sw="";
                                if ($deje['expedido']==$f['short']) {
                                   $sw="selected";
                                }
                                ?>
                                  <option <?php echo $sw ?> value="<?php echo $f['short']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s2">
                          <input id="idnombre" name="idnombre" readonly="" value="<?php echo $deje['nombre'] ?>" type="text" >
                          <label for="idnombre">Nombre(s)</label>
                        </div>
                        <div class="input-field col s2">
                         <input id="idpaterno" name="idpaterno" readonly=""  value="<?php echo $deje['paterno'] ?>" type="text" >
                          <label for="idpaterno">Paterno</label>
                        </div>
                        <div class="input-field col s2">
                          <input id="idmaterno" name="idmaterno" readonly="" value="<?php echo $deje['materno'] ?>" type="text"  >
                          <label for="idmaterno">Materno</label>
                        </div>
                        <div class="input-field col s2">
                          <input id="idnacimiento" name="idnacimiento" readonly=""  value="<?php echo $deje['nacimiento'] ?>" type="date" >
                          <label for="idnacimiento">Fecha Nacimiento</label>
                        </div>
                        <div class="input-field col s3"> 
                          <input id="idemail" name="idemail" readonly=""  value="<?php echo $dper['email'] ?>" type="email" >
                          <label for="idemail">Email</label>
                        </div>  
                        <div class="input-field col s3">
                          <input id="idcelular" name="idcelular" readonly=""  value="<?php echo $dper['celular'] ?>" type="text" >
                          <label for="idcelular">Celular(es)</label>
                        </div>
                        <div class="input-field col s2">
                          <label>Sexo</label>
                          <select id="idsexo" name="idsexo" disabled="">
                              <?php
                              foreach($dominio->mostrarTodo("tipo='SX'") as $f)
                              {
                                $sw="";
                                if ($deje['idsexo']==$f['iddominio']) {
                                   $sw="selected";
                                }
                                ?>
                                  <option <?php echo $sw ?> value="<?php echo $f['iddominio']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s4">
                          <input id="idocupacion" name="idocupacion"  readonly="" value="<?php echo $deje['ocupacion'] ?>" type="text" >
                          <label for="idocupacion">Ocupacion</label>
                        </div>                       
                      </div>  
                        
             
                        <div id="valCarnet" class="col s3"> 
                          <a class="label  offset-s4 l2 offset-l1"   > DATOS FILIACION  </a>
                            </div>
                 
                            <div id="valCarnet" class="col s9">
                          <a class="label tooltipped  offset-s4 l2 offset-l1" data-position="right" data-delay="50" data-tooltip="Ver Historial" href="../nuevo/?lblcode=<?php echo $lblcode; ?>">    HISTORIAL <i class="mdi-image-remove-red-eye"></i></a>
                        </div>
                 


                        
                        <div class="input-field col s4">
                          <label>Area Perteneciente</label>
                            <input id="idarea" name="idarea"  readonly="" value="<?php echo $deje['narea'] ?>" type="text" >
                        </div>
                        <div class="input-field col s4">
                          <label>Organización/Dpto</label>
                          <input id="idarea" name="idarea"  readonly="" value="<?php echo $deje['norganizacion'] ?>" type="text" >
                        </div>
                        <div class="input-field col s4">
                          <label>Cargo</label>
                         <input id="idarea" name="idarea"  readonly="" value="<?php echo $deje['njerarquia'] ?>" type="text" >
                        </div>
                        <div class="input-field col s4">
                          <label>Tipo Ejecutivo</label>
                         <input id="idarea" name="idarea"  readonly="" value="<?php echo $deje['ntipo'] ?>" type="text" >
                        </div>
                        <div class="input-field col s4">
                         
                          <label for="idfechaingreso">Fecha Ingreso</label>
                          <input id="idarea" name="idarea"  readonly="" value="<?php echo $deje['fechaingreso'] ?>" type="text" >
                        </div>
                     
                  
                        <div class="input-field col s4">
                         
                          <label for="idobs">Detalle u Observaciones</label>
                          <input id="idarea" name="idarea"  readonly="" value="<?php echo $deje['obser'] ?>" type="text" >
                        </div> 


 <div id="valCarnet" class="col s12"> 
                          <a class="label  offset-s4 l2 offset-l1"   > NUEVA ORGANIZACION  </a>
                            </div>

                           
                        <div class="input-field col s8">
                          <label>Organización/Dpto</label>
                           <select id="tipoeje" <?php echo $read ?> name="tipoeje">
                            <?php
                              foreach($admorganizacion->mostrarTodo("tipo='121'") as $f)
                              {
                                ?>
                                  <option value="<?php echo $f['iddominio']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s4">
                         <button onclick="tranferir('<?php echo $lblcode ?>','1');" class="btn-jh darken-4 green"  ><i class="mdi-action-thumb-up"></i>TRANSFERIR</button></div>
                        

                        <div class="row">
                           
                           
                        </div>             
                   
                    </div>
                </div>
              </form>
 
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
            data: "carnet="+carnet+"&lblcontrato=<?php echo $idcontrato ?>",
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
</body>

</html>
