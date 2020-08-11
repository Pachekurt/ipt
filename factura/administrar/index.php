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
      $hd_titulo="Administrar facturas";
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
          $idmenu=31;
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
              Aca se podran anular o reimprimir con las facturas generadas
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