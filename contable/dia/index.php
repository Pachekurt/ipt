<?php
  $ruta="../../";
  session_start();
  include_once($ruta."class/ctbdia.php");
  $ctbdia=new ctbdia;
  include_once($ruta."class/admgestion.php");
  $admgestion=new admgestion;
  $fecha=date("Y-m-d");

  include_once($ruta."funciones/funciones.php");
  $ddia=$ctbdia->mostrarUltimo("fecha='$fecha'");
  $sww=false;
  if (count($ddia)<1) {
    $sww=true;
  }
  $dgestion=$admgestion->muestra($ddia['idgestion']);
  $gestion=$dgestion['anio'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Traspaso de Contrato";
    include_once($ruta."includes/head_basico.php");
  ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=5;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <?php
          if ($sww) {
          ?>
          <div class="red" id="breadcrumbs-wrapper">
            <center style="color: white;" ><b>ALERTA:</b> El dia Actual no esta Abierto.</center>
          </div>
          <?php
            }
            else{
              ?>
                <div class="green" id="breadcrumbs-wrapper">
                  <center style="color: white;" >Dia Contable Abierto</center>
                </div>
              <?php
            }
          ?>

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
                        <th>Gestion</th>
                        <th>Fecha</th>
                        <th>T/C</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $gestion ?></td>
                        <td><?php echo $fecha ?></td>
                        <td><?php echo $ddia['dolar'] ?></td>
                        <td>
                          <a href="feriados/" style="color: green; font-weight: bold;" class="btn-jh waves-effect darken-1 yellow"><i class="fa fa-calendar"></i> Feriados</a>
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
              <div class="formcontent">
                <div class="col s12 m6 l6">
                  <h4 class="titulo">Dias Pendientes sin Iniciar</h4>
                  <table class="tablabasico">
                    <thead>
                      <tr>
                        <th>Fecha</th>
                        <th width="120px">Dolar</th>
                        <th>Estado</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>2017-05-05</td>
                        <td><input type="number" name="" value="6.96"></td>
                        <td> Cerrado</td>
                      </tr>
                      <tr>
                        <td>2017-05-06</td>
                        <td><input type="number" width="50px;" name="" value="6.96"></td>
                        <td> Cerrado</td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="input-field col s12 m6 l6">
                    <a style="width: 100%" id="btnCerrarDias" class="btn waves-effect waves-light darken-3 orange"><i class="fa fa-save"></i> CERRAR DIAS PENDIENTES</a>&nbsp;
                  </div>
                </div>
                <div class="col s12 m6 l6">
                  <h4 class="titulo">Iniciar Dia</h4>
                      <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                        <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                       <div class="row">
                          <div class="input-field col s12 m6 l6">
                            <input id="idfecha" name="idfecha" type="date" readonly="" value="<?php echo date('Y-m-d'); ?>" class="validate">
                            <label for="idfecha">Ultima fecha abierta</label>
                          </div>
                          <div class="input-field col s12 m6 l6">
                            <input id="idhora" name="idhora" type="text" readonly="" value="6.96" class="validate">
                            <label for="idhora">Ultimo tipo de Cambio</label>
                          </div>
                          <div class="input-field col s12 m6 l6">
                            <input id="idfecha" name="idfecha" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                            <label for="idfecha">Fecha Actual</label>
                          </div>
                          <div class="input-field col s12 m6 l6">
                            <input id="iddolar" name="iddolar" type="text" value="6.96" class="validate">
                            <label for="iddolar">Dolar</label>
                          </div>
                          <div class="input-field col s12 m6 l6">
                            <a style="width: 100%" href="../" class="btn waves-effect waves-light blue"><i class="fa fa-database"></i> Historial Dias </a>
                          </div>
                          <div class="input-field col s12 m6 l6">
                             <?php
                            if ($sww) {
                            ?>
                            <a style="width: 100%" id="btnSave" class="btn waves-effect waves-light darken-3 green"><i class="fa fa-save"></i> INICIAR DIA</a>
                            <?php
                              }
                            ?>
                            
                          </div>
                        </div>
                      </form>
                </div>&nbsp;
              </div>
            </div>
          </div>
          <?php
            include_once("../footer.php");
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
          title: "Estas Seguro?",
          text: "Iniciar Dia Contable",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {
          if (validar()) {        
            $('#btnSave').attr("disabled",true);
            var str = $( "#idform" ).serialize();
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
    </script>
</body>

</html>