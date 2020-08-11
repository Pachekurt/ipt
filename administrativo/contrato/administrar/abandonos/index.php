<?php
  $ruta="../../../../";
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
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admsemana.php");
  $admsemana=new admsemana;
  include_once($ruta."funciones/funciones.php");
  session_start();
  session_start();

  $fechahoy=date("Y-m-d");
  $idsede=$_SESSION["idsede"];
  //$fechahoy="2017-10-03";
  $dsemana=$admsemana->mostrarUltimo("estado=1");
  $fechaVig=$dsemana['fechafin'];
  //$fechaVig="2017-10-02";
  $diferencia=diferenciaDias($fechaVig, $fechahoy);
  $observados=$admcontrato->mostrarTodo("estado=66 and idsede=$idsede");
  $dSelSede=$sede->muestra($idsede);
  $tituloSede="Contratos en Sede ".$dSelSede['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Administrar de Contratos";
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
          $idmenu=1026;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <?php
          if ($diferencia>=0) {
          ?>
         
          <?php
            }
          ?>
       
               <div class="container">
            <div class="section">
              <div id="table-datatables">
              <div class="row">
                <form id="idform" action="return false" onsubmit="return false" method="POST">
                  <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Prox. Vence</th>
                        <th>Matricula</th>
                        <th>Cuenta</th>
                        <th>Ejecutivo</th>
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
                      foreach($cobcartera->mostrarTodo("idejecutivo<>2 and idejecutivo<>3  and estado<>134 and estado<>135 and auditado=0 and idsede=$idsede") as $f)
                      {
                        $lblcode=ecUrl($f['idcobcartera']);
                        $dct=$admcontrato->muestra($f['idcontrato']);
                        $deje=$vejecutivo->muestra($f['idejecutivo']);
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
                        <td><?php echo $f['fechaproxve'] ?></td>
                        <td><?php echo $dct['nrocontrato'] ?></td>
                        <td><?php echo $dct['cuenta'] ?></td>
                        <td>
                          <?php
                          if ($f['idejecutivo']==1) {
                             echo "PROXIMA VIGENCIA";
                          }elseif ($f['idejecutivo']==5) {
                            echo "ADMINISTRACION";
                          }
                          else{
                            echo strtoupper($deje['nombre'])." ".strtoupper(substr($deje['paterno'],0,1)).".";
                          }
                          ?>
                        </td>
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
                        <td><a href="../cartera/cobrar/?lblcode=<?php echo $lblcode ?>" class="btn-jh blue darken-4"><i class="mdi-action-assignment-turned-in
"></i> COBRAR</a></td>
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
            include_once("../../../footer.php");
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
      $(document).ready(function() {
        $('#example').DataTable({
          "bFilter": true,
          "bInfo": false,
          "bAutoWidth": false,
          responsive: true,
          dom: 'Bfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ]
        });
      });
      $('#btnObs').addClass('animated bounceOutLeft');
      function QuitarCotr(id){
        $.ajax({
          url: "quitar.php",
          type: "POST",
          data: "idcontrato="+id,
          success: function(resp){
            console.log(resp);
            $('#idresultado').html(resp);
          }
        });
      }
      function verOrg(id){
        window.open("../../organizacion/administrar/organigrama/data.php?lblcode="+id , "ventana1" , "width=1000,height=400,scrollbars=NO"); 
      }
      $("#btnOrg").click(function(){
      });
    </script>
</body>

</html>