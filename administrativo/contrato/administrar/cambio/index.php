<?php
  $ruta="../../../../";
  session_start();
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/titular.php");
  $titular=new titular;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/admplanes.php");
  $admplanes=new admplanes;
  include_once($ruta."class/admplan.php");
  $admplan=new admplan;
  include_once($ruta."funciones/funciones.php");

  
   include_once($ruta."class/vplan.php");
  $vplan=new vplan;
  extract($_GET);
  $idcontrato=dcUrl($lblcode);
  $dcontrato=$admcontrato->mostrar($idcontrato);
  $dcontrato=array_shift($dcontrato);
  $idejecutivo=$dcontrato['idadmejecutivo'];
  $idtitular2=$dcontrato['idtitular'];
  $dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
  $idpersona=$dtit['idpersona'];
  $dper=$persona->muestra($dtit['idpersona']);
  $dsede=$sede->muestra($dcontrato['idsede']);
  $destado=$dominio->muestra($dcontrato['estado']);
  $dejecutivo=$vejecutivo->muestra($dcontrato['idadmejecutivo']);
  $titulaper= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
  $ejecutivo= $dejecutivo['nombre']." ".$dejecutivo['paterno']." ".$dejecutivo['materno'];
  $idorg=$dejecutivo['idorganizacion'];
 //$dplanes=$admplanes->mostrarTodo("estado=1");
 // $dplanes = array_shift($dplanes);


?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Cambio de Contrato";
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
          $idmenu=1000;
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
                        <th>Ejecutivo</th>
                        <th>Organizacion</th>
                        <th>Titular</th>
                        <th>Contrato</th>
                        <th>Sede</th>
                        <th>Estado</th>
                        <th>ACCIONES</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $ejecutivo ?></td>
                        <td><?php echo $dejecutivo['norganizacion'] ?></td>
                        <td><?php if ($dcontrato['estado']!=61) {
                         echo $titulaper;
                        }
                        else{
                          echo "Sin Registro de Titular";
                        } ?></td>
                        <td><?php echo $dcontrato['nrocontrato'] ?></td>
                        <td><?php echo $dsede['nombre'] ?></td>
                        <td><?php echo $destado['nombre'] ?></td>
                        <td><a class="btn-jh orange" href="../titular/plan/?lblcode=<?php echo $lblcode ?>">CAMBIO DE PLAN</a></td>
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
                <div class="col s12 m4 l3">
                  <h4 class="titulo">Cambio de Contrato</h4>
                  <p style="text-align: justify;">
                    Se realizara el cambio de contrato a otro asignado a <?php echo $ejecutivo  ?> en donde los abonos realizados pasaran al nuevo contrato. Posteriormente el contrato actual pasara a estado anulado.
                  </p>    
                </div>
                <div class="col s12 m8 l9">
                      <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                        <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                       <div class="row">
                          <div class="input-field col s12 m6 l6">
                            <input id="idfecha" name="idfecha" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                            <label for="idfecha">Fecha</label>
                          </div>
                          <div class="input-field col s12 m6 l6">
                            <input id="idhora" name="idhora" type="time" value="<?php echo date('H:i'); ?>" class="validate">
                            <label for="idhora">Hora</label>
                          </div>
                          <div class="input-field col s12">
                            <label>PLAN</label>
                            <select id="idplan" name="idplan">
                            <option value="0">Seleccionar Plan</option>
                            <?php
                              foreach($vplan->mostrarTodo("") as $f)
                              {
                                ?>
                                  <option value="<?php echo $f['idvplan']; ?>"><?php echo $f['nombre'] ." - ".$f['inversion']." Bs."; ?></option>
                                <?php
                              }
                            ?>

                            </select>
                          </div>
                          <div class="input-field col s12 m6 l6">
                            <input id="idaccion" type="text" name="idaccion" readonly="" value="CAMBIO DE CONTRATO" class="validate">
                            <label for="idaccion">ACCION</label>
                          </div>
                          <div class="input-field col s12 m6 l6">
                            <label>Seleccionar Contrato</label>
                            <select id="idcontratoNuevo" name="idcontratoNuevo">
                              <option disabled value="">Seleccionar Contrato...</option>
                              <?php
                              foreach($admcontrato->mostrarTodo("estado=61 and idadmejecutivo=$idejecutivo") as $f)
                              {
                                ?>
                                <option value="<?php echo $f['idadmcontrato']; ?>"><?php echo $f['nrocontrato'] ?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>
                          <div class="input-field col s12">
                            <textarea id="idobs" name="idobs" class="materialize-textarea"></textarea>
                            <label for="idobs">ALGO QUE DESEA AGREGAR ?</label>
                          </div>
                          <div class="input-field col s12 m6 l6">
                            <a style="width: 100%" href="../" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> VOLVER </a>
                          </div>
                          <div class="input-field col s12 m6 l6">
                            <a style="width: 100%" id="btnSave" class="btn waves-effect waves-light darken-3 green"><i class="fa fa-save"></i> REGISTRAR TRASPASO</a>
                          </div>
                        </div>
                      </form>
                </div>&nbsp;
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
    ?>
    <script type="text/javascript">
      $("#btnSave").click(function(){
        swal({
          title: "Estas Seguro?",
          text: "Con esta accion cambiaras el estado del contrato",
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