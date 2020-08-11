<?php
  $ruta="../../../../";
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
  include_once($ruta."class/vcartera.php");
  $vcartera=new vcartera;

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
            <div class="row">
              <div class="formcontent">
                <div class="col s12 m4 l3">
                  <h4 class="titulo">Reporte Diario de Cobranza</h4>
                  <p style="text-align: justify;">
                    Deberas verificar que no haya registros pendientes por consolidar.
                  </p>
                </div>
                <div class="col s12 m8 l9">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                    <div class="row">
                      <div class="input-field col s12 m6 l3">
                        <input id="idfecha" style="text-align: center;" name="idfecha" type="month" value="<?php echo date('Y-m-d'); ?>" class="validate">
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
                        <a style="width: 100%" id="btnSsave" class="btn waves-effect waves-light darken-3 purple"><i class="fa fa-save"></i> GENERAR REPORTE</a><br><br><br>
                      </div>
                    </div>
                  </form>
                </div>&nbsp;
                <div class="col s12 m12 l12">
                  <div class="divider"></div>
                </div>
                <div id="table-datatables">
                  <div class="row">
                    <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Prox. Vence</th>
                        <th>Matricula</th>
                        <th>Cuenta</th>
                        <th>Titular</th>
                        <th>Plan</th>
                        <th>Cuota Mes</th>
                        <th>Saldo</th>
                        <th>Cuotas Rest.</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach($vcartera->mostrarTodo("idejecutivo=70  and saldo>0") as $f)
                      {
                        $lblcode=ecUrl($f['idvcartera']);
                        $destado=$dominio->muestra($f['estado']);

                        $fechaPVE=$f['fechaproxve'];
                        $fechaHoy=date("Y-m-d");
                        $dias=diferenciaDias($fechaPVE, $fechaHoy);
                        if ($dias<0) {
                          $dias=0;
                        }
                      ?>
                      <tr style="<?php echo $styleP ?>">
                        <td><?php echo $f['fechaproxve'] ?></td>
                        <td><?php echo $f['nrocontrato'] ?></td>
                        <td><?php echo $f['cuenta'] ?></td>
                        <td>
                          <?php
                            echo $f['ntitular'];
                          ?>
                        </td>
                        <td><?php echo $f['nombreplan']." ".$f['cuotas']." Cuot."; ?></td>
                        <td><?php echo $f['mensualidad'] ?></td>
                        <td><?php echo $f['saldo'] ?></td>
                        <td><?php echo crestantes($f['monto']-$f['pagadoprod'],$f['saldo'],$f['cuotas'])." de ".($f['cuotas']+1); ?></td>
                        
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
          </div>
          <?php
            include_once("../../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">
      $("#idfechaCon").change(function() {
        //alert($("#idfechaCon").val() );
        location.href="?fechaGen="+$("#idfechaCon").val();
      });
      $("#btnSsave").click(function(){
        //alert($("#idfechaCon").val() );
        window.open("imprimir/?fechaGen="+$("#idfecha").val(),"_blank");
      });
      $("#btnSave").click(function(){
        swal({
          title: "Consolidar?",
          text: "Deseas consolidar el Parte diario?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {
          $('#btnSave').attr("disabled",true);
          var str ="fechaGen="+$("#idfechaCon").val();
          $.ajax({
            url: "guardarParte.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
        }); 
      });
      function guardaH(id){
        var hora=$('#c'+id).val();
        var obs=$('#o'+id).val();
        var str="hora="+hora+"&id="+id+"&obs="+obs;
        $.ajax({
          url: "guardar.php",
          type: "POST",
          data: str,
          success: function(resp){
            console.log(resp);
            $('#idresultado').html(resp);
          }
        });
      }
      $('.cuentaCaja').formatter({
        'pattern': '110-1-{{99999}}',
        'persistent': true
      });
      $('#example').DataTable();
      $('#example1').DataTable();
    </script>
</body>
</html>