<?php
  $ruta="../../../";
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
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
  $idcontrato=dcUrl($lblcode);
  $dcontrato=$admcontrato->mostrar($idcontrato);
  $dcontrato=array_shift($dcontrato);
  $idtitular2=$dcontrato['idtitular'];
  $dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
  $idpersona=$dtit['idpersona'];
  $dper=$persona->muestra($dtit['idpersona']);
  $dsede=$sede->muestra($dcontrato['idsede']);
  $destado=$dominio->muestra($dcontrato['estado']);
  $dejecutivo=$vejecutivo->muestra($dcontrato['idadmejecutivo']);
  $titulaper= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
  $ejecutivo= $dejecutivo['nombre']." ".$dejecutivo['paterno']." ".$dejecutivo['materno'];
  $idpersona=ecUrl($dper['idpersona']);
  $idtitular=ecUrl($dcontrato['idtitular']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Anular Contrato";
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
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $ejecutivo ?></td>
                        <td><?php if ($dcontrato['estado']!=61) {
                         echo $titulaper;
                        }
                        else{
                          echo "Sin Registro de Titular";
                        } ?></td>
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
                <div class="col s12 m12 l12">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input id="idcontrato" name="idcontrato" type="hidden" readonly value="<?php echo $idcontrato ?>" class="validate">
                    <h4 class="header"><a href="../" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> Ingrese los datos</h4>
                    <div class="formcontent">
                      <div class="row">
                        <div class="input-field col s4">
                          <input id="idfecha" name="idfecha" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                          <label for="idfecha">Fecha</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="idhora" name="idhora" type="time" value="<?php echo date('H:i'); ?>" class="validate">
                          <label for="idhora">Hora</label>
                        </div>
                        <div class="input-field col s4">
                          <label>Accion</label>
                          <select id="idaccion" name="idaccion">
                            <option value="64">CONTRATOS ANULADOS SIN DEVOLVER</option>
                          </select>
                        </div>
                        <div class="input-field col s8">
                          <input id="idobs" name="idobs" type="text"  class="validate">
                          <label for="idobs">DETALLE DEL CONTRATO</label>
                        </div>
                        <div class="input-field col s4">
                          <a id="btnSave" class="btn waves-effect waves-light indigo"><i class="fa fa-save"></i> Anular Contrato</a>
                        </div>
                      </div>
                    </div>
                  </form>
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
      $("#btnSave").click(function(){
        swal({
          title: "Estas Seguro?",
          text: "ANULARAS EL CONTRATO",
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