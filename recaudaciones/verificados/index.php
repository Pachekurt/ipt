<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;
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
      $hd_titulo="Asignacion de Contratos";
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
          $idmenu=51;
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
                    Seleccionar Ejecutivo:
                  </div>
                  <div class="input-field col s4">
                    <label>Seleccionar Ejecutivo</label>
                    <select id="idejecutivo" name="idejecutivo">
                      <option disabled value="">Seleccionar Ejecutivo...</option>
                      <?php
                      foreach($vejecutivo->mostrarTodo("estado=1 and idorganizacion in(19,20,21,25,26) and idsede=$idsede") as $f)
                      {
                        ?>
                        <option value="<?php echo $f['idvejecutivo']; ?>"><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno']." : ".$f['njerarquia'] ?></option>
                        <?php
                      }
                      ?>
                      <!--<option value="1">PROXIMA VIGENCIA</option>-->
                    </select>
                  </div>
                  <div class="input-field col s3">
                    <textarea id="iddesc" name="iddesc" class="materialize-textarea"></textarea>
                    <label for="iddesc">Descripcion</label>
                  </div>
                  <div class="input-field col s3">
                    <button id="btnasignar" class="btn"><i class="fa fa-check"></i> Asignar Contratos</button>
                  </div>
                </div>
              </div>
              <div id="table-datatables">
              <div class="row">
                <form id="idform" action="return false" onsubmit="return false" method="POST">
                  <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Seleccionar Matricula</th>
                        <th>Cuenta</th>
                        <th>Titular</th>
                        <th>Primer Pago</th>
                        <th>Plan</th>
                        <th>Monto</th>
                        <th>Pagado</th>
                        <th>Saldo</th>
                        <th>Cuotas Restantes</th>
                        <th>Estado</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach($admcontrato->mostrarTodo("cartera=0 and estado>64 and estado<>69 and idsede=$idsede") as $f)
                      {
                        $lblcode=ecUrl($f['idadmcontrato']);
                        $destado=$dominio->muestra($f['estado']);
                        $dcp=$vcontratoplan->muestra($f['idadmcontrato']);
                        $sw=true;
                        if ($f['cartera']==1){
                          $sw=false;
                        }
                        $swplan=true;
                        if ($dcp['mensualidad']==0) {
                          $swplan=false;
                        }
                        if ($swplan) {
                          ?>
                          <tr style="<?php echo $estilo ?>">
                            <td>
                              <input name="numero[]" <?php if (!$sw) echo "disabled"; ?> value="<?php echo $f['idadmcontrato']; ?>" type="checkbox" id="ch-<?php echo $f['idadmcontrato']; ?>" />
                              <label for="ch-<?php echo $f['idadmcontrato']; ?>"><i class="fa fa-thumbs-up"></i><?php echo $f['nrocontrato']; ?></label>
                            </td>
                            <td><?php echo $f['cuenta'] ?></td>
                            <td>
                              <?php 
                                $dtit=$vtitular->muestra($f['idtitular']);
                                echo $dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'];
                              ?>
                            </td>
                            <td><?php echo $f['fechainicio'] ?></td>
                            <td><?php echo $dcp['personas']." ".$dcp['nombre'] ?></td>
                            <td><?php echo $dcp['inversion'] ?></td>
                            <td><?php echo $f['pagado'] ?></td>
                            <td><?php echo $dcp['inversion']-$f['pagado'] ?></td>
                            <td><?php echo $dcp['mensualidad'].".Bs x ".$dcp['cuotas']." Cuotas" ?></td>
                            <td><?php echo $destado['nombre'] ?>
                              <a href="../../administrativo/contrato/administrar/record/?lblcode=<?php echo $lblcode ?>" style="color: green; font-weight: bold;" target="_blank" class="btn-jh waves-effect darken-1 yellow"><i class="fa fa-money"></i></a>
                              <a href="../../administrativo/contrato/administrar/cambio/?lblcode=<?php echo $lblcode ?>" data-tooltip="Cambio de  Contrato" target="_blank" class="btn-jh waves-effect indigo tooltipped"><i class="mdi-notification-sync-problem"></i></a>
                            </td>
                          </tr>
                          <?php
                          }else $swplan=true;
                      }
                      ?>
                    </tbody>
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
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        responsive: true
      });
      $("#btnasignar").click(function(){
        var str = $( "#idform" ).serialize();
        var desc=$("#iddesc").val();
        //alert(str);
        var idejecutivo=$('select[id=idejecutivo]').val();
        $.ajax({
            url: "guardar.php",
            type: "POST",
            data: str+"&idejecutivo="+idejecutivo+"&iddesc="+desc,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
      });
    });
    </script>
</body>

</html>