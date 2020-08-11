<?php
  $ruta="../../../../../";
  include_once($ruta."class/vejecutivopersona.php");
  $vejecutivopersona=new vejecutivopersona;
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
  $dcontrato=$admcontrato->mostrar($valor);
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
                  <h5 class="breadcrumbs-title">Registrar Nuevo Plan</h5>
                  <ol class="breadcrumbs">
                    <li><a href="../editar/?lblcode=<?php echo $lblcode ?>"> Persona y Facturación </a></li>
                    <li><a href="../domlab/?lblcode=<?php echo $lblcode ?>"> Domicilios y Trabajos</a></li>
                    <li class="activoTab"><a href="../plan/?lblcode=<?php echo $lblcode ?>"> Plan </a></li>
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
              <a href="nuevo/?lblcode=<?php echo $lblcode ?>" class="btn blue"><i class="fa fa-plus"></i> NUEVO</a>
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Plan</th>
                        <th>Contrato</th>
                        <th>Cuenta</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Plan</th>
                        <th>Contrato</th>
                        <th>Cuenta</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Acciones</th>
                    </tr>
                    </tr>
                </tfoot>
                <tbody>
                  <?php
                  foreach($personaplan->mostrarTodo("idpersona=".$dper['idpersona']) as $f)
                  {
                    $dplan=$admplan->mostrar($f['idadmplan']);
                    $dplan=array_shift($dplan);
                    $dcontrato=$admcontrato->mostrar($f['idcontrato']);
                    $dcontrato=array_shift($dcontrato);
                    $idperplan=ecUrl($f['idpersonaplan']);
                  ?>
                  <tr>
                    <td><?php echo $dplan['personas']." ".$dplan['nombre'] ?></td>
                    <td><?php echo $dcontrato['nrocontrato'] ?></td>
                    <td><?php echo $f['numcuenta'] ?></td>
                    <td><?php echo $f['fechainicio'] ?></td>
                    <td><?php echo $f['fechafin'] ?></td>
                    <td>
                    <?php
                      if ($f['idcontrato']==$lblcontrato) {
                    ?>
                      <a href="beneficiario/?lblcode=<?php echo $lblcode ?>&lblperplan=<?php echo $f['idpersonaplan'] ?>" class="btn-jh waves-effect waves-light light-blue darken-4"><i class="fa fa-users"></i> Beneficiarios</a>
                      <a href="../impresion/?lblcode=<?php echo $idperplan; ?>" target="_blank" class="btn-jh waves-effect waves-light orange darken-4"><i class="fa fa-print"></i> Imprimir Contrato</a>
                      <?php
                      }
                      else echo "--o--";
                    ?>
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
              </table>
              </div>
          </div>
          <?php
            include_once("../../../../footer.php");
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
      $('#idformdom').find('input, textarea, button, select').attr('disabled',true);
      $('#idformlab').find('input, textarea, button, select').attr('disabled',true);
      $('#example').DataTable({
        responsive: true
      });
      //habilita y deshabilita los campos de domicilio y laboral
      $('#iddomicilio').click(function() {
        if (!$(this).is(':checked')) {
          $('#idformdom').find('input, textarea, button, select').attr('disabled',true);
        }
        else{
          $('#idformdom').find('input, textarea, button, select').attr('disabled',false);
        }
      });
      $('#idtrabajo').click(function() {
        if (!$(this).is(':checked')) {
          $('#idformlab').find('input, textarea, button, select').attr('disabled',true);
        }
        else{
          $('#idformlab').find('input, textarea, button, select').attr('disabled',false);
        }
      });
      /**********************************************************************************/
      $("#btnSave").click(function(){
        var strDom = $( "#idformdom" ).serialize();
            var strTrab = $( "#idformlab" ).serialize();
            var str=strDom+"&"+strTrab
            var chkDom=0;
            var chkLab=0;
            if ($('#iddomicilio').is(':checked'))chkDom=1;
            if ($('#idtrabajo').is(':checked'))chkLab=1;
            var str=str+"&dom="+chkDom+"&lab="+chkLab+"&lblcode="+"<?php echo $lblcode ?>";
            //alert(str);
            swal({
                title: "CONFIRMACION",
                text: "Se guardara los datos ingresados", 
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