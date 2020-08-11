<?php
  $ruta="../../";
  include_once($ruta."class/vejecutivopersona.php");
  $vejecutivopersona=new vejecutivopersona;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
  $idcontrato=dcUrl($lblcode);
  $dcontrato=$admcontrato->mostrar($idcontrato);
  $dcontrato=array_shift($dcontrato);
  session_start();  
  $dejecutivo=$vejecutivopersona->mostrar($dcontrato['idadmejecutivo']);
  $dejecutivo=array_shift($dejecutivo);
  $ejecutivo= $dejecutivo['nombre']." ".$dejecutivo['paterno']." ".$dejecutivo['materno'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Pruebas de Dosificacion";
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
          $idmenu=28;
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
                <div class="col s6 m6 l6">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <div class="formcontent">
                      <div class="row">
                        <div class="input-field col s12">
                          <input id="idnumAut" name="numAut" type="text" class="validate">
                          <label for="idnumAut">Número de Autorización</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idnumFactura" name="numFactura" type="text" class="validate">
                          <label for="idnumFactura">Número de Factura</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idnitCli" name="nitCli" type="text"class="validate">
                          <label for="idnitCli">Nit/Ci Cliente</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idfTransaccion" name="fTransaccion" type="date" class="validate">
                          <label for="idfTransaccion">Fecha de la Transacción</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idmonto" name="monto" type="text" class="validate">
                          <label for="idmonto">Monto de la Transacción</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idllave" name="llave" type="text" class="validate">
                          <label for="idllave">Llave de dosificación</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s3">
                        </div>     
                        <div class="input-field col s9">
                          <a id="btnLimpiarTodo" class="btn waves-effect waves-light orange"><i class="fa fa-trash"></i></a>
                          <a id="btnSave" class="btn waves-effect waves-light blue"><i class="fa fa-bolt"></i> Generar Código</a>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="input-field col s7">
                          <input id="idresultado" readonly placeholder="Resultado..." name="resultado" type="text" class="validate">
                        </div>     
                        <div class="input-field col s5">
                          <a id="btnLimpiar" class="btn waves-effect waves-light orange"><i class="fa fa-trash"></i></a>
                          <a id="btnAgregar" class="btn waves-effect waves-light blue"><i class="fa fa-arrow-circle-right"></i> AGREGAR</a>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col s6 m6 l6">
                  <div class="row">
                    <div class="input-field col s12">
                      <textarea id="idresultados" readonly style="height: 265px;" name="idresultados" class="materialize-textarea"></textarea>
                    </div>
                    <div class="input-field col s6">
                    </div>
                    <div class="input-field col s6">
                      <a id="btnLimpiarArea" class="btn waves-effect waves-light orange"><i class="fa fa-arrow-circle-right"></i> Limpiar</a>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <?php
            include_once("../footer.php");
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
        var str = $( "#idform" ).serialize();
        //alert(str);
        $.ajax({
          url: "generar.php",
          type: "POST",
          data: str,
          success: function(resp){
            console.log(resp);
            $('#idresultado').val(resp);
          }
        });
      });
      $("#btnLimpiar").click(function(){
        $("#idresultado").val("");
      });
      $("#btnLimpiarArea").click(function(){
        $("#idresultados").val("");
      });
      $("#btnLimpiarTodo").click(function(){
        $("#idnumAut").val("");
        $("#idllave").val("");
        $("#idmonto").val("");
        $("#idnumFactura").val("");
        $("#idfTransaccion").val("");
        $("#idnitCli").val("");
      });
      $("#btnLimpiarArea").click(function(){
        $("#idresultados").val("");
      });
      $("#btnAgregar").click(function(){
        $("#idresultados").val($("#idresultados").val()+$("#idresultado").val()+"\n");
      });    
    </script>
</body>

</html>