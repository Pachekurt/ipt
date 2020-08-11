<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admjerarquia.php");
  $admjerarquia=new admjerarquia;
  include_once($ruta."funciones/funciones.php");
  session_start();  
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
                      <li class="tab col s3"><a class="white-text waves-effect waves-light active" href="#persona">
                        BUSCAR Persona<i class="mdi-action-find-in-page small"></i></a>
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
                      <div class="row"> 
          <div class="divider">   </div>
                        <div id="valCarnet" class="col s12"></div>
                        <div class="input-field col s12">
                          <input id="idcarnet" name="idcarnet" type="text" class="validate">
                          <label for="idcarnet">INGRESE EL CARNET</label>
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


          $("#btnSavep").click(function(){
        $('#btnSavep').attr("disabled",true);
        $("#valCarnet").html("").slideUp(300);
        var nombreVal1 = $("#idnombre").val();
        var carnetVal1 = $("#idcarnet").val();
        if (nombreVal1 == '' || carnetVal1 == '') 
        {
          $("#valCarnet").html("<div id='card-alert' class=' red'><div class=' white-text'><p><i class='mdi-navigation-check'></i> Datos Faltantes. Carnet o Nombre</p></div> </div>").slideDown(500);
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