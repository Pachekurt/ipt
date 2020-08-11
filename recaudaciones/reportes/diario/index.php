<?php
  $ruta="../../../";
  session_start();
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/cobcartera.php");
  $cobcartera=new cobcartera;
  include_once($ruta."class/cobcarteradet.php");
  $cobcarteradet=new cobcarteradet;
  include_once($ruta."class/vcarteradet.php");
  $vcarteradet=new vcarteradet;
  include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/factura.php");
  $factura=new factura;
  include_once($ruta."class/vfactura.php");
  $vfactura=new vfactura;
  include_once($ruta."class/factcliente.php");
  $factcliente=new factcliente;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
  $idsede=$_SESSION["idsede"];
  $dse=$sede->muestra($idsede);
  //echo $dse['nombre'];
  if (!isset($fechaGen)) {
    $fechaGen=date("Y-m-d");
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Parte diario de Cobranza";
    include_once($ruta."includes/head_basico.php");
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
          $idmenu=57;
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
                        <input id="idfecha" style="text-align: center;" name="idfecha" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                        <label for="idfecha">Fecha</label>
                      </div>
                      <div class="input-field col s3">
                        <label>SEDE</label>
                        <select id="idarea" name="idarea">
                          <?php
                            foreach($sede->mostrarTodo("") as $f)
                            {
                              ?>
                                <option value="<?php echo ecUrl($f['idsede']); ?>"><?php echo $f['nombre']; ?></option>
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
                    <h4 class="titulo">Configurar Parte Diario de Cobranza</h4>
                    <p style="text-align: justify;">
                      En esta pantalla deberás verificar la hora de cada transacción y hacer clic en el icono de guardar de cada una de las transacciones. Notaras que los colores de los botes cambian a un color verde, esto se debe a que la transacción ya está registrada.  Luego de que la tabla ya este ordenada y registrada correctamente, deberás guardar los datos haciendo clic en GUARDAR PARTE
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
                    <li class="tab col s3"><a class="white-text waves-effect waves-light" active href="#sapien">EFECTIVO</a></li>
                    <li class="tab col s3"><a class="white-text waves-effect waves-light " href="#activeone">TARJETA</a></li>
                    <li class="tab col s3"><a class="white-text waves-effect waves-light " href="#act">SERVICIOS ADICIONALES</a></li>
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
                            <th>Cta./Mat.</th>
                            <th>Moneda</th>
                            <th>Cuota</th>
                            <th>Saldo Ant.</th>
                            <th>Monto</th>
                            <th>Saldo Actual</th>
                            <th>Usuario</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach($vcarteradet->mostrarTodo("consolidado<2 and idsede=$idsede and tipopago=1 and fecha='$fechaGen'","fechacreacion,horacreacion") as $f)
                          {
                            $dcart=$cobcartera->muestra($f['idcartera']);
                            $dcont=$admcontrato->muestra($dcart['idcontrato']);
                            $dtit=$vtitular->muestra($dcont['idtitular']);
                            $dcp=$vcontratoplan->muestra($dcart['idcontrato']);
                            $restan=crestantes($dcart['monto']-$dcart['pagadoprod'],$dcart['saldo'],$dcp['cuotas']);
                            $totalCuotas=$dcp['cuotas']+1;
                            $dusuario=$usuario->muestra($f['usuariocreacion']);
                            $dfact=$factura->muestra($f['idfactura']);
                            $horat=$f['horacreacion'];
                            $fechadep=$f['fechacreacion'];
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
                                <input id="f<?php echo $f['idvcarteradet'] ?>" name="f<?php echo $f['idvcarteradet'] ?>" type="date" value="<?php echo $fechadep ?>" >
                              </div>
                            </td>
                            <td>
                              <div class="estIn">
                                <input type="time" id="c<?php echo $f['idvcarteradet'] ?>" name="c<?php echo $f['idvcarteradet'] ?>" value="<?php echo $horat ?>" max="23:59:00" min="01:00:00" step="1">
                              </div>
                            </td>
                            <td>
                              <div class="estIn">
                                <input type="text" name="o<?php echo $f['idvcarteradet'] ?>" id="o<?php echo $f['idvcarteradet'] ?>" value="<?php echo $f['obs'] ?>" >
                                <button onclick="guardaH('<?php echo $f['idvcarteradet'] ?>');" class="btn-jh <?php echo $btn ?>"><i class="fa fa-save"></i></button>
                              </div>
                            </td>
                            <td><?php echo $dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'] ?></td>
                            <td><?php echo $dcont['cuenta']." / ".$dcont['nrocontrato'] ?></td>                            
                            <td><?php echo $f['moneda'] ?></td>
                            <td><?php echo $f['cuota']."*".$totalCuotas ?></td>
                            <td><?php echo $f['saldoant'] ?></td>
                            <td><?php echo $f['monto'] ?></td>
                            <td><?php echo $f['saldo'] ?></td>
                            <td><?php echo $dusuario['usuario'] ?></td>
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
                            <th>Registro</th>
                            <th>Hora</th>
                            <th>Ingreso a Caja</th>
                            <th>Titular</th>
                            <th>Cta./Mat.</th>
                            <th>Factura</th>
                            <th>Moneda</th>
                            <th>Cuota</th>
                            <th>Saldo Ant.</th>
                            <th>Monto</th>
                            <th>Saldo Actual</th>
                            <th>Usuario</th>
                            <th>Observaciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach($vcarteradet->mostrarTodo("consolidado<2 and idsede=$idsede and tipopago>1 and fecha='$fechaGen'","fechacreacion,horacreacion") as $f)
                          {
                            $dcart=$cobcartera->muestra($f['idcartera']);
                            $dcont=$admcontrato->muestra($dcart['idcontrato']);
                            $dtit=$vtitular->muestra($dcont['idtitular']);
                            $dcp=$vcontratoplan->muestra($dcart['idcontrato']);
                            $restan=crestantes($dcart['monto']-$dcart['pagadoprod'],$dcart['saldo'],$dcp['cuotas']);
                            $totalCuotas=$dcp['cuotas']+1;
                            $dusuario=$usuario->muestra($f['usuariocreacion']);
                            $dfact=$factura->muestra($f['idfactura']);
                            $horat=$f['horacreacion'];
                            $fechadep=$f['fechacreacion'];
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
                                <input id="f<?php echo $f['idvcarteradet'] ?>" name="f<?php echo $f['idvcarteradet'] ?>" type="date" value="<?php echo $fechadep ?>" >
                              </div>
                            </td>
                            <td>
                              <div class="estIn">
                                <input type="time" id="c<?php echo $f['idvcarteradet'] ?>" name="c<?php echo $f['idvcarteradet'] ?>" value="<?php echo $horat ?>" max="23:59:00" min="01:00:00" step="1">
                              </div>
                            </td>
                            <td>
                              <div class="estIn">
                                <input type="text" name="o<?php echo $f['idvcarteradet'] ?>" id="o<?php echo $f['idvcarteradet'] ?>" value="<?php echo $f['obs'] ?>" >
                                <button onclick="guardaH('<?php echo $f['idvcarteradet'] ?>');" class="btn-jh <?php echo $btn ?>"><i class="fa fa-save"></i></button>
                              </div>
                            </td>
                            <td><?php echo $dtit['nombre']." ".$dtit['paterno']." ".$dtit['materno'] ?></td>
                            <td><?php echo $dcont['cuenta']." / ".$dcont['nrocontrato'] ?></td>                            
                            <td><?php echo $f['moneda'] ?></td>
                            <td><?php echo $f['cuota']."*".$totalCuotas ?></td>
                            <td><?php echo $f['saldoant'] ?></td>
                            <td><?php echo $f['monto'] ?></td>
                            <td><?php echo $f['saldo'] ?></td>
                            <td><?php echo $dusuario['usuario'] ?></td>
                          </tr>
                          <?php
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div id="act" class="col s12   ">
                  <div id="table-datatables">
                    <div class="row">
                      <table id="example2" class="display" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Factura</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Observaciones</th>
                            <th>Razon Social</th>
                            <th>Nit</th>
                            <th>Matricula</th>
                            <th>Monto</th>
                            <th>Usuario</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach($vfactura->mostrarTodo("tipotabla='SERV. AD.' and idsede=$idsede and consolidado<2 and estado=1 and fecha='$fechaGen'","nro") as $f)
                          {
                            $dcli=$factcliente->muestra($f['idtabla']);
                            $dusuario=$usuario->muestra($f['usuariocreacion']);
                            $horat=$f['horacreacion'];
                            $fechadep=$f['fechacreacion'];
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
                            <td><?php echo $f['nro'] ?></td>
                            <td>
                              <div class="estIn">
                                <input id="f<?php echo $f['idvfactura'] ?>" name="f<?php echo $f['idvfactura'] ?>" type="date" value="<?php echo $fechadep ?>" >
                              </div>
                            </td>
                            <td>
                              <div class="estIn">
                                <input type="time" id="c<?php echo $f['idvfactura'] ?>" name="c<?php echo $f['idvfactura'] ?>" value="<?php echo $horat ?>" max="22:30:00" min="10:00:00" step="1">
                              </div>
                            </td>
                            <td>
                              <div class="estIn">
                                <input type="text" name="o<?php echo $f['idvfactura'] ?>" id="o<?php echo $f['idvfactura'] ?>" value="<?php echo $f['obs'] ?>" >
                                <button onclick="guardaF('<?php echo $f['idvfactura'] ?>');" class="btn-jh <?php echo $btn ?>"><i class="fa fa-save"></i></button>
                              </div>
                            </td>
                            <td><?php echo $dcli['razon']; ?></td>
                            <td><?php echo $dcli['nit']; ?></td>
                            <td><?php echo $f['matricula'] ?></td>
                            <td><?php echo $f['total'] ?></td>
                            <td><?php echo $dusuario['usuario'] ?></td>
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
            include_once("../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
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
        var str="fecha="+fecha+"&hora="+hora+"&id="+id+"&obs="+obs;
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
      function guardaF(id){
        var fecha=$('#f'+id).val();
        var hora=$('#c'+id).val();
        var obs=$('#o'+id).val();
        var str="fecha="+fecha+"&hora="+hora+"&id="+id+"&obs="+obs;
        $.ajax({
          url: "guardarFact.php",
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
    </script>
</body>
</html>