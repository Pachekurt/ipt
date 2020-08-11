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
  include_once($ruta."class/domicilio.php");
  $domicilio=new domicilio;
  include_once($ruta."class/admplanes.php");
  $admplanes=new admplanes;
  include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;
  include_once($ruta."class/admplan.php");
  $admplan=new admplan;
  include_once($ruta."class/reactivacion.php");
  $reactivacion=new reactivacion;
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Registro de Cobro";
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
          $idmenu=64;
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
                        <td style="<?php echo $styleP ?>"><?php echo $ddominio['nombre']; ?></td>                        
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
                <nav class="teal">
                  <div class="nav-wrapper <?php echo $classs ?>">
                    <div class="col s12">
                      <a href="#" class="brand-logo">REACTIVACION DE CUENTA</a>
                    </div>
                  </div>
                </nav>
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
                      <td><?php echo $dcar['fechaproxve'] ?></td>
                      <td><?php echo $dcar['diasmora']; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col s12 m6 l6">
                <div class="titulo">Datos de Factura</div>
                <div class="col s0 m12 l12">
                  <form class="col s12" id="idformfact" action="return false" onsubmit="return false" method="POST">
                    <div class="input-field  col s12 m5 l5">
                      <input id="idnit" value="<?php echo $dtit['nit'] ?>" name="idnit" type="text"  >
                      <label for="idnit">NIT/CI</label>
                    </div>
                    <div class="input-field  col s12 m5 l5">
                      <input id="idrazon" name="idrazon" value="<?php echo $dtit['razon'] ?>" type="text"  >
                      <label for="idrazon">NOMBRE/RAZON SOCIAL</label>
                    </div>
                    <div class="input-field  col s12 m2 l2">
                      <button id="btnSavefact" class="btn purple darken-3" style="width: 100%;"><i class="fa fa-save"></i></button>
                    </div>
                  </form>
                </div>
                <div class="titulo">Tarjeta</div>
                <div class="input-field col s12">
                  <input name="idtpago" value="1" onclick="deHabradio(1)" type="radio" checked id="test1" />
                  <label for="test1">Efectivo Bs.-</label>
                  <input name="idtpago" value="2" onclick="deHabradio(2)" type="radio" id="test2" />
                  <label for="test2">Tarjeta de Crédito</label>
                  <input name="idtpago" onclick="deHabradio(3)" value="3" type="radio" id="test3" />
                  <label for="test3">Tarjeta de Débito</label>
                </div>&nbsp;<br>
                <div class="col s0 m12 l12">
                  <div class="input-field  col s12 m6 l6">
                    <input id="idreferencia" readonly name="idreferencia" type="text">
                    <label for="idreferencia">Referencia</label>
                  </div>
                  <div class="input-field  col s12 m6 l6">
                    <input id="idlote" readonly name="idlote" type="text"  >
                    <label for="idlote">Lote</label>
                  </div>
                </div>
              </div>
              <div class="col s12 m6 l6">
                <h4 class="titulo">Realizar Cobro</h4>
                <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                  <table class="cssdato">
                    <tr>
                      <td class="sub" style="width: 45%;">ITEM</td>
                      <td style="border:2px solid #e20404;">
                        <select id="idselcuotas"  name="idselcuotas">
                          <option value="0">Seleccionar Item</option>
                          <?php
                            foreach($reactivacion->mostrarTodo("") as $f){
                              ?>
                                <option value="<?php echo $f['idreactivacion'] ?>"><?php echo $f['nombre'] ?></option>
                              <?php
                            }
                          ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="sub">Monto a Pagar</td>
                      <td class="inputn2">
                        <input type="number" value="0" name="idmonto" readonly step="any" id="idmonto">
                      </td>
                    </tr>
                    <tr>
                      <td class="sub">Pago a Saldo</td>
                      <td class="inputn2"><input type="text" name="iddescontable" id="iddescontable" value="0" readonly=""></td>
                    </tr>
                    <tr>
                      <td class="sub">Descuento</td>
                      <td class="inputn2"><input type="text" name="iddescuento" id="iddescuento" value="0" readonly=""></td>
                    </tr>
                    <tr>
                      <td class="sub">Adelanto</td>
                      <td class="inputn2"><input type="text" name="idadelanto" id="idadelanto" value="0" readonly=""></td>
                    </tr>
                    <tr>
                      <td class="sub">Cuotas Canceladas</td>
                      <td class="inputn2"><input type="text" name="idcuotas" id="idcuotas" value="0" readonly=""></td>
                    </tr>
                    <tr>
                      <td class="sub">Proximo Vence</td>
                      <td class="inputn2"><input type="date" name="idproxvence" id="idproxvence" readonly=""></td>
                    </tr>
                    <tr>
                      <td class="sub">
                        
                      </td>
                      <td class="inputn2">
                        <?php
                          if ($dcar['saldo']>0) {
                            ?>
                              <div id="card-alert" class="card red lighten-5">
                                <div class="card-content green-text">
                                  <p>No puede realizar esta operacion en este interfaz</p>
                                </div>
                              </div>
                            <?php
                          }
                          else{
                            ?>
                              <button id="btnSave" class="btn green darken-3" style="width: 100%;"><i class="fa fa-save"></i> Registrar Monto</button>
                            <?php
                          }
                        ?>
                      </td>
                    </tr>
                  </table>
                  <div class="col s12 m12 l12">
                    <input type="hidden" name="idoperacion" id="idoperacion" value="0">
                    <input type="text" name="idoptext" id="idoptext" placeholder="OPERACION...">
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
      $(document).ready(function() {
        $("#idselcuotas").change(function() {
          var idsel=$("#idselcuotas").val();
          $.ajax({
            async: true,
            url: "cargaDataSel.php?id="+idsel,
            type: "get",
            dataType: "html",
            success: function(data){
              console.log(data);
              var json = eval("("+data+")");
              $("#idmonto").val(json.monto);
              $("#iddescontable").val(json.descontable);
              $("#idadelanto").val(json.adelanto);
              $("#idcuotas").val(json.cuotas);
              $("#idproxvence").val(json.proxvence);
              $("#idoperacion").val(json.operacion);
              $("#idoptext").val(json.txtoperacion);
            }
          });
        });

        $("#idmonto").numeric(
          {decimalPlaces: 2,
          decimal : "."
          },
        );
        
      });
      $("#btnSavefact").click(function(){     
        var str = $("#idformfact").serialize();
        $.ajax({
          url: "guardaFactura.php",
          type: "POST",
          data: str+'&idtitular=<?php echo $idtitular2 ?>',
          success: function(resp){
            console.log(resp);
            $('#idresultado').html(resp);
          }
        });
      });
      $("#btnSave").click(function(){
        swal({   
            title: "Cobrar?",   
             text: "Esta Seguro de Realizar el Cobro?",   
             type: "warning",   
             showCancelButton: true,   
             closeOnConfirm: false,   
             showLoaderOnConfirm: true, }, 
             function(){
              if (validar()) {
                var tpago= $('input:radio[name=idtpago]:checked').val()
                var referencia=$('#idreferencia').val();
                var lote=$('#idlote').val();
                var strplus="&tpago="+tpago+"&idref="+referencia+"&idlote="+lote;
                //alert(strplus);
                $('#btnSave').attr("disabled",true);
                var str = $( "#idform" ).serialize();
                $.ajax({
                  url: "guardar.php",
                  type: "POST",
                  data: str+"&idcartera=<?php echo $valor ?>"+strplus,
                  success: function(resp){
                    
                    setTimeout(function(){     console.log(resp);
                    $('#idresultado').html(resp);   }, 2000); 
                  }
                });
              }
        });
      });
      function deHabradio(num){
        if (num==1) {
          $('#idreferencia').attr('readonly',true);
          $('#idlote').attr('readonly',true);
        }
        else{
          $('#idreferencia').attr('readonly',false);
          $('#idlote').attr('readonly',false);
        }
      }
      function validar(){
        retorno=true;        
        operacion=$("#idoperacion").val();
        if (operacion=="0") {
          retorno=false;
          swal(
            'Error','Tiene que Seleccionar el Monto','error'
          );
        }
        return retorno;
      }
    </script>
</body>

</html>