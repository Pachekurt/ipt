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
  include_once($ruta."funciones/funciones.php");
  session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="REVISAR FECHA PROXIMO PAGO";
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
          $idmenu=66;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title">REVISAR FECHAS PROXIMO PAGO</h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div id="table-datatables">
              <div class="row">
                <form id="idform" action="return false" onsubmit="return false" method="POST">
                  <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Numerador</th>
                        <th>Matricula</th>
                        <th>Cuenta</th>
                        <th>Titular</th>
                        <th>Plan</th>
                        <th>Monto</th>
                        <th>Saldo</th>
                        <th>Cuotas Rest.</th>
                        <th>Dias Mora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i=0;
                      $saldo=0;
                      foreach($vcartera->mostrarTodo("saldo>0 and revisado=0") as $f)
                      {
                        $i++;
                        $saldo=$saldo+$f['saldo'];
                        $lblcode=ecUrl($f['idvcartera']);
                        $dct=$admcontrato->muestra($f['idcontrato']);
                        
                        $destado=$dominio->muestra($f['estado']);
                        $dcp=$vcontratoplan->muestra($f['idcontrato']);
                        $fechaPVE=$f['fechaproxve'];
                        $fechaHoy=date("Y-m-d");
                        $dias=diferenciaDias($fechaPVE, $fechaHoy);
                        $styleP="";

                        if ($f['estado']==131) {
                          $styleP="background-color:#82f286";
                          if ($dias>-4) {
                            $styleP="background-color:#cff24f";
                          }
                        }elseif ($f['estado']==133) {
                          $styleP="background-color:#f0aa4e";
                          if($dias>60)$styleP="background-color:#f04e4e";
                        }
                        if ($dias<0) {
                          $dias=0;
                        }
                      ?>
                      <tr style="<?php echo $styleP ?>">
                        <td><?php echo $f['idvcartera'] ?></td>
                        <td><?php echo $dct['nrocontrato'] ?></td>
                        <td><?php echo $dct['cuenta'] ?></td>
                        <td>
                          <?php
                            $dtit=$vtitular->muestra($dct['idtitular']);
                            echo $dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'];
                          ?>
                        </td>
                        <td><?php echo $dcp['nombre']." ".$dcp['cuotas']." Cuot."; ?></td>
                        <td><?php echo $f['monto'] ?></td>
                        <td><?php echo $f['saldo'] ?></td>
                        <td><?php echo crestantes($f['monto']-$f['pagadoprod'],$f['saldo'],$dcp['cuotas'])." de ".($dcp['cuotas']+1); ?></td>
                        <td><?php echo $dias ?></td>
                        <td><?php echo $destado['nombre'] ?></td>
                        <td>
                          <a class="linkRow" href="ajustar/?lblcode=<?php echo $lblcode ?>">Revisar</a> / 
                          <a target="_blank" class="linkRow" href="../impresion/comportamiento/?lblcode=<?php echo $lblcode ?>">EE.CC.</a>
                        </td>
                      </tr>
                      <?php
                        }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>CANTIDAD: <?php echo $i ?>, SALDO: <?php echo number_format($saldo, 2, '.', ' ') ?> </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </form>
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
    </script>
</body>

</html>