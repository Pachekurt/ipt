<?php
  $ruta="../../";
  include_once($ruta."class/vfactura.php");
  $vfactura=new vfactura;
  include_once($ruta."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($ruta."class/admdosificacion.php");
  $admdosificacion=new admdosificacion;
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $idsede=$_SESSION["idsede"];
  $dse=$sede->muestra($idsede);

  $dsuc=$admsucursal->mostrarUltimo("idsede=".$idsede);
  $idsucursal=$dsuc['idadmsucursal'];
  $ddos=$admdosificacion->mostrarUltimo("idadmsucursal=".$idsucursal." and estado=1");
  $iddos=$ddos['idadmdosificacion'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Administrar Facturas ".$dse['nombre'];
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_tabla.php");
    include_once($ruta."includes/head_tablax.php");
  ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=32;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <a href="anteriores/" target="_blank" class="btn blue">FACTURAS ANTERIORES</a><br><br>
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Nro</th>
                      <th>Desde</th>
                      <th>Matricula</th>
                      <th>Monto</th>
                      <th>Sede</th>
                      <th>Usuario</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sw=true;
                    foreach($vfactura->mostrarTodo("idsede=$idsede and idsucursal=$idsucursal and iddosificacion=$iddos") as $f)
                    {
                      $lblcode=ecUrl($f['idvfactura']);
                      $dsuc=$admsucursal->muestra($f['idsucursal']);
                      $dsede=$sede->muestra($dsuc['idsede']);
                      switch ($f['estado']) {
                        case '1':
                          $estilo="background-color: #aaffb4;";
                        break;
                        case '2':
                          $estilo="background-color: #ff9395;";
                        break;
                        case '3':
                          $estilo="background-color: #41f462;";
                        break;
                        case '4':
                          $estilo="background-color: #f46741;";
                        break;
                      }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['fecha']." ".$f['horacreacion'] ?></td>
                      <td><?php echo $f['nro'] ?></td>
                      <td>
                        <?php 
                          switch ($f['tipotabla']) {
                            case 'CART':
                              echo "RECAUDACIONES";
                              break;
                            case 'RECO':
                              echo "PRODUCCION";
                              break;
                            case 'SERV. AD.':
                              echo "SERVICIOS ADICIONALES";
                              break;
                          }
                        ?>
                      </td>
                      <td><?php echo $f['matricula'] ?></td>
                      <td><?php echo $f['total'] ?></td>
                      <td><?php echo $dsede['nombre'] ?></td>
                      <td>
                        <?php 
                          $dus=$usuario->muestra($f['usuariocreacion']);
                          echo $dus['usuario'];
                        ?>
                      </td>
                      <td>
                        <?php 
                          switch ($f['estado']) {
                            case '1':
                              echo "VALIDA";
                            break;
                            case '2':
                              echo "ANULADA";
                            break;
                            case '3':
                              $estilo="";
                            break;
                            case '4':
                              $estilo="";
                            break;
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          switch ($f['estado']) {
                            case '1':
                              ?>
                                <a href="../impresion/computarizada/?lblcode=<?php echo $lblcode ?>" target="_blank" class="btn-jh blue"><i class="mdi-action-print"></i> </a>
                              <?php
                            break;
                            case '2':

                              
                                switch ($f['tipotabla']) {
                                  case 'CART':
                                    ?>
                                    <!--
                                      <button onclick="cargaDet('<?php //echo $f['idestado'] ?>');"  href="#modal1" class="btn-jh waves-effect waves-light purple modal-trigger"><i class="mdi-image-remove-red-eye"></i> VER RAZON DE ANULACION</button>
                                    -->
                                    <?php
                                    break;
                                  case 'RECO':
                                    echo " ";
                                    break;
                                  case 'SERV. AD.':
                                    echo " ";
                                    break;
                                }
                        
                              
                            break;
                            case '3':
                              $estilo="background-color: #41f462;";
                            break;
                            case '4':
                              $estilo="background-color: #f46741;";
                            break;
                          }
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
          </div>
          <?php
            include_once("../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div class="row">
      
    <div id="modal1" class="modal ">
      <div class="modal-content">
        
        <div class="col s12 m12 l12">A continuación de despliega la solicitud y aprobación de la anulacion de la factura.
        </div>
        <div class="divider"></div>
        <div class="col s12 m6 l6">
          <h1 class="titulo" id="idtitulo">Solicitud de Anulacion</h1>
          <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
            <input type="hidden" name="idautorizacion" id="idautorizacion">
            <div class="row">
              <div class="input-field col s12">
                <input id="iddetalle" name="iddetalle" readonly="true" type="text" class="validate">
                <label for="iddetalle">Detalle</label>
              </div>
              <div class="input-field col s12">
                <input id="idusuario" name="idusuario" readonly="true" type="text" class="validate">
                <label for="idusuario">Usuario Solicitante</label>
              </div>
              <div class="input-field col s12">
                <input id="idfecha" name="idfecha" readonly="true" type="text" class="validate">
                <label for="idfecha">Fecha</label>
              </div>
              <div class="input-field col s12">
                <textarea id="idmotivo" name="idmotivo" readonly="true" class="materialize-textarea"></textarea>
                <label for="idmotivo">Motivo</label>
              </div>
            </div>
          </form>
        </div>
        <div class="col s12 m6 l6">
          <h1 class="titulo" id="idtitulo">Aprobacion de Anulacion</h1>
          <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
            <input type="hidden" name="idautorizacion" id="idautorizacion">
            <div class="row">
              <div class="input-field col s12">
                <input id="idestado" name="idestado" readonly="true" type="text" class="validate">
                <label for="idestado">Estado</label>
              </div>
              <div class="input-field col s12">
                <input id="idusAprob" name="idusAprob" readonly="true" type="text" class="validate">
                <label for="idusAprob">Usuario Autoriza</label>
              </div>
              <div class="input-field col s12">
                <input id="idfechaAut" name="idfechaAut" readonly="true" type="text" class="validate">
                <label for="idfechaAut">Fecha Autoriza</label>
              </div>
              <div class="input-field col s12">
                <textarea id="idrecomendacion" name="idrecomendacion" readonly="true" class="materialize-textarea"></textarea>
                <label for="idrecomendacion">Recomendacion</label>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    </div>
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
    $( "#idsede" ).change(function() {
      location.href="?lblcode="+$('select[name=idsede]').val();
    });
    $(document).ready(function() {
      $('#example').DataTable({
        dom: 'Bfrtip',
        "order": [[ 1, "desc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });
    function cargaDet(id){
      var str="id="+id;
      $.ajax({
        async: true,
        url: "../../administracion/autorizacion/verSolicitud.php?"+str,
        type: "get",
        dataType: "html",
        success: function(data){
          console.log(data);
          var json = eval("("+data+")");
          $("#iddetalle").val(json.detalle);
          $("#idusuario").val(json.usuarioSol);
          $("#idfecha").val(json.fechaSol);
          $("#idmotivo").val(json.motivoSol);
          $("#idestado").val(json.estado);
          $("#idusAprob").val(json.usuarioAut);
          $("#idfechaAut").val(json.fechaAut);
          $("#idrecomendacion").val(json.comentarioAut);
        }
      });
    }
    </script>
</body>

</html>