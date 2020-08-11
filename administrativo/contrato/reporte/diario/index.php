<?php
  $ruta="../../../../";
  session_start();
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;
  include_once($ruta."class/vcontratodet.php");
  $vcontratodet=new vcontratodet;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/factura.php");
  $factura=new factura;
  include_once($ruta."class/cobcartera.php");
  $cobcartera=new cobcartera;
  include_once($ruta."class/admcontratodelle.php");
  $admcontratodelle=new admcontratodelle;
  include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
  $idsede=$_SESSION["idsede"];
  $dse=$sede->muestra($idsede);
  if (!isset($fechaGen)) {
    $fechaGen=date("Y-m-d");
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Parte diario de Produccion-EN DESARROLLO";
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_tabla.php");
  ?>
  <style type="text/css">
    .estIn input{
      border:solid 1px #4286f4;
      width: 138px;
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
          $idmenu=54;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
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
                  <h4 class="titulo">Reporte Diario de Produccion</h4>
                  <p style="text-align: justify;">
                    Deberas verificar que no haya registros pendientes por consolidar.
                  </p>
                </div>
                <div class="col s12 m8 l9">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                    <div class="row">
                      <div class="input-field col s12 m6 l3">
                        <input id="idfecha" style="text-align: center;" name="idfecha" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                        <label for="idfecha">Fecha</label>
                      </div>
                      <div class="input-field col s3">
                        <label>SEDE</label>
                        <select id="idarea" name="idarea">
                          <?php
                            foreach($sede->mostrarTodo("") as $f)
                            {
                              $lblcode=ecUrl($f['idsede']);
                              ?>
                                <option value="<?php echo $lblcode; ?>"><?php echo $f['nombre']; ?></option>
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
                <div class="col s12 m12 l12">
                  <div class="col s12 m6 l6">
                    <h4 class="titulo">Configurar Parte Diario de Produccion</h4>
                    <p style="text-align: justify;">
                      En esta pantalla deberás verificar la hora de cada deposito y hacer clic en el icono de guardar. Notaras que los colores de los botes cambian a un color verde, esto se debe a que el registro ya está correcta.  Luego de que la tabla ordenada y registrada correctamente, deberás guardar los datos haciendo clic en GUARDAR PARTE
                    </p>
                  </div>
                  <div class="input-field col s12 m6 l3"><br><br>
                    <input type="date" name="idfechaCon" id="idfechaCon" value="<?php echo $fechaGen ?>">
                  </div>
                  <div class="input-field col s12 m6 l3"><br><br>
                    <a id="btnSave" class="btn waves-effect waves-light darken-3 green"><i class="fa fa-save"></i> GUARDAR PARTE</a>
                  </div>
                </div>
                <div class="col s12">
                  <ul class="tabs tab-demo-active z-depth-1 cyan">
                    <li class="tab col s3"><a class="white-text waves-effect waves-light" active href="#sapien">DEPOSITOS</a></li>
                    <li class="tab col s3"><a class="white-text waves-effect waves-light " href="#activeone">PAGO POR TARJETAS</a></li>
                  </ul>
                </div>
                <div id="sapien" class="col s12   ">
                  <div id="table-datatables">
                    <div class="row">
                      <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Factura</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Observaciones</th>
                            <th>Titular</th>
                            <th>Matricula</th>
                            <th>Record</th>
                            <th>Ejecutivo</th>
                            <th>Monto</th>
                            <th>Saldo</th>
                            <th>Saldo Cartera</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach($vcontratodet->mostrarTodo("consolidado<2 and anulado=0 and idsede=$idsede and tiopago=1 and fecha='$fechaGen'","horadep") as $f)
                          {
                            $dcont=$admcontrato->muestra($f['idadmcontrato']);
                            $dtit=$vtitular->muestra($dcont['idtitular']);
                            $deje=$vejecutivo->muestra($dcont['idadmejecutivo']);
                            $dcp=$vcontratoplan->muestra($f['idadmcontrato']);
                            $saldoCartera=$dcp['inversion']-$dcont['pagado'];
                            $totalCuotas=$dcp['cuotas']+1;
                            $dusuario=$usuario->muestra($f['usuariocreacion']);
                            $dfact=$factura->muestra($f['idfactura']);
                            $horat=$f['hora'];
                            $fechadep=$f['fecha'];
                            $saldoC=$f['saldo'];
                            if($saldoC<0)$saldoC=0;
                            $btn="green";
                            //verificar fecha de deposito
                            if ($f['fechadep']=="0000-00-00"){
                              $btn="red";
                            }else{
                              $fechadep=$f['fechadep'];
                            }
                            if ($f['horadep']=="00:00:00"){
                              $btn="red";
                            }else{
                              $horat=$f['horadep'];
                            }
                          ?>
                          <tr>
                            <td><?php echo $dfact['nro'] ?></td>
                            <td>
                              <div class="estIn">
                                <input type="date" id="f<?php echo $f['idvcontratodet'] ?>" name="f<?php echo $f['idvcontratodet'] ?>" value="<?php echo $fechadep ?>">
                              </div>
                            </td>
                            <td>
                              <div class="estIn">
                                <input type="time" id="c<?php echo $f['idvcontratodet'] ?>" name="c<?php echo $f['idvcontratodet'] ?>" value="<?php echo $horat ?>" max="22:30:00" min="10:00:00" step="1">
                              </div>
                            </td>
                            <td>
                              <div class="estIn">
                                <input type="text" style="font-size: 10px;" name="o<?php echo $f['idvcontratodet'] ?>" id="o<?php echo $f['idvcontratodet'] ?>" value="<?php echo $f['obs'] ?>">
                                <button onclick="guardaH('<?php echo $f['idvcontratodet'] ?>');" class="btn-jh <?php echo $btn ?>"><i class="fa fa-save"></i></button>
                              </div>
                            </td>
                            <td><?php echo $dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'] ?></td>
                            <td><?php echo $dcont['nrocontrato'] ?></td>
                            
                            <td><?php echo $f['record'] ?></td>
                            <td><?php echo $deje['nombre']." ".$deje['paterno'] ?></td>
                            <td><?php echo $f['monto'] ?></td>
                            <td><?php echo $saldoC ?></td>
                            <td><?php echo $saldoCartera; ?></td>
                            
                          </tr>
                          <?php
                            }
                          ?>
                        </tbody>
                      </table>
                      <div class="divider"><br><br></div>
                      <div class="titulo">Facturas Anuladas</div>
                      <table id="example5" class="display" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Nro Contrato</th>
                            <th>Observaciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach($admcontratodelle->mostrarTodo("codigo in (3115,3119) and idsede=$idsede and fecha='$fechaGen'","horadep") as $g)
                          {
                            $dct=$admcontrato->muestra($g['idcontrato']);
                          ?>
                          <tr>
                            <td><?php echo $dct['nrocontrato'] ?></td>
                            <td><?php echo $g['detalle'] ?></td>
                          </tr>
                          <?php
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div id="activeone" class="col s12   ">
                  <div id="table-datatables">
                    <div class="row">
                      <table id="example1" class="display" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Factura</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Observaciones</th>
                            <th>Titular</th>
                            <th>Matricula</th>
                            <th>Record</th>
                            <th>Ejecutivo</th>
                            <th>Monto</th>
                            <th>Referencia</th>
                            <th>Lote</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach($vcontratodet->mostrarTodo("consolidado<2 and anulado=0 and idsede=$idsede and tiopago>1 and fecha='$fechaGen'","") as $f)
                          {
                            $dcont=$admcontrato->muestra($f['idadmcontrato']);
                            $dtit=$vtitular->muestra($dcont['idtitular']);
                            $deje=$vejecutivo->muestra($dcont['idadmejecutivo']);
                            $dcp=$vcontratoplan->muestra($f['idadmcontrato']);
                            $saldoCartera=$dcp['inversion']-$dcont['pagado'];
                            $totalCuotas=$dcp['cuotas']+1;
                            $dusuario=$usuario->muestra($f['usuariocreacion']);
                            $dfact=$factura->muestra($f['idfactura']);
                            $horat=$f['hora'];
                            $fechadep=$f['fecha'];
                            $saldoC=$f['saldo'];
                            if($saldoC<0)$saldoC=0;
                            $btn="green";
                            //verificar fecha de deposito
                            if ($f['fechadep']=="0000-00-00"){
                              $btn="red";
                            }else{
                              $fechadep=$f['fechadep'];
                            }
                            if ($f['horadep']=="00:00:00"){
                              $btn="red";
                            }else{
                              $horat=$f['horadep'];
                            }
                          ?>
                          <tr>
                            <td><?php echo $dfact['nro'] ?></td>
                            <td>
                              <div class="estIn">
                                <input type="date" id="f<?php echo $f['idvcontratodet'] ?>" name="f<?php echo $f['idvcontratodet'] ?>" value="<?php echo $fechadep ?>">
                              </div>
                            </td>
                            <td>
                              <div class="estIn">
                                <input type="time" id="c<?php echo $f['idvcontratodet'] ?>" name="c<?php echo $f['idvcontratodet'] ?>" value="<?php echo $horat ?>" max="22:30:00" min="10:00:00" step="1">
                              </div>
                            </td>
                            <td>
                              <div class="estIn">
                                <input type="text" style="font-size: 10px;" name="o<?php echo $f['idvcontratodet'] ?>" id="o<?php echo $f['idvcontratodet'] ?>" value="<?php echo $f['obs'] ?>" >
                                <button onclick="guardaH('<?php echo $f['idvcontratodet'] ?>');" class="btn-jh <?php echo $btn ?>"><i class="fa fa-save"></i></button>
                              </div>
                            </td>
                            <td><?php echo $dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'] ?></td>
                            <td><?php echo $dcont['nrocontrato'] ?></td>
                            
                            <td><?php echo $f['record'] ?></td>
                            <td><?php echo $deje['nombre']." ".$deje['paterno'] ?></td>
                            <td><?php echo $f['monto'] ?></td>
                            <td><?php echo $f['referencia'] ?></td>
                            <td><?php echo $f['lote']; ?></td>
                            
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
        idsede=$("#idarea").val();
        window.open("imprimir/?fechaGen="+$("#idfecha").val()+"&lblcode="+idsede,"_blank");
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
        var fecha=$('#f'+id).val();
        var hora=$('#c'+id).val();
        var obs=$('#o'+id).val();
        var str="hora="+hora+"&id="+id+"&obs="+obs+"&fecha="+fecha;
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
    </script>
</body>
</html>