<?php
  $ruta="../../";
  include_once($ruta."class/admautorizacion.php");
  $admautorizacion=new admautorizacion;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;


  include_once($ruta."funciones/funciones.php");
  session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Administrar Autorizaciones ";
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
          $idmenu=71;
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
              <div class="row">
                <div id="modal1" class="modal ">
                  <div class="modal-content">
                  <h1 class="titulo" id="idtitulo">SOLICITUD APORBACION</h1>
                  <div class="col s12 m4 l4">La operacion no podra ser realizada hasta que se apruebe esta solicitid.
                  </div>
                  <div class="col s12 m8 l8">
                    <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                      <input type="hidden" name="idautorizacion" id="idautorizacion">
                      <div class="row">
                        <div class="input-field col s12">
                          <input id="idfecha" name="idfecha" readonly="true" type="text" class="validate">
                          <label for="idfecha">Fecha</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idusuario" name="idusuario" readonly="true" type="text" class="validate">
                          <label for="idusuario">Usuario Solicitante</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idestado" name="idestado" readonly="true" type="text" class="validate">
                          <label for="idestado">Estado</label>
                        </div>
                        <div class="input-field col s12">
                          <textarea id="idmotivo" name="idmotivo" readonly="true" class="materialize-textarea"></textarea>
                          <label for="idmotivo">Solicitud</label>
                        </div>
                        <div class="input-field col s12">
                          <textarea id="iddesc" name="iddesc" class="materialize-textarea"></textarea>
                          <label for="iddesc">Algun Comentario Para el Usuario</label>
                        </div>
                      </div>
                    </form>
                  </div>
                  </div>
                  <div class="modal-footer">
                   
                    <button id="btnSave1" href="#" class="btn waves-effect waves-light red"><i class="fa fa-times"></i> RECHAZAR SOLICITUD</button>
                    <button id="btnSave" href="#" class="btn waves-effect waves-light green"><i class="fa fa-save"></i> APROBAR SOLICITUD</button>
                  </div>
                </div>
              </div>
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>fecha</th>
                      <th>Usuario</th>
                      <th>Detalle</th>
                      <th>Desde</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>fecha</th>
                      <th>Usuario</th>
                      <th>Detalle</th>
                      <th>Desde</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $sw=true;
                    foreach($admautorizacion->mostrarTodo("estado=0") as $f)
                    {
                      $lblcode=ecUrl($f['idadmautorizacion']);
                      $dusuario=$usuario->muestra($f['usuariocreacion']);
                      $nusuario=$dusuario['usuario'];
                      $ddominio=$dominio->muestra($f['origen']);
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['fechacreacion'] ?></td>
                      <td><?php echo $nusuario ?></td>
                      <td><?php echo $f['detalle']; ?></td>
                      <td><?php echo $ddominio['nombre']; ?></td>
                      <td>
                        PENDIENTE
                      </td>
                      <td>
                        <button onclick="cargaDet('<?php echo $f['idadmautorizacion'] ?>');" href="#modal1" class="btn-jh waves-effect waves-light indigo modal-trigger"><i class="fa fa-check"></i> APROBAR</button>

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
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
      $("#btnSave").click(function(){
        guardar(1);
      });
      $("#btnSave1").click(function(){
        guardar(2);
      });
    });
    function guardar(estado){
      var str=$("#idform").serialize();
      $.ajax({
        url: "guardar.php",
        type: "POST",
        data: str+"&estado="+estado,
        success: function(resp){
          console.log(resp);
          $("#idresultado").html(resp);
        }
      });
    }
    function cargaDet(id){
      var str="id="+id;
      $.ajax({
        async: true,
        url: "recSolicitud.php?"+str,
        type: "get",
        dataType: "html",
        success: function(data){
          console.log(data);
          var json = eval("("+data+")");
          $("#idtitulo").html(json.titulo);
          $("#idfecha").val(json.fecha);
          $("#idusuario").val(json.usuario);
          $("#idestado").val(json.estado);
          $("#idmotivo").val(json.motivo);
          $("#idautorizacion").val(json.id);
        }
      });
    }
    </script>
</body>

</html>