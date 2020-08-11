<?php
  $ruta="../../";
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admdosificacion.php");
  $admdosificacion=new admdosificacion;
  include_once($ruta."class/admsucursal.php");
  $admsucursal=new admsucursal;
  session_start();
  $idsede=$_SESSION["idsede"];
  $dse=$sede->muestra($idsede);
  $dsuc=$admsucursal->mostrarUltimo("idsede=".$idsede);
  $ddos=$admdosificacion->mostrarUltimo("estado=1 and idadmsucursal=".$dsuc['idadmsucursal']);
  $fechaHoy=date("Y-m-d");
  $dias=diferenciaDias($fechaHoy, $ddos['fechalimite']);
  //echo "DIAS RESTANTES ".$dias;
  //echo "Fecha Limite ".$ddos['fechalimite'];
  $fechain=date("Y-m")."-01";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Reportes de Facturación ".$dse['nombre'];
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
          $idmenu=39;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                  <a href="#" class="btn waves-effect green darken-1 animated infinite rubberBand"> Días Restantes de la dosificación <b> <?php echo $dias ?></b></a>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="formcontent">
                <div class="col s12 m4 l3">
                  <h4 class="titulo">Reporte para Contabilidad</h4>
                  <p style="text-align: justify;">
                    Ingrese Fecha de inicio y fecha fin y luego haga clic en GENERAR REPORTE
                  </p>
                </div>
                <div class="col s12 m8 l9">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                    <div class="row">
                      <div class="input-field col s12 m6 l2">
                        <input id="fechain" style="text-align: center;" name="fechain" type="date" value="<?php echo $fechain; ?>" class="validate">
                        <label for="fechain">Fecha Inicio</label>
                      </div>
                      <div class="input-field col s12 m6 l2">
                        <input id="fechafin" style="text-align: center;" name="fechafin" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                        <label for="fechafin">Fecha Fin</label>
                      </div>
                      <div class="input-field col s12 m6 l4">
                        <a style="width: 100%" id="btnSsave" class="btn waves-effect waves-light darken-3 purple"><i class="fa fa-save"></i> GENERAR REPORTE</a><br><br><br>
                      </div>
                    </div>
                  </form>
                </div>&nbsp;
                <div class="col s12 m12 l12">
                  <div class="divider"></div>
                </div>
                <div class="col s12 m12 l12">
                  <div class="divider"></div>
                </div>&nbsp;<br><br><br><br><br><br>
              </div>
              <div class="formcontent">
                <div class="col s12 m4 l3">
                  <h4 class="titulo">Reporte para Administración</h4>
                  <p style="text-align: justify;">
                    Ingrese Fecha de inicio y fecha fin y luego haga clic en GENERAR REPORTE
                  </p>
                </div>
                <div class="col s12 m8 l9">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                    <div class="row">
                      <div class="input-field col s12 m6 l2">
                        <input id="fechaini" style="text-align: center;" name="fechaini" type="date" value="<?php echo $fechain; ?>" class="validate">
                        <label for="fechaini">Fecha Inicio</label>
                      </div>
                      <div class="input-field col s12 m6 l2">
                        <input id="fechafini" style="text-align: center;" name="fechafini" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                        <label for="fechafini">Fecha Fin</label>
                      </div>
                      <div class="input-field col s12 m6 l4">
                        <a style="width: 100%" id="btnSave" class="btn waves-effect waves-light darken-3 purple"><i class="fa fa-save"></i> GENERAR REPORTE</a><br><br><br>
                      </div>
                    </div>
                  </form>
                </div>&nbsp;
                <div class="col s12 m12 l12">
                  <div class="divider"></div>
                </div>
                <div class="col s12 m12 l12">
                  <div class="divider"></div>
                </div>&nbsp;<br><br><br><br><br><br>
              </div>
              <div class="formcontent">
                <div class="col s12 m4 l3">
                  <h4 class="titulo">Reporte para Factura</h4>
                  <p style="text-align: justify;">
                    Ingrese Fecha de inicio y fecha fin y luego haga clic en GENERAR REPORTE
                  </p>
                </div>
                <div class="col s12 m8 l9">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                    <div class="row">
                      <div class="input-field col s12 m6 l2">
                        <input id="fechain2" style="text-align: center;" name="fechain2" type="date" value="<?php echo $fechain; ?>" class="validate">
                        <label for="fechain2">Fecha Inicio</label>
                      </div>
                      <div class="input-field col s12 m6 l2">
                        <input id="fechafin2" style="text-align: center;" name="fechafin2" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                        <label for="fechafin2">Fecha Fin</label>
                      </div>
                      <div class="input-field col s12 m6 l2">

                        <label for="tipo">Tipo Pago</label>
                        <select name="tipo" id="tipo">
                          <option value="1">EFECTIVO</option>
                          <option value="2,3">TARJETA</option>
                        </select>
                        <label for="fechafin">Fecha Fin</label>
                      </div>
                      <div class="input-field col s12 m6 l4">
                        <a style="width: 100%" id="btnSssave" class="btn waves-effect waves-light darken-3 purple"><i class="fa fa-save"></i> GENERAR REPORTE</a><br><br><br>
                      </div>
                    </div>
                  </form>
                </div>&nbsp;
                <div class="col s12 m12 l12">
                  <div class="divider"></div>
                </div>
                <div class="col s12 m12 l12">
                  <div class="divider"></div>
                </div>&nbsp;<br><br><br><br><br><br>
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
      $("#btnSsave").click(function(){
        fechain=$("#fechain").val();
        fechafin=$("#fechafin").val();
        window.open("contable/?fechain="+fechain+"&fechafin="+fechafin,"_blank");
      }); 

      $("#btnSave").click(function(){
        fechain=$("#fechaini").val();
        fechafin=$("#fechafini").val();
        window.open("administracion/?fechain="+fechain+"&fechafin="+fechafin,"_blank");
      });
      
      $("#btnSssave").click(function(){
        fechain=$("#fechain2").val();
        fechafin=$("#fechafin2").val();
        tipo=$("#tipo").val();
        window.open("factura/?fechain="+fechain+"&fechafin="+fechafin+"&tipo="+tipo,"_blank");
      });  
    </script>
</body>

</html>