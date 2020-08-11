<?php
  $ruta="../../";
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Organizaciones";
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
          $idmenu=38;
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
              <div id="table-datatables">
              <a href="#modal1" class="btn waves-effect waves-light indigo modal-trigger"><i class="fa fa-plus-square"></i> Nueva Organizacion</a>

                <div id="modal1" class="modal">
                  <div class="modal-content">
                  <h1>Nueva Organizacion</h1>
                    <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                      <div class="row">
                        <div class="input-field col s12">
                          <input id="idnombre" name="idnombre" id="first_name" type="text" class="validate">
                          <label for="first_name">Nombre</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <label>Seleccionar Sede</label>
                          <select id="idsede" name="idsede">
                            <?php
                            foreach($sede->mostrarTodo("") as $f)
                            {
                            ?>
                            <option value="<?php echo $f['idsede'] ?>"><?php echo $f['nombre'] ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <a href="#" class="btn waves-effect waves-light light-blue darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</a>
                    <button id="btnSave" href="#" class="btn waves-effect waves-light indigo"><i class="fa fa-save"></i> CREAR ORGANIZACION</button>
                  </div>
                </div>
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Organizacion</th>
                    <th>Sede</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Organizacion</th>
                    <th>Sede</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  foreach($admorganizacion->mostrarTodo("tipo=121") as $f)
                  {
                    $dsede=$sede->mostrar($f['idsede']);
                    $dsede=array_shift($dsede);

                    $idadmorganizacion=ecUrl($f['idadmorganizacion']);
                  ?>
                  <tr>
                    <td><?php echo $f['nombre'] ?></td>
                    <td><?php echo $dsede['nombre'] ?></td>
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
    ?>
    <script type="text/javascript">       
    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
      $('.btndel').tooltip({delay: 50});
    }); 
      $("#btnSave").click(function(){        
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
        else{
          Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
        }
      });
      function validar(){
        return true;
      }
    </script>
</body>

</html>