<?php
  $ruta="../../../";
  session_start();
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/titular.php");
  $titular=new titular;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Cambio de Ejecutivo";
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
          $idmenu=84;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
                <div class="col s7 m7 l7">
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">

                    <input id="idcontrato" name="idcontrato" type="hidden" value="0" readonly class="validate">
                    <h4 class="header"> Ingrese los datos</h4>
                    <div class="formcontent">
                      <div class="row">
                        <div class="input-field col s4">
                          <input id="idnro" name="idnro" type="number" class="validate">
                          <label for="idnro">Ingrese Numero de Contrato</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="ideje" name="ideje" type="text" readonly="" class="validate">
                          <label for="ideje">Ejecutivo</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="idestado" name="idestado" type="text" readonly="" class="validate">
                          <label for="idestado">Estado</label>
                        </div>
                        <div class="input-field col s8">
                          <label>Accion</label>
                          <select id="idejec" name="idejec">
                            <?php
                              foreach($vejecutivo->mostrarTodo("estado=1 and idarea=121") as $f)
                              {
                                ?>
                                <option value="<?php echo $f['idvejecutivo']; ?>"><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno']." : ".$f['njerarquia'] ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        
                        <div class="input-field col s8">
                          <textarea id="iddesc" name="iddesc" class="materialize-textarea"></textarea>
                          <label for="iddesc">Descripcion</label>
                        </div>
                        <div class="input-field col s4">
                          <a id="btnSave" readon class="btn waves-effect waves-light indigo"><i class="fa fa-save"></i> Registrar Cambio</a>
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
      $( "#idnro" ).blur(function() {
        cargar();
      });
      $("#btnSave").click(function(){
        guardar();
      });
      function cargar(){
        nrocontrato=$("#idnro").val();
        $.ajax({
          async: true,
          url: "cargar.php?nrocontrato="+nrocontrato,
          type: "get",
          dataType: "html",
          success: function(data){
            console.log(data);
            var json = eval("("+data+")");
            $("#idcontrato").val(json.idcontrato);
            $("#ideje").val(json.ejecutivo);
            $("#idestado").val(json.estado);
          }
        });
      }
      function guardar(){
        swal({   
          title: "Estas Seguro?",   
          text: "Esta Seguro de cambiar de ejecutivo?",   
          type: "warning",   
          showCancelButton: true,   
          closeOnConfirm: false,   
          showLoaderOnConfirm: true,
        }, 
        function(){
          if (validar()) {
            idejecutivo=$('select[id=idejec]').val();
            nrocontrato=$("#idnro").val();
            iddesc=$("#iddesc").val();
            var str="idejecutivo="+idejecutivo+"&nrocontrato="+nrocontrato+"&iddesc="+iddesc;
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
        });
      }
      function validar(){
        retorno=true;
        /*
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
        }*/
        return retorno;
      }
    </script>
</body>

</html>