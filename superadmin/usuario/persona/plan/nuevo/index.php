<?php
  $ruta="../../../../../../";
  include_once($ruta."class/vejecutivopersona.php");
  $vejecutivopersona=new vejecutivopersona;
  include_once($ruta."class/admplanes.php");
  $admplanes=new admplanes;
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
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);

  $valor=dcUrl($lblcode);
  $lblcontrato=$valor;
  if (!ctype_digit(strval($valor))) {
    if (!isset($_SESSION["faltaSistema"]))
    {  $_SESSION['faltaSistema']="0"; }
    $_SESSION['faltaSistema']=$_SESSION['faltaSistema']+1;
    ?>
      <script type="text/javascript">
        ruta="<?php echo $ruta ?>login/salir.php";
        window.location=ruta;
      </script>
    <?php
  }
  $idcontrato=dcUrl($lblcode);
  $lblcontrato=$idcontrato;
  $dcontrato=$admcontrato->mostrar($idcontrato);
  $dcontrato=array_shift($dcontrato);

  $dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
  $dper=$persona->mostrar($dtit['idpersona']);
  $dper=array_shift($dper);

  $dsede=$sede->mostrar($dcontrato['idsede']);
  $dsede=array_shift($dsede);

  $destado=$dominio->mostrar($dcontrato['estado']);
  $destado=array_shift($destado);


  $dejecutivo=$vejecutivopersona->mostrar($dcontrato['idadmejecutivo']);
  $dejecutivo=array_shift($dejecutivo);

  $titulaper= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
  $ejecutivo= $dejecutivo['nombre']." ".$dejecutivo['paterno']." ".$dejecutivo['materno'];

  $dplanes=$admplanes->mostrarUltimo("estado=1");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Registrar Plan";
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
          $idmenu=26;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title">Registrar Plan</h5>
                  <ol class="breadcrumbs">
                    <li><a href="../../editar/?lblcode=<?php echo $lblcode ?>"> Persona y Facturación </a></li>
                    <li><a href="../../domlab/?lblcode=<?php echo $lblcode ?>"> Domicilios y Trabajos</a></li>
                    <li class="activoTab"><a href="../../plan/?lblcode=<?php echo $lblcode ?>"> Plan </a></li>
                  </ol>
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
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $ejecutivo ?></td>
                        <td><?php echo $titulaper ?></td>
                        <td><?php echo $dcontrato['nrocontrato'] ?></td>
                        <td><?php echo $dsede['nombre'] ?></td>
                        <td><?php echo $destado['nombre'] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
              <input id="idpersona" name="idpersona" value="<?php echo $dtit['idpersona'] ?>" type="hidden">
                <div class="col s6 m6 l6">
                    <h4 class="header">Seleccionar Plan</h4>
                    <div class="formcontent">
                      <div class="row">
                        <div class="input-field col s12">
                          <label>PLAN</label>
                          <select onchange="cargaDato(this);" id="idplan" name="idplan">
                            <option value="0">Seleccionar Plan</option>
                            <?php
                              foreach($admplan->mostrarTodo("idadmplanes=".$dplanes['idadmplanes']) as $f)
                              {
                                ?>
                                  <option value="<?php echo $f['idadmplan']; ?>"><?php echo $f['personas']." ".$f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12">
                          <input id="idcosto" name="idcosto" readonly type="text" class="validate">
                          <label for="idcosto">Costo Total</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idprimerpago" name="idprimerpago" readonly type="text" class="validate">
                          <label for="idprimerpago">Primer Pago</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idmensualidad" name="idmensualidad" readonly type="text" class="validate active">
                          <label for="idmensualidad">Pagos Mensuales</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idcuotas" name="idcuotas" readonly type="text" class="validate">
                          <label for="idcuotas">Cantidad de Cuotas</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idpersonas" name="idpersonas" readonly type="text" class="validate">
                          <label for="idpersonas">Cantidad de Personas</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idfechaInicio" name="idfechaInicio" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                          <label for="idfechaInicio">Fecha Inicio del Plan</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idcuenta" name="idcuenta" type="number" value="0" class="validate">
                          <label for="idcuenta">Cuenta</label>
                        </div>
                        <div class="input-field col s12">
                          <input name="idmaterial" type="checkbox" id="idmaterial" />
                          <label for="idmaterial">Material entregado?</label>
                        </div>&nbsp;
                        <div class="input-field col s12">
                          <textarea id="idobs" name="idobs" class="materialize-textarea"></textarea>
                          <label for="idobs">Observaciones</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <a id="btnLimpiar" class="btn waves-effect waves-light orange"><i class="fa fa-save"></i> Limpiar</a>
                          <a id="btnSave" class="btn waves-effect waves-light green"><i class="fa fa-save"></i> Asignar Plan</a>
                        </div>
                      </div>
                    </div>
                </div>
              </form>
            </div>
          </div>
          <?php
            include_once("../../../../../footer.php");
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
      /**********************************************************************************/
      $("#btnSave").click(function(){
        var planVal1 = $("#idplan").val();
        if (planVal1 != '0')
        {
        var str = $( "#idform" ).serialize();
        str=str+"&lblcode="+"<?php echo $lblcode ?>"+"&lblcontrato=<?php echo $lblcontrato ?>";
        //alert(str);
        swal({
            title: "CONFIRMACION",
            text: "Se asignara el plan al titular", 
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "GUARDAR",
            closeOnConfirm: false
          }, function () {
            $.ajax({
              url: "guardar.php",
              type: "POST",
              data: str,
              success: function(resp){
                console.log(resp);
                 $("#idresultado").html(resp);
              }
            }); 
          });
        }
        else{
          sweetAlert("Oops...", "Debes seleccionar un plan!", "error");
        }
      });
    }); 
    function cargaDato(id){
      //alert(id.value);
      $.ajax({
        async: true,
        url: "cargarPlan.php?id="+id.value,
        type: "get",
        dataType: "html",
        success: function(data){
          console.log(data);
          var json = eval("("+data+")");
          $("#idcosto").val(json.precio);
          $("#idprimerpago").val(json.pagoInicial);
          $("#idmensualidad").val(json.pagoMensual);
          $("#idcuotas").val(json.mesesPlazo);
          $("#idpersonas").val(json.personas);
        }
      });
    }
    </script>
</body>

</html>