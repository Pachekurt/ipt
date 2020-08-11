<?php
  $ruta="../../../../";
  include_once($ruta."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/admdosificacion.php");
  $admdosificacion=new admdosificacion;

  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $idsucursal=dcUrl($lblcode);
  $dsucursal=$admsucursal->muestra($idsucursal);
  $dciudad=$dominio->muestra($dsucursal['idciudad']);
  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Dosificacion";
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
          $idmenu=30;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="row">
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title"><?php echo $hd_titulo ?></h5>
                </div>
                <div class="col s7 m7 l7">
                  <table class="csscontrato">
                    <thead>
                      <tr>
                        <th>Sucursal</th>
                        <th>Ciudad</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $dsucursal['nombre'] ?></td>
                        <td><?php echo $dciudad['nombre'] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <input id="idtipo" name="idtipo" value="<?php echo $tipo ?>" type="hidden" class="validate">
                <div class="col s10 m10 l10">
                    <h4 class="header">Datos de Sucursal</h4>
                    <div class="formcontent">
                      <div class="row">
                        <div class="input-field col s6">
                          <input id="idnumaut" name="idnumaut" type="text" class="validate">
                          <label for="idnumaut">Numero de Autorizacion</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="numaut1" name="numaut1" type="text" class="validate">
                          <label for="numaut1">Numero de Autorizacion</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idllave" name="idllave" type="text" class="validate">
                          <label for="idllave">Llave de Dosificacion</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idllave1" name="idllave1" type="text" class="validate">
                          <label for="idllave1">Llave de Dosificacion</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idfecha" name="idfecha" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                          <label for="idfecha">Fecha Limite de Emision</label>
                        </div>
                        
                        <div class="input-field col s6">
                          <input id="idfecha" name="idfecha" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate active">
                          <label for="idfecha">Fecha Limite de Emision</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idInicial" name="idInicial" type="text" value="1" class="validate">
                          <label for="idInicial">Numero de Factura Inicial</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idInicial" name="idInicial" type="text" value="1" class="validate">
                          <label for="idInicial">Numero de Factura Inicial</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idtramite" name="idtramite" type="text" class="validate">
                          <label for="idtramite">Numero de Tramite</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idleyenda" name="idleyenda" type="text" class="validate">
                          <label for="idleyenda">Leyenda</label>
                        </div>  
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <a id="btnLimpiar" class="btn waves-effect waves-light orange"><i class="fa fa-save"></i> Limpiar</a>
                          <a id="btnSave" class="btn waves-effect waves-light blue"><i class="fa fa-save"></i> Registrar Sucursal</a>
                        </div>
                      </div>
                    </div>
                </div>
              </form>
            </div>
          </div>
          <?php
            include_once("../../../footer.php");
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
        $('#btnSave').attr("disabled",true);
          swal({
            title: "CONFIRMACION",
            text: "Se registrara la Sucursal",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "GUARDAR",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idform" ).serialize();
            $.ajax({
              url: "guardar.php",
              type: "POST",
              data: str+"&lblcode=<?php echo $idsucursal ?>",
              success: function(resp){
                console.log(resp);
                 $("#idresultado").html(resp);
              }
            }); 
          });
      });
    </script>
</body>

</html>