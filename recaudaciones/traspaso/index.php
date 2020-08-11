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
  include_once($ruta."class/cobcartera.php");
  $cobcartera=new cobcartera;
  include_once($ruta."funciones/funciones.php");
  session_start();
  $idsede=$_SESSION["idsede"];
  $dse=$sede->muestra($idsede);
  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Traspaso de Contratos ".$dse['nombre'];
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
          $idmenu=56;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
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
                  <div class="input-field col s2">
                    Seleccionar Ejecutivo:
                  </div>
                  <div class="input-field col s4">
                    <label>Seleccionar Ejecutivo</label>
                    <select id="idejecutivo" name="idejecutivo">
                      <option disabled value="">Seleccionar Ejecutivo...</option>
                      <?php
                        foreach($vejecutivo->mostrarTodo("estado=1  and idsede=$idsede and idorganizacion in(19,20,21,25)") as $f)
                        {
                          ?>
                          <option value="<?php echo $f['idvejecutivo']; ?>"><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno']." : ".$f['njerarquia'] ?></option>
                          <?php
                        }
                      ?>
                  <!--    <option value="1">PROXIMA VIGENCIA</option>
                      <option value="2">PRE-JURIDICA</option>
                      <option value="3">JURIDICA</option>
                      <option value="5">ADMINISTRACION</option>-->
                      <option value="6">ABANDONO</option>
                      <option value="7">BAJA DEFINITIVA</option>
                    </select>
                  </div>
                  <div class="input-field col s3">
                    <textarea id="iddesc" name="iddesc" class="materialize-textarea"></textarea>
                    <label for="iddesc">Descripcion</label>
                  </div>
                  <div class="input-field col s3">
                    <button id="btnasignar" class="btn"><i class="fa fa-check"></i> Traspasar Matriculas</button>
                  </div>
                </div>
              </div>
              <div id="table-datatables">
              <div class="row">
                <form id="idform" action="return false" onsubmit="return false" method="POST">
                  <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Sel. Matricula</th>
                        <th>Cuenta</th>
                        <th>Ejecutivo</th>
                        <th>Titular</th>
                        <th>Plan</th>
                        <th>Monto</th>
                        <th>Saldo</th>
                        <th>Cuotas Restantes</th>
                        <th>Prox. Vence.</th>
                        <th>Dias Mora</th>
                        <th>Fecha Abandono</th>
                        <th>Estado</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach($cobcartera->mostrarTodo("saldo>0 and idsede=$idsede and idejecutivo not in (1,2) ") as $f)
                      {
                        $destado=$dominio->muestra($f['estado']);
                        $deje=$vejecutivo->muestra($f['idejecutivo']);
                        $dcp=$vcontratoplan->muestra($f['idcontrato']);
                        $nroContrato=$dcp['nrocontrato'];
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
                        if ($f['idejecutivo']==1) {
                          $styleP="background-color:#4dedef";
                        }
                        elseif ($f['idejecutivo']==7) {
                          $styleP="background-color:#4dedef";
                        }
                        ?>
                        <tr style="<?php echo $styleP ?>">
                          <td>
                            <input name="numero[]" value="<?php echo $f['idcobcartera']; ?>" type="checkbox" id="ch-<?php echo $f['idcobcartera']; ?>" />
                            <label for="ch-<?php echo $f['idcobcartera']; ?>"><i class="fa fa-thumbs-up"></i><?php echo $nroContrato; ?></label>
                          </td>
                          <td><?php echo $dcp['cuenta'] ?></td>
                          <td>
                            <?php 
                              if ($f['idejecutivo']==1) {
                                echo "PROXIMA VIGENCIA";
                              }elseif ($f['idejecutivo']==2) {
                                echo "PRE-JURIDICA";
                              }elseif ($f['idejecutivo']==6) {
                                echo "ABANDONO";
                              }elseif ($f['idejecutivo']==7) {
                                echo "BAJA DEFINITIVA";
                              }
                              else{
                                echo $deje['nombre']." ".$deje['paterno']." ".$deje['materno']; 
                              }

                            ?>
                          </td>
                          <td>
                            <?php
                              $dtit=$vtitular->muestra($dcp['idtitular']);
                              echo $dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'];
                            ?>
                          </td>
                          <td><?php echo $dcp['personas']." ".$dcp['nombre'] ?></td>
                          <td><?php echo $dcp['inversion'] ?></td>
                          <td><?php echo $f['saldo'] ?></td>
                          <td><?php echo crestantes($f['monto']-$f['pagadoprod'],$f['saldo'],$dcp['cuotas'])." De ".($dcp['cuotas']+1); ?></td>
                          <td><?php echo $f['fechaproxve'] ?></td>
                          <td><?php echo $dias ?></td>
                          <td><?php echo $f['fechaabandono'] ?></td>
                          <td><?php echo $destado['nombre'] ?></td>
                        </tr>
                        <?php
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