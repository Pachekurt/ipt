<?php
  session_start();
  $ruta="../../../";
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admcontratogen.php");
  $admcontratogen=new admcontratogen;
  include_once($ruta."funciones/funciones.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Administrar Habilitaciones";
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_tabla.php");
  ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wradmorganizacionapper">
        <?php
          $idmenu=14;
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
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <a href="#modal1" class="btn waves-effect darken-4 green modal-trigger"><i class="fa fa-plus-square"></i> Habilitar Contratos</a>
              <div id="modal1" class="modal">
                <div class="modal-content">
                <h1>Habilitar Contratos</h1>
                   <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                      <div class="row">
                        <div class="input-field col s12">
                          <label>Seleccionar Sede</label>
                          <select onchange="cargaDato(this);" id="idsede" name="idsede">
                            <option value="0">Seleccionar...</option>
                            <?php
                            foreach($sede->mostrarTodo("") as $f)
                            {
                            ?>
                            <option value="<?php echo $f['idsede'] ?>"><?php echo $f['nombre'] ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12">
                          <input id="idInicial" name="idInicial" type="number"  class="validate">
                          <label for="idInicial">Numero Inicial</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idFinal" name="idFinal" type="number" class="validate">
                          <label for="idFinal">Numero Final</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idobs" name="idobs" type="text" class="validate">
                          <label for="idobs">Detalle</label>
                        </div>
                      </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <a href="#" class="btn waves-effect waves-light light-blue darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</a>
                  <button id="btnSave" class="btn waves-effect waves-light indigo"><i class="fa fa-save"></i> Habilitar Contratos</button>
                </div>
              </div>
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Fecha Registro</th>
                      <th>Inicial</th>
                      <th>Final</th>
                      <th>Sede</th>
                      <th>Obs</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($admcontratogen->mostrarTodo("") as $f)
                    {
                      $dsede=$sede->muestra($f['idsede']);
                      ?>
                      <tr>
                        <td><?php echo $f['fechacreacion'] ?></td>
                        <td><?php echo $f['inicial'] ?></td>
                        <td><?php echo $f['final'] ?></td>
                        <td><?php echo $dsede['nombre'] ?></td>
                        <td><?php echo $f['obs'] ?></td>
                      </tr>
                      <?php
                      }
                    ?>
                  </tbody>
                </table>
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
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable();
    });
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
    function cargaDato(id){
      $.ajax({
        async: true,
        url: "cargainicial.php?idsede="+id.value,
        type: "get",
        dataType: "html",
        success: function(data){
          console.log(data);
          var json = eval("("+data+")");
          $("#idInicial").val(json.inicial);
        }
      });
    }
    </script>
</body>

</html>