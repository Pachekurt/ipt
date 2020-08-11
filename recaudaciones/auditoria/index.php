<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/cobcartera.php");
  $cobcartera=new cobcartera;
  include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;
  include_once($ruta."class/vcartera.php");
  $vcartera=new vcartera;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  
  include_once($ruta."funciones/funciones.php");
  session_start();
  $idusuario=$_SESSION["codusuario"];
  $dusuario=$usuario->muestra($idusuario);
  $idejecutivo=$dusuario['idadmejecutivo'];
  $dejec=$vejecutivo->muestra($idejecutivo);

  $idsede=$_SESSION["idsede"];
  $dse=$sede->muestra($idsede);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Cartera General Auditoria - ".$dse['nombre'];
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
      include_once($ruta."includes/head_tablax.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=63;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i><?php echo $hd_titulo; ?> 
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div class="titulo">SUMAS Y SALDOS A FECHA <?php echo date("Y-m-d"); ?></div>
              <div id="table-datatables">
              <div class="row">
                <table id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Mes Actual</th>
                      <th>Ejecutivo</th>
                      <th>Cantidad</th>
                      <th>Saldo General</th>
                      <th>--</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $consulta="SELECT idejecutivo, count(*) as cuentas, sum(saldo) as saldo,sum(mensualidad) as mensualidad FROM duartema_nacional.vcartera where auditado=0 and idsede=$idsede group by idejecutivo";
                    $saldo=0;
                    $cantidad=0;
                    $dejecutivo = array();
                    foreach($vcartera->sql($consulta) as $f)
                    {
                      

                      $lblcode=ecUrl($f['idejecutivo']);
                      $saldo=$saldo+$f['saldo'];
                      $cantidad=$cantidad+$f['cuentas'];
                      if ($f['idejecutivo']>10) {
                        $deje=$vejecutivo->muestra($f['idejecutivo']);
                        $ejecutivo= $deje['nombre'];
                      }
                      elseif ($f['idejecutivo']==1) {
                        $ejecutivo= "PROXIMA VIGENCIA";
                      }
                      elseif ($f['idejecutivo']==2) {
                        $ejecutivo= "PREJURIDICA";
                      } 
                      elseif ($f['idejecutivo']==6) {
                        $ejecutivo= "ABANDONO";
                      }
                      elseif ($f['idejecutivo']==7) {
                        $ejecutivo= "BAJA DEFINITIVA";
                      }
                      elseif ($f['idejecutivo']==5) {
                        $ejecutivo= "ADMINISTRACION";
                      }
                      $val4=array(
                        "idejecutivo"=>$f['idejecutivo'],
                        "nombre"=>$ejecutivo
                      );
                      array_push($dejecutivo,$val4);
                      ?>
                        <tr>
                          <td><?php echo obtenerMes(date('Y-m-d')); ?></td>
                          <td><?php echo $ejecutivo ?></td>
                          <td><?php echo $f['cuentas'] ?></td>
                          <td><?php echo number_format($f['saldo'], 2, '.', ' ') ?></td>
                          <td><a href="ver/?lblcode=<?php echo $lblcode ?>" class="btn-jh purple"><i class="fa fa-eye"></i></a></td>
                        </tr>
                      <?php
                      }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td></td>
                      <th>TOTAL</th>
                      <th><?php echo $cantidad ?></th>
                      <th><?php echo number_format($saldo, 2, '.', ' ') ?></th>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <?php
              $fechain=date("Y-m")."-01";
            ?>
            <div class="formcontent">
              <div class="row"> 
                <div class="col s12 m4 l3">
                  <h4 class="titulo">Movimientos</h4>
                  <p style="text-align: justify;">
                    Seleccione fecha inicial y fecha final y presione GENERAR
                  </p>
                </div>
                <div class="col s12 m8 l9">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                    <div class="row">
                      <div class="input-field col s12 m3 l3">
                        <input id="idfechain" style="text-align: center;" name="idfechain" type="date" value="<?php echo $fechain; ?>" class="validate">
                        <label for="idfechain">Fecha</label>
                      </div>
                      <div class="input-field col s12 m3 l3">
                        <input id="idfechafin" style="text-align: center;" name="idfechafin" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                        <label for="idfechafin">Fecha</label>
                      </div>
                      <div class="input-field col s12 m3 s3">
                        <label>EJECUTIVO</label>
                        <select id="idejecutivo" name="idejecutivo">
                          <option value="<?php echo ecUrl(0); ?>">TODOS</option>
                          <?php
                            foreach($dejecutivo as $f)
                            {
                              ?>
                                <option value="<?php echo ecUrl($f['idejecutivo']); ?>"><?php echo $f['nombre']; ?></option>
                              <?php
                            }
                          ?>
                        </select>
                      </div>
                      <div class="input-field col s12 m3 l3">
                        <a style="width: 100%" id="btnGen" class="btn waves-effect waves-light darken-3 purple"><i class="fa fa-book"></i> GENERAR </a><br><br><br>
                      </div>
                    </div>
                  </form>
                </div>&nbsp;
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
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
      $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
      $('#example2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
      $("#btnGen").click(function(){
        fechain=$("#idfechain").val();
        fechafin=$("#idfechafin").val();
        ejecutivo=$('select[id=idejecutivo]').val();
        window.open("movimientos/?fechain="+fechain+"&fechafin="+fechafin+"&lblcode="+ejecutivo,"_blank");
      });
    </script>
</body>

</html>