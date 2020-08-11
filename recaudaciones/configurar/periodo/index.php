<?php
  $ruta="../../../";
  session_start();
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/cobcartera.php");
  $cobcartera=new cobcartera;
  include_once($ruta."class/cobcarteradet.php");
  $cobcarteradet=new cobcarteradet;
  include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;
  include_once($ruta."class/cobresumen.php");
  $cobresumen=new cobresumen;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Gestionar Periodos";
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_tabla.php");
    include_once($ruta."includes/head_tablax.php");
  ?>
  <style type="text/css">
    .estIn input{
      border:solid 1px #4286f4;
      width: 110px;
    }
  </style>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=60;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l5">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <?php
            $dresumen=$cobresumen->mostrarUltimo("estado=1");
            if (count($dresumen)>0) {
              ?>
              <!-- para cuando no registros -->
              <div class="row">
                <div class="titulo">Resumen a la Fecha</div>
                <div class="formcontent">
                  <div class="col s12 m8 l9">
                    <div class="row">
                      <div class="input-field col s12 m6 l3">
                        <input id="idfechaA" name="idfechaA" type="month" value="<?php echo date('Y-m'); ?>" class="validate">
                        <label for="idfechaA">Fecha</label>
                      </div>
                      <div class="input-field col s3">
                        <label>SEDE</label>
                        <select id="idareaA" name="idareaA">
                          <?php
                            foreach($sede->mostrarTodo("") as $f)
                            {
                              ?>
                                <option value="<?php echo $f['idsede']; ?>"><?php echo $f['nombre']; ?></option>
                              <?php
                            }
                          ?>
                        </select>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <a style="width: 100%" id="btnSsave" class="btn waves-effect waves-light darken-3 red"><i class="fa fa-save"></i> CERRAR PERIODO</a>
                      </div>
                    </div>
                  </div>&nbsp;
                  <div id="table-datatables">
                    <div class="row">
                      <table id="example2" class="display" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Mes Actual</th>
                            <th>Ejecutivo</th>
                            <th>Cantidad</th>
                            <th>Cobro Proyectado</th>
                            <th>Saldo General</th>
                            <th>Recaudado</th>
                            <th>Descuentos</th>
                            <th>Saldo Actual</th>
                            <th>Puntos</th>
                            <th>%</th>
                            <th>--</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $consulta="SELECT idejecutivo, count(*) as cuentas, sum(saldo) as saldo,sum(mensualidad) as mensualidad FROM duartema_nacional.vcartera group by idejecutivo";
                          foreach($cobcarteradet->sql($consulta) as $f)
                          {
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
                            ?>
                              <tr>
                                <td><?php echo obtenerMes(date('Y-m-d')); ?></td>
                                <td><?php echo $ejecutivo ?></td>
                                <td><?php echo $f['cuentas'] ?></td>
                                <td><?php echo number_format($f['mensualidad'], 2, '.', ' ') ?></td>
                                <td><?php echo number_format($f['saldo'], 2, '.', ' ') ?></td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td><a class="btn-jh purple"><i class="fa fa-eye"></i></a></td>
                              </tr>
                            <?php
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <?php
            }
            else{
              ?>
              <!-- para cuando no hay registros -->
              <div class="row">
                <div class="titulo">Resumen para Iniciar Periodo</div>
                <div class="formcontent">
                  <div class="col s12 m8 l9">
                    <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                    <div class="row">
                      <div class="input-field col s12 m6 l3">
                        <input id="idfecha" name="idfecha" type="month" value="<?php echo date('Y-m'); ?>" class="validate">
                        <label for="idfecha">Fecha</label>
                      </div>
                      <div class="input-field col s3">
                        <label>SEDE</label>
                        <select id="idarea" name="idarea">
                          <?php
                            foreach($sede->mostrarTodo("") as $f)
                            {
                              ?>
                                <option value="<?php echo $f['idsede']; ?>"><?php echo $f['nombre']; ?></option>
                              <?php
                            }
                          ?>
                        </select>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <a style="width: 100%" id="btnSsave" class="btn waves-effect waves-light darken-3 green"><i class="fa fa-save"></i> INICIAR PERIODO</a>
                      </div>
                    </div>
                  </div>&nbsp;
                  <div id="table-datatables">
                    <div class="row">
                      <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Mes Actual</th>
                            <th>Ejecutivo</th>
                            <th>Cantidad</th>
                            <th>Saldo General</th>
                            <th>Cobro Proyectado</th>
                            <th>--</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $consulta="SELECT idejecutivo, count(*) as cuentas, sum(saldo) as saldo,sum(mensualidad) as mensualidad FROM duartema_nacional.vcartera where saldo>0 group by idejecutivo  ";
                          foreach($cobcarteradet->sql($consulta) as $f)
                          {
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
                            ?>
                              <tr>
                                <td><?php echo obtenerMes(date('Y-m-d')); ?></td>
                                <td><?php echo $ejecutivo ?></td>
                                <td><?php echo $f['cuentas'] ?></td>
                                <td><?php echo number_format($f['saldo'], 2, '.', ' ') ?></td>
                                <td><?php echo number_format($f['mensualidad'], 2, '.', ' ') ?></td>
                                <td><a class="btn-jh purple"><i class="fa fa-eye"></i></a></td>
                              </tr>
                            <?php
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <?php
            }
            ?>
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
      $("#btnSsave").click(function(){
        swal({   
            title: "Iniciar Periodo?",   
             text: "Comenzaras un nuevo periodo",   
             type: "warning",   
             showCancelButton: true,   
             closeOnConfirm: false,   
             showLoaderOnConfirm: true, }, 
             function(){
              if (validar()) {
                $('#btnSsave').attr("disabled",true);
                $.ajax({
                  url: "nuevoperiodo.php",
                  type: "POST",
                  success: function(resp){
                    setTimeout(function(){     
                      console.log(resp);
                      $('#idresultado').html(resp);   
                    }, 1000); 
                  }
                });
              }
        });
      });
      $('#example').DataTable( {
        dom: 'Bfrtip',
        resonsive: 'true',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
      $('#example2').DataTable( {
        dom: 'Bfrtip',
        resonsive: 'true',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
      function validar(){
        return true;
      }
    </script>
</body>
</html>