<?php
  $ruta="../../../";
  include_once($ruta."class/vfactura.php");
  $vfactura=new vfactura;
  include_once($ruta."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/admdosificacion.php");
  $admdosificacion=new admdosificacion;
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $idsede=$_SESSION["idsede"];
  $dse=$sede->muestra($idsede);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo=" Facturas Contabilidad ".$dse['nombre'];
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
          $idmenu=32;
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
            <div class="section">
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Esp.</th>
                      <th>#</th>
                      <th>Fecha</th>
                      <th>Nro</th>
                      <th>Autorizacion</th>
                      <th>Est.</th>
                      <th>Nit Cliente</th>
                      <th>Nombre/Razon Social</th>
                      <th>Monto</th>
                      <th>ICE</th>
                      <th>EXP.</th>
                      <th>TASA</th>
                      <th>Subtotal</th>
                      <th>Descuentos</th>
                      <th>Base Iva</th>
                      <th>Debito</th>
                      <th>Codigo de Control</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sw=true;
                    $contador=1;
                    foreach($vfactura->mostrarTodo("idsede=$idsede and fecha between '$fechain' and '$fechafin'","nro") as $f)
                    {
                      $lblcode=ecUrl($f['idvfactura']);
                      $ddos=$admdosificacion->muestra($f['iddosificacion']);
                      $dsuc=$admsucursal->muestra($f['idsucursal']);
                      $dsede=$sede->muestra($dsuc['idsede']);
                      switch ($f['estado']) {
                        case '1':
                          $estilo="background-color: #aaffb4;";
                        break;
                        case '2':
                          $estilo="background-color: #ff9395;";
                        break;
                        case '3':
                          $estilo="background-color: #41f462;";
                        break;
                        case '4':
                          $estilo="background-color: #f46741;";
                        break;
                      }
                        if ($f['estado']=='2') {
                        ?>
                          
                          <tr style="<?php echo $estilo ?>">
                              <td>3</td>
                              <td><?php echo $contador?></td>
                              <td>0</td>
                              <td><?php echo $f['nro'] ?></td>
                              <td>0</td>
                              <td>A</td>
                              <td>0</td>
                              <td>FACTURA ANULADA</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                            </tr>
                        <?php
                        }else{
                          ?>
                            <tr style="<?php echo $estilo ?>">
                              <td><?php echo "3"?></td>
                              <td><?php echo $contador?></td>
                              <td><?php echo $f['fecha']?></td>
                              <td><?php echo $f['nro'] ?></td>
                              <td><?php echo $ddos['autorizacion'] ?></td>
                              <td><?php 
                                switch ($f['estado']) {
                                  case '1':
                                    echo "V";
                                  break;
                                  case '2':
                                    echo "A";
                                  break;
                                }
                              ?></td>
                              <td><?php echo $f['nit'] ?></td>
                              <td><?php echo $f['razon'] ?></td>
                              <td><?php echo number_format($f['total'], 2, '.', '') ?></td>
                              <td><?php echo "0" ?></td>
                              <td><?php echo "0" ?></td>
                              <td><?php echo "0" ?></td>
                              <td><?php echo number_format($f['total'], 2, '.', '') ?></td>
                              <td><?php echo "0" ?></td>
                              <td><?php echo number_format($f['total'], 2, '.', '') ?></td>
                              <td><?php 
                              $monto=number_format($f['total'], 2, '.', '');
                              $iva=0.13;
                              $baseIva=$monto*$iva;
                              $baseIva=number_format($baseIva, 2, '.', '');
                              echo $baseIva;
                               ?></td>
                              <td><?php echo $f['control']; ?> </td>
                            </tr>
                          <?php
                        }
                    $contador++;
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <?php
            //include_once("../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div class="row">
    </div>
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable({
        dom: 'Bfrtip',
        "order": [[ 3, "asc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });
    </script>
</body>

</html>