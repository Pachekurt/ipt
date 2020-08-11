<?php
  $ruta="../../../";
  session_start();
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;
  include_once($ruta."class/titular.php");
  $titular=new titular;
  include_once($ruta."class/cobcartera.php");
  $cobcartera=new cobcartera;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/cobcarteradet.php");
  $cobcarteradet=new cobcarteradet;
  include_once($ruta."class/admplanes.php");
  $admplanes=new admplanes;
  include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;
  include_once($ruta."class/admplan.php");
  $admplan=new admplan;
  include_once($ruta."class/vcartera.php");
  $vcartera=new vcartera;
  include_once($ruta."funciones/funciones.php");
  //echo ecUrl(3429);
  /*
    include_once($ruta."class/admsucursal.php");
    $admsucursal=new admsucursal;
    include_once($ruta."class/admdosificacion.php");
    $admdosificacion=new admdosificacion;
  */
  extract($_GET);


  $valor=dcUrl($lblcode);
  $dcar=$cobcartera->muestra($valor);
  /************  prueba proc almacenado  ****************/
  /******************************************************/
  $idcontrato=$dcar['idcontrato'];
  $lblcontr=ecUrl($idcontrato);
  $dct=$admcontrato->muestra($dcar['idcontrato']);
  $idtitular2=$dct['idtitular'];
  $dtit=$vtitular->muestra($dct['idtitular']);
  $ddominio=$dominio->muestra($dcar['estado']);
  $ntitular=$dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'];
  // datos de conrato plan
  $dcp=$vcontratoplan->muestra($dcar['idcontrato']);
  $nplan="PLAN ".$dcp['nombre'];
  //adelanto
  $restan=crestantes($dcar['monto']-$dcar['pagadoprod'],$dcar['saldo'],$dcp['cuotas']);
  $totalCuotas=$dcp['cuotas']+1;
  $cuota=$dcp['cuotas']-$restan;
 // echo $dcp['inversion']."-";
  $pag2=$dcp['mensualidad']*$cuota;
  $pag1=$dcar['monto']-$dcar['pagadoprod']-$dcar['saldo'];
  //echo $pag1."-".$pag2;
  $adelanto=$pag1-$pag2;
  $cuotaPago=$dcp['mensualidad']-$adelanto;
  //echo $adelanto; 
  /*************   para google maps  ************************/
  $short="(COD:".$valor.",CUENTA:".$dct['cuenta']." ,CONTRATO:".$dct['nrocontrato']." ,PLAN:".$dcp['nombre']." ".$totalCuotas."CUOTAS DE ".$dcp['mensualidad']." ,SALDO: ,SOLICITUD-DESCUENTO: )";
//echo $short;
  $fechaPVE=$dcar['fechaproxve'];
  $fechaHoy=date("Y-m-d");
  $dias=diferenciaDias($fechaPVE, $fechaHoy);
  $styleP="";
  if ($dcar['estado']==130) {
    $styleP="background-color:#1bad97";
    $classs="";
  }elseif ($dcar['estado']==131) {
    $styleP="background-color:#82f286";
    $classs="green";
    if ($dias>-4) {
      $styleP="background-color:#cff24f";
      $classs="orange";
    }
  }elseif ($dcar['estado']==133) {
    $styleP="background-color:#f0aa4e";
    $classs="orange darken-4";
    if($dias>60){
      $styleP="background-color:#f04e4e";
      $classs="red darken-2";
    }
  }
  $dcarNext=$vcartera->mostrarPrimero("saldo>0 and revisado=0");
  $didcarnext=ecUrl($dcarNext['idvcartera']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Ajustar Fecha";
    include_once($ruta."includes/head_basico.php");
  ?>
  <style type="text/css">
    .inputn input{
      border: 1px solid #0565ff;
      text-align: center;
      padding: 2px;
    }
    .inputn2 input{
      border: 1px solid #ffb5c3;
      text-align: right;
      padding: 2px;
    }
    .inputn1 input{
      border: 1px solid #ffb5c3;
      text-align: center;
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
          $idmenu=66;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l5">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                  <a class="btn blue" href="../"><i class="fa fa-reply"></i> Atras</a>
                  <a target="_blank" class="btn" href="../../impresion/comportamiento/?lblcode=<?php echo $lblcode ?>"><i class="fa fa-list"></i> Comportamiento</a>
                  <a class="btn green" href="../ajustar/?lblcode=<?php echo $didcarnext; ?>"> Siguiente <i class="mdi-av-skip-next"></i></a>
                </div>

                <div class="col s12 m12 l7">
                  <table class="csscontrato">
                    <thead>
                      <tr>
                        <th>Matricula</th>
                        <th>Cuenta</th>
                        <th>Titular</th>
                        <th>Estado</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $dct['nrocontrato'] ?></td>
                        <td><?php echo $dct['cuenta'] ?></td>
                        <td><?php echo $ntitular ?></td>
                        <td><?php 
                        if ($dcar['revisado']==0) {
                          ?>
                           <h4 class="red" style="color: white;"> PENDIENTE</h4>
                          <?php
                        }else{
                          ?>
                          <h4 class="green" style="color: white;">REVISADO</h4>
                          <?php
                        }
                         ?>
                         </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="formcontent">
            <div class="row">
              <div class="col s12 m12 l12">
              </div>
              <div class="col s12 m12 l12">
                <table class="csstpago">
                  <thead>
                    <tr  style="<?php echo $styleP ?>">
                      <th>Plan</th>
                      <th>Total</th>
                      <th>Saldo</th>
                      <th>Cuota Mes</th>
                      <th>Adelanto</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo $nplan; ?></td>
                      <td><?php echo $dcar['monto'] ?></td>
                      <td><?php echo $dcar['saldo'] ?></td>
                      <td><?php echo $dcp['mensualidad']; ?></td>
                      <td><?php echo $adelanto ?></td>
                    </tr>
                  </tbody>
                </table>
                <table class="csstpago">
                  <thead>
                    <tr style="<?php echo $styleP ?>">
                      <th>Total Cuotas</th>
                      <th>Cuotas Faltantes</th>
                      <th>Ult. Inicio Pago</th>
                      <th>Fecha Vence</th>
                      <th>Dias Mora</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo $totalCuotas ?></td>
                      <td><?php echo $restan; ?></td>
                      <td><?php echo $dcar['fechainicio']; ?></td>
                      <td class="purple" style="font-weight: bold; font-size: 18px; color: white;"><?php echo $dcar['fechaproxve'] ?></td>
                      <td><?php echo $dcar['diasmora']; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col s12 m6 l6">
                <table>
                  <thead>
                    <tr>
                      <th>FECHA OP</th>
                      <th>REGISTRO MIGRACION</th>
                      <th>DETALLE</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($cobcarteradet->mostrarTodo("idcartera=$valor") as $f)
                    {
                    ?>
                    <tr>
                      <td><?php echo $f['fecha']; ?></td>
                      <td><?php echo $f['fechaBase']; ?></td>
                      <td><?php echo $f['glosa']; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="col s12 m6 l6">
                <h4 class="titulo">Realizar Cobro</h4>
                <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                  <table class="cssdato">
                    <tr>
                      <td class="sub">Fijar Fecha Proximo Vence</td>
                      <td class="inputn"><input type="date" name="idproxvence" id="idproxvence" value="<?php echo $dcar['fechaproxve'] ?>"></td>
                    </tr> 
                  </table>
                  <div class="col s12 m12 l6">
                    .
                  </div>
                  <div class="col s12 m12 l6">
                    <?php
                      if ($dcar['saldo']>0) {
                        ?>
                          <button id="btnSave" class="btn purple darken-3" style="width: 100%;"><i class="fa fa-save"></i> REGISTRAR FECHA</button>
                        <?php
                      }
                      else{
                        ?>
                          <div id="card-alert" class="card green lighten-5">
                            <div class="card-content green-text">
                              <p>PAGO FINAL. : El pago ya fue completado</p>
                            </div>
                          </div>
                        <?php
                      }
                    ?>
                  </div>
                </form>
              </div>&nbsp;
              </div>
            </div>
          </div>
          <?php
            //include_once("../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
    ?>
    <script type="text/javascript">
      $("#btnSave").click(function(){
        swal({   
          title: "Ajustar Fecha?",   
          text: "Esta Seguro de haber realizado el cambio de fecha?",   
          type: "warning",   
          showCancelButton: true,   
          closeOnConfirm: false,   
          showLoaderOnConfirm: true, }, 
          function(){
            var str = $( "#idform" ).serialize();
            $.ajax({
              url: "guardar.php",
              type: "POST",
              data: str+"&idcartera=<?php echo $valor ?>",
              success: function(resp){
                
                setTimeout(function(){     console.log(resp);
                $('#idresultado').html(resp);   }, 1000); 
              }
            });
          });
        });
    </script>
</body>

</html>