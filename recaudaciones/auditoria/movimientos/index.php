<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/cobcarteradet.php");
  $cobcarteradet=new cobcarteradet;
  include_once($ruta."class/factura.php");
  $factura=new factura;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;
  include_once($ruta."class/vcartera.php");
  $vcartera=new vcartera;
  include_once($ruta."class/vcarteradet.php");
  $vcarteradet=new vcarteradet;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);

  $idsede=$_SESSION["idsede"];
  $dse=$sede->muestra($idsede);
  $idejecutivo=dcUrl($lblcode);
  if ($idejecutivo==0) {
    $script="";
  }else{
    $script=" and idejecutivo=".$idejecutivo;
  }
  //echo "S ".$script;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Listado de Cartera ".$dse['nombre'];
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
                  <h5 class="breadcrumbs-title">
                    <a href="../" class="btn blue"><i class="fa fa-reply"></i> Atras</a>
                    <i class="fa fa-tag"></i> <?php echo $hd_titulo; ?>
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
                        <th>Fecha</th>
                        <th>Matricula</th>
                        <th>Cuenta</th>
                        <th>Titular</th>
                        <th>Saldo Ant.</th>
                        <th>Monto</th>
                        <th>Descuento</th>
                        <th>Saldo Act.</th>
                        <th>Factura</th>
                        <th>Ejecutivo</th>
                        <th>Usuario</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i=0;
                      $saldo=0;
                      foreach($vcarteradet->mostrarTodo("idsede=$idsede and fecha between '$fechain' and '$fechafin' ".$script) as $f)
                      {
                        $dfact=$factura->muestra($f['idfactura']); 
                        $i++;
                        $saldo=$saldo+$f['monto'];
                        ?>
                      <tr>
                        <td><?php echo $f['fechacreacion']." ".$f['horacreacion'] ?></td>
                        <td><?php echo $f['nrocontrato'] ?></td>
                        <td><?php echo $f['cuenta'] ?></td>
                        <td><?php echo $f['ntitular'] ?></td>
                        <td><?php echo number_format($f['saldoant'], 2, '.', ' ') ?></td>
                        <td><?php echo number_format($f['monto'], 2, '.', ' ') ?></td>
                        <td><?php echo number_format($f['descuento'], 2, '.', ' ') ?></td>
                        <td><?php echo number_format($f['saldo'], 2, '.', ' ') ?></td>
                        <td><?php echo $dfact['nro'] ?></td>
                        <td>
                          <?php 
                            if ($f['idejecutivo']==1) {
                              echo "PROXIMA VIGENCIA";
                            }elseif ($f['idejecutivo']==2) {
                              echo "PRE-JURIDICA";
                            }
                            else{
                              $deje=$vejecutivo->muestra($f['idejecutivo']);
                              echo strtoupper($deje['nombre'])." ".strtoupper(substr($deje['paterno'],0,1)).".";
                            }
                          ?>
                        </td>
                        <td>
                          <?php
                            $dus=$usuario->muestra($f['usuariocreacion']);
                            echo $dus['usuario'];
                          ?>
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
                        <th>CANTIDAD: <?php echo $i ?>, TOTAL INGRESO: <?php echo number_format($saldo, 2, '.', ' ');?> </th>
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
            include_once("../../footer.php");
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
        "order": [[ 0, "desc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    </script>
</body>

</html>