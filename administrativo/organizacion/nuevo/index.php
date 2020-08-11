<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/rol.php");
  $rol=new rol;
  include_once($ruta."class/departamento.php");
  $departamento=new departamento;
  session_start();  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Habilitar Contratos";
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
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">


                <div class="col s12 m12 l1"> 
                          <label>.</label>
                </div>
                <div class="col s12 m12 l10">
                  <a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>
                  
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                  <h4 class="header">Ingrese los datos</h4>
                 <div id="input-fields"> 
              <div class="row">
                 
                <div class="col s12 m12 l12">
                  <div class="row">
                    
                        <div class="input-field col s6">
                          <input  id="carnet" type="number" class="validate">
                          <label for="carnet">Carnet</label>
                        </div>
                        <div class="input-field col s6">
                        
                          <select class=" " name="expedido" id="idexpedido"> 
                   
                            <?php
                              foreach($departamento->mostrarTodo() as $f)
                              {
                            ?>
                              <option value="<?php echo $f['codigo'];  ?>" ><?php echo $f['nombre'];  ?></option>
                            <?php
                              }
                            ?>
                          </select> 
                        </div>
                      </div> 

                     <div class="row">
                        <div class="input-field col s4">
                          <input id="txtnombre" type="text" class="validate">
                          <label for="txtnombre">Nombres</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="txt_paterno" type="text" class="validate">
                          <label for="txt_paterno">Paterno</label>
                        </div>  
                        <div class="input-field col s4">
                          <input id="txt_materno" type="text" class="validate">
                          <label for="txt_materno">Materno</label>
                        </div>
                       
            <div class="divider"></div>
                    </div>
                </div>
              </div>
            </div>

            <div class="divider"></div>
                  </form>
                </div>
                <div class="col s12 m12 l1"> 
                          <label>.</label>
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
      $("#btnSave").click(function(){        
        if (validar()) {        
          $('#btnSave').attr("disabled",true);
          var str = $( "#idform" ).serialize();
          $.ajax({
            url: "guardar.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
        }
      });
      function validar(){
        retorno=true
        inicial=$("#idInicial").val();
        if (inicial=="") {
          retorno=false;
          Materialize.toast('<span>Numero Contrato Inicial Requerido</span>', 1500);
        }
        final=$("#idFinal").val();
        if (final=="") {
          retorno=false;
          Materialize.toast('<span>Numero de Contrato Final Requerido</span>', 1500);
        }
        if (parseInt(final)<parseInt(inicial)) {
          retorno=false;
          Materialize.toast('<span>El numero de contrato final no puede ser menor al inicial</span>', 1500);
        }
        return retorno;
      }
    </script>
</body>

</html>