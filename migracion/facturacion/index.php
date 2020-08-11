<?php
  $ruta="../../";
  include_once($ruta."class/vfactura.php");
  $vfactura=new vfactura;
  include_once($ruta."class/factura.php");
  $factura=new factura;
  include_once($ruta."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/vpagotit.php");
  $vpagotit=new vpagotit;
  include_once($ruta."class/vrecotit.php");
  $vrecotit=new vrecotit;
  include_once($ruta."class/factcliente.php");
  $factcliente=new factcliente;
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
?>
<!DOCTYPE html>
<html lang="es">
<head>
</head>
<body>
    <div id="main">
      <div class="wrapper">
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i></h5>
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
                      <th>Fecha</th>
                      <th>Nro</th>
                      <th>Nit/Razon</th>
                      <th>Desde</th>
                      <th>Matricula</th>
                      <th>Monto</th>
                      <th>Sede</th>
                      <th>Usuario</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sw=true;
                    foreach($vfactura->mostrarTodo("","nro") as $f)
                    {
                      $lblcode=ecUrl($f['idvfactura']);
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
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['fecha']." ".$f['horacreacion'] ?></td>
                      <td><?php echo $f['nro'] ?></td>
                      <td>
                        <?php
                          if ($f['tipotabla']=='CART') {
                            $dpago=$vpagotit->muestra($f['idtabla']);
                            $razonT=$dpago['razon'];
                            $nitT=$dpago['nit'];
                          }
                          if ($f['tipotabla']=='RECO') {
                            $dpago=$vrecotit->muestra($f['idtabla']);
                            $razonT=$dpago['razon'];
                            $nitT=$dpago['nit'];
                          }
                          if ($f['tipotabla']=='SERV. AD.') {
                            $dpago=$factcliente->muestra($f['idtabla']);
                            $razonT=$dpago['razon'];
                            $nitT=$dpago['nit'];
                          }
                          $valFactura=array(
                            "nit"=>"'$nitT'",
                            "razon"=>"'$razonT'"
                          );  
                          //$factura->actualizar($valFactura,$f['idvfactura']);
                          echo $nitT." - ".$razonT." :::: ".$f['nit']." - ".$f['razon'];
                        ?>
                          
                        </td>
                      <td>
                        <?php 
                          switch ($f['tipotabla']) {
                            case 'CART':
                              echo "RECAUDACIONES";
                              break;
                            case 'RECO':
                              echo "PRODUCCION";
                              break;
                            case 'SERV. AD.':
                              echo "SERVICIOS ADICIONALES";
                              break;
                          }
                        ?>
                      </td>
                      <td><?php echo $f['matricula'] ?></td>
                      <td><?php echo $f['total'] ?></td>
                      <td><?php echo $dsede['nombre'] ?></td>
                      <td>
                        <?php 
                          $dus=$usuario->muestra($f['usuariocreacion']);
                          echo $dus['usuario'];
                        ?>
                      </td>
                      <td>
                        <?php 
                          switch ($f['estado']) {
                            case '1':
                              echo "VALIDA";
                            break;
                            case '2':
                              echo "ANULADA";
                            break;
                            case '3':
                              $estilo="";
                            break;
                            case '4':
                              $estilo="";
                            break;
                          }
                        ?>
                      </td>
                      <td>
                        
                      </td>
                    </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
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
    </script>
</body>

</html>