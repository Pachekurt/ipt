<?php
  $ruta="../../../../";
  include_once($ruta."class/personaplan.php");
  $personaplan=new personaplan;
  include_once($ruta."class/admplan.php");
  $admplan=new admplan;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/titular.php");
  $titular=new titular;
  include_once($ruta."class/admcontratodelle.php");
  $admcontratodelle=new admcontratodelle;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/admorgani.php");
  $admorgani=new admorgani;
   include_once($ruta."class/admorganidet.php");
  $admorganidet=new admorganidet;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
  $idcontrato=dcUrl($lblcode);
  session_start();   
  $dsedUlt=$sede->mostrarUltimo("idsede=".$_SESSION["idsede"]);
  $record=$dsedUlt['ult_record']+1;
  $dcontrato=$admcontrato->mostrar($idcontrato);
  $dcontrato=array_shift($dcontrato);
  $idtitular2=$dcontrato['idtitular'];
  $dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
  $idpersona=$dtit['idpersona'];
  $dper=$persona->mostrar($dtit['idpersona']);
  $dper=array_shift($dper);

  $dsede=$sede->mostrar($dcontrato['idsede']);
  $dsede=array_shift($dsede);

  $destado=$dominio->mostrar($dcontrato['estado']);
  $destado=array_shift($destado);


  $dejec=$vejecutivo->muestra($dcontrato['idadmejecutivo']);

  $titulaper= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
  $ejecutivo= $dejec['nombre']." ".$dejec['paterno']." ".$dejec['materno'];

  $idpersona=ecUrl($dper['idpersona']);
  $idtitular=ecUrl($dcontrato['idtitular']);
  //echo "/*******************************/\n";
    $dperplan=$personaplan->mostrarUltimo("idcontrato=".$idcontrato." and idtitular=".$dcontrato['idtitular']);
    $dplan=$admplan->mostrar($dperplan['idadmplan']);
    $dplan=array_shift($dplan);
    $sww2=false;
    if (count($dperplan)<1) {
      $sww2=true;
    }
  //echo "/***************************/\n";
    $Saldo=$dcontrato['abono'];
    if ($dcontrato['abono']<0) {
      $Saldo=0;
    }
    /************ nuevas validaciones  **********/
  $dorgz=$admorganizacion->muestra($dejec['idorganizacion']);
  $nOrgz=$dorgz['nombre'];
  // validar que hay un organigrama vigente de su organizacion
  $dorg=$admorgani->mostrarUltimo("idadmorganizacion=".$dejec['idorganizacion']." and estado=1");
  $idorganigrama=$dorg['idadmorgani'];
  $dordet=$admorganidet->mostrarUltimo("idadmejecutivo=".$dcontrato['idadmejecutivo']." and idadmorgani=".$idorganigrama);
  $lblcod=ecUrl($idorganigrama);
  //   ACA FALTA LA VALIDACION QUE SIEMPRE HAYA UN ORGANIGRAMA ACTIVO
  $sww=false;
  if (count($dordet)<1) {
    $sww=true;
  }
  $styleP="background-color:#1bad97";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Record de Producción";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
    <style type="text/css">
      .inputn input{
        border: 1px solid #0565ff;
        text-align: center;
        padding: 2px;
      }
      .inputn3 input{
        border: 1px solid #f7a400;
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
          $idmenu=1000;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <?php
          if ($sww2) {
          ?>
          <div class="orange" id="breadcrumbs-wrapper">
            <center style="color: white;" > No hay un plan asignado por favor no siga con la operación </center>
          </div>
          <?php
            }
          ?>
          <?php
          if ($sww) {
          ?>
          <div class="orange" id="breadcrumbs-wrapper">
            <center style="color: white;" > <?php echo $ejecutivo; ?> no esta incluido en el organigrama vigente de su organización. Esto puede generar conflicos al realizar las operaciones. </center>
          </div>
          <?php
            }
          ?>
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
                <div class="col s7 m7 l7">
                  <table class="csscontrato">
                    <thead>
                      <tr>
                        <th>Ejecutivo</th>
                        <th>Titular</th>
                        <th>Contrato</th>
                        <th>Sede</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $ejecutivo ?></td>
                        <td><?php echo $titulaper ?></td>
                        <td><?php echo $dcontrato['nrocontrato'] ?></td>
                        <td><?php echo $dsede['nombre'] ?></td>
                        <td><?php echo $destado['nombre'] ?></td>
                        <td>
                          <a id="btnOrg" class="btn-jh waves-effect darken-4 purple"><i class="fa fa-sitemap"></i></a>
                          <a href="../acciones/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 red"><i class="fa fa-recycle"></i></a>
                          <a href="../imprimir/?lblcode=<?php echo $lblcode ?>" target="_blank" class="btn-jh waves-effect darken-4 indigo"><i class="fa fa-print"></i></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                  <div class="col s12 m12 l12">
                <table class="csstpago">
                  <thead>
                    <tr  style="<?php echo $styleP ?>">
                      <th>FECHA</th>
                      <th>PLAN</th>
                      <th>SALDO PROD.</th>
                      <th>NRO. RECORD</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo date('Y-m-d'); ?></td>
                      <td><?php echo $dplan['personas'].' '.$dplan['nombre'].' de '.$dplan['inversion'].' Bolivianos' ?></td>
                      <td><?php echo $Saldo ?></td>
                      <td><h6><b><?php echo $record ?></b></h6></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col s12 m6 l6">
                <div class="titulo">Datos de Factura</div>
                <div class="col s0 m12 l12">
                  <form class="col s12" id="idformfact" action="return false" onsubmit="return false" method="POST">
                    <div class="input-field col s5">
                      <input id="idrazon" name="idrazon" type="text" value="<?php echo $dtit['razon']; ?>" class="validate">
                      <label for="idrazon">Razon Social</label>
                    </div>
                    <div class="input-field col s5">
                      <input id="idnit" name="idnit" type="number" value="<?php echo $dtit['nit']; ?>" class="validate">
                      <label for="idnit">Nit</label>
                    </div>
                    <div class="input-field  col s12 m2 l2">
                      <button id="btnSavePer" class="btn purple darken-3" style="width: 100%;"><i class="fa fa-save"></i></button>
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
                  <input type="hidden" id="idcontrato" name="idcontrato" value="<?php echo $idcontrato ?>">
                  <table class="cssdato">
                    <tr>
                      <td class="sub">Monto a Pagar</td>
                      <td class="inputn">
                        <input type="number" value="<?php echo $Saldo ?>" name="idmonto" step="any" id="idmonto">
                      </td>
                    </tr>
                    <tr>
                      <td class="sub">Monto Dolares ($us)</td>
                      <td class="inputn3">
                        <input type="number" value="0" name="idmontoSus" step="any" id="idmontoSus">
                      </td>
                    </tr>
                    <tr>
                      <td class="sub">Monto A Pagar</td>
                      <td class="inputn2"><input type="text" name="idpagotot" id="idpagotot" value="0" readonly=""></td>
                    </tr>
                  </table>
                  <div class="col s12 m12 l12">
                    <input type="hidden" name="idoperacion" id="idoperacion" value="0">
                    <input type="text" name="idobs" id="idobs" placeholder="ALGUNA OBSERVACION ?">
                  </div>
                  <div class="col s12 m12 l6">
                    &nbsp;
                  </div>
                  <div class="col s12 m12 l6">
                    <?php
                      if (!$sww2) {
                        if ($dcontrato['estado']==62 || $dcontrato['estado']==68 || $dcontrato['estado']==63 || $dcontrato['estado']==65 || $dcontrato['estado']==67) {
                          ?>
                              <a style="width: 100%" id="btnSave" class="btn darken-3 waves-effect waves-light indigo"><i class="fa fa-save"></i> Registrar Record</a>
                          <?php
                        }
                      }
                    ?>
                  </div>
                  
                </form>
              </div>&nbsp;
                </div>
            </div>
            <div class="section">
              <div id="table-datatables">
                <div class="row">
                  <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Fecha</th>
                        <th>Moneda</th>
                        <th>Record</th>
                        <th>Monto</th>
                        <th>Saldo</th>
                        <th>Saldo Cartera</th>
                        <th>Observaciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach($admcontratodelle->mostrarTodo("idcontrato=$idcontrato and codigo=3113") as $f)
                      {
                        $estilo="";
                        if ($f['anulado']>0) {
                          $estilo="background-color:#f94f4f";
                        }
                      ?>
                      <tr style="<?php echo $estilo ?>">
                        <td><?php echo $f['fecha']." ".$f['hora'] ?></td>
                        <td><?php echo $f['moneda'] ?></td>
                        <td><?php echo $f['record'] ?></td>
                        <td><?php echo number_format($f['monto'], 2, '.', '') ?></td>
                        <td>
                          <?php 
                            if ($f['saldo']<0) {
                              echo "0";
                            }
                            else{
                              echo number_format($f['saldo'], 2, '.', '');
                            }
                          ?>
                        </td>
                        <td><?php echo number_format($f['saldocartera'], 2, '.', '') ?></td>
                        <td><?php echo $f['detalle'] ?></td>
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
            //include_once("../../../footer.php");
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
      $("#idmonto").focus();
      $("#idmonto").numeric(
        {decimalPlaces: 2,
        decimal : "."
        },
      );
      $("#idmonto").blur(function(){
        calculaPago();
      });
      $("#idmontoSus").blur(function(){
        calculaPago();
      });
      function calculaPago(){
        var monto=$("#idmonto").val();
        var dolares=$("#idmontoSus").val();
        //alert(monto);
        $.ajax({
          async: true,
          url: "cargaDataIn.php?monto="+monto+"&dolares="+dolares,
          type: "get",
          dataType: "html",
          success: function(data){
            console.log(data);
            var json = eval("("+data+")");
            if (json.ind==0) {
              $("#idpagotot").val(json.monto);
            }else{
              swal(
                'Cuidado',json.msg,'warning'
              );
            }
          }
        });
      }
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
      $("#btnOrg").click(function(){
        window.open("../../../organizacion/administrar/organigrama/data.php?lblcode=<?php echo $lblcod ?>" , "ventana1" , "width=1000,height=400,scrollbars=NO"); 
      });
      $('#example').DataTable({
        "bPaginate": false,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": false,
        responsive: true,
        "bAutoWidth": true,
      });
      $("#btnSave").click(function(){
        swal({   
          title: "Estas Seguro?",   
          text: "Se registrara el Record",   
          type: "warning",   
          showCancelButton: true,   
          closeOnConfirm: false,   
          showLoaderOnConfirm: true,
        }, 
        function(){
          //alert(str);
          if (validar()) {
            $('#btnSave').attr("disabled",true);
            var tpago= $('input:radio[name=idtpago]:checked').val()
            var referencia=$('#idreferencia').val();
            var lote=$('#idlote').val();
            var strplus="&tpago="+tpago+"&idref="+referencia+"&idlote="+lote;
            var str = $( "#idform" ).serialize();
            $.ajax({
              url: "guardar.php",
              type: "POST",
              data: str+strplus,
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
      $("#btnSavePer").click(function(){     
        var str = $( "#idformfact").serialize();
        $.ajax({
          url: "guardarTit.php",
          type: "POST",
          data: str+'&idtitular=<?php echo $idtitular2 ?>',
          success: function(resp){
            console.log(resp);
            $('#idresultado').html(resp);
          }
        });
      });
      function validar(){
        retorno=true;
        /*
        inicial=$("#idInicial").val();
        if (inicial=="") {
          retorno=false;
          Materialize.toast('<span>Numero Contrato Inicial Requerido</span>', 1500);
        }
        final=$("#idFinal").val();
        if (final=="") {
          retorno=false;
          Materialize.toast('<span>Numero de Contrato Final Requerido</span>', 1500);
        }
        if (parseInt(final)<parseInt(inicial)) {
          retorno=false;
          Materialize.toast('<span>El numero de contrato final no puede ser menor al inicial</span>', 1500);
        }*/
        return retorno;
      }
      $("#idcarnet" ).blur(function() { 
        ci = $("#idcarnet").val();
        $.ajax({
            url: "recTitular.php",
            type: "POST",
            data: "idcarnet="+ci
        }).done(function(respuesta){
            console.log(respuesta);
            var response = JSON.parse(respuesta);
            if (response.token === 1) {
                $("#idpersona").val(response.id);
                $("#idnombre").html("<div id='card-alert' class='card green'><div class='card-content white-text'><p><i class='mdi-navigation-check'></i>"+response.nombre+"</p></div> </div>");
            }
            else{
                $("#idcarnet").focus();
                $("#idnombre").html("No se encontro la persona. Intente de nuevo");
            }
        });
      });
    </script>
</body>

</html>