<?php
  $ruta="../../";
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $idsede=$_SESSION["idsede"];
  $dsede=$sede->muestra($idsede);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Contratos en Sedes - ".$dsede['nombre'];
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
          $idmenu=15;
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
              <div class="col s12 m12 l12">
                <div class="row">
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
                      <th>Nro Contrato</th>
                      <th>Ejecutivo</th>
                      <th>Titular</th>
                      <th>Sede</th>
                      <th>Fecha Estado</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($admcontrato->mostrarTodo("activo=1 and idsede=$idsede") as $f)
                    {
                      $lblcode=ecUrl($f['idadmcontrato']);
                      $dsede=$sede->muestra($f['idsede']);
                      $destado=$dominio->muestra($f['estado']);
                      switch ($f['estado']) {
                          case '60'://sin asignar
                            $estilo="background-color: #8dd3c3;";
                          break;
                          case '61'://asignado
                            $estilo="background-color: #e2ca7f;";
                          break;
                          case '62'://reportado
                            $estilo="background-color: #5fd384;";
                          break;
                          case '63'://anulado
                            $estilo="background-color: #55c662;";
                          break;
                          case '64'://anulado
                            $estilo="background-color: #e2858d;";
                          break;
                          case '65'://anulado
                            $estilo="background-color: #85e2c9;";
                          break;
                          case '66'://anulado
                            $estilo="background-color: #e2858d;";
                          break;
                          case '67'://anulado
                            $estilo="background-color: #e2858d;";
                          break;
                          case '68'://PRECIERRE
                            $estilo="background-color: #d6fcda;";
                          break;
                        }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['nrocontrato'] ?></td>
                      
                      <td>
                      <?php 
                        if ($f['idadmejecutivo']>0) {
                          $deje=$vejecutivo->muestra($f['idadmejecutivo']);
                          echo $deje['nombre']." ".$deje['paterno']." ".$deje['materno'];
                        }else{
                          echo "--Sin Asignar--";
                        }
                      ?>
                      </td>
                      <td>
                        <?php 
                          if ($f['idadmejecutivo']>0) {
                            $dtit=$vtitular->muestra($f['idtitular']);
                            echo $dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'];
                          }else{
                            echo "--Sin Asignar--";
                          }
                        ?>
                      </td>
                      <td><?php echo $dsede['nombre'] ?></td>
                      <td><?php echo $f['fechaestado'] ?></td>
                      <td><?php echo $destado['nombre'] ?></td>
                      <td>
                        <a href="ver/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-3 purple"><i class="fa fa-eye"></i></a>
                        <a href="anular/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 red"><i class="fa fa-recycle"></i></a>
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
          <?php
            include_once("../footer.php");
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
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
      $("#idsede").change(function() {
        lblcode=$('select[id=idsede]').val()
        if (lblcode==0) {
          location.href="../contrato";
        }
        else{
          location.href="?lblcode="+lblcode;
        }
      });
    });
    </script>
</body>

</html>