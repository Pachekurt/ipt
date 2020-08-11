<?php
  $ruta="../../";
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  if (!isset($lblcode)) {
    $query="";
    $tituloSede="Contratos en todas las Sedes";
  }
  else{
    $query=" and idsede=".dcUrl($lblcode);
    $dSelSede=$sede->mostrar(dcUrl($lblcode));
    $dSelSede=array_shift($dSelSede);
    $tituloSede="Contratos en Sede ".$dSelSede['nombre'];
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Contratos en Sedes";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
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
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $tituloSede; ?></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="input-field col s2">
                    Seleccionar Sede:
                  </div>
                  <div class=" col s5">
                    <label>Seleccionar Sede</label>
                    <select id="idsede" name="idsede">
                      <option disabled value="">Seleccionar Sede...</option>
                      <?php
                      foreach($sede->mostrarTodo("") as $f)
                      {
                      ?>
                      <option value="<?php echo ecUrl($f['idsede']) ?>"><?php echo $f['nombre'] ?></option>
                      <?php
                      }
                      ?>
                      <option value="0">TODOS</option>
                    </select>
                  </div>
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
                      <th>Fecha Habil</th>
                      <th>Sede</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($admcontrato->mostrarTodo("activo=1".$query) as $f)
                    {
                      $dsede=$sede->mostrar($f['idsede']);
                      $dsede=array_shift($dsede);

                      $destado=$dominio->mostrar($f['estado']);
                      $destado=array_shift($destado);
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
                            $estilo="background-color: #67a8b5;";
                          break;
                          case '64'://anulado
                            $estilo="background-color: #e2858d;";
                          break;
                        }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo "CT-".$f['nrocontrato'] ?></td>
                      <td><?php echo $f['fechacreacion'] ?></td>
                      <td><?php echo $dsede['nombre'] ?></td>
                      <td><?php echo $destado['nombre'] ?></td>
                      <td>
                        <a href="verdetalle.php?lblcode=<?php echo $idrol ?>" class="btn-jh waves-effect darken-4 green"><i class="fa fa-eye"></i></a>
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