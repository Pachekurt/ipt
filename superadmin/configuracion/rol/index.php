<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/rol.php");
  $rol=new rol;
  session_start();  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Administrar Roles";
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
          $idmenu=2;
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
              <a href="../../" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>
              <a href="#modal1" class="btn waves-effect waves-light indigo modal-trigger"><i class="fa fa-plus-square"></i> Nuevo Rol</a>

                <div id="modal1" class="modal">
                  <div class="modal-content">
                  <h1>Nuevo Rol</h1>
                    <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                      <div class="row">
                        <div class="input-field col s12">
                          <input id="idnombre" name="idnombre" id="first_name" type="text" class="validate">
                          <label for="first_name">Nombre</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <textarea id="iddesc" name="iddesc" class="materialize-textarea"></textarea>
                          <label for="iddesc">Descripcion</label>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <a href="#" class="btn waves-effect waves-light light-blue darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</a>
                    <button id="btnSave" href="#" class="btn waves-effect waves-light indigo"><i class="fa fa-save"></i> CREAR ROL</button>
                  </div>
                </div>
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ROL</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ROL</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      foreach($rol->mostrarTodo("") as $f)
                      {
                        $idrol=ecUrl($f['idrol']);
                      ?>
                      <tr>
                        <td><?php echo $f['Nombre'] ?></td>
                        <td><?php echo $f['Descripcion'] ?></td>
                        <td>
                          <a href="configurar.php?lblcode=<?php echo $idrol ?>" class="btn-jh waves-effect waves-light blue"><i class="fa fa-cog"></i> Configurar</a>
                          <button id="btndel"  onclick="Eliminar('<?php echo $f["idrol"] ;?>');" data-tooltip="Eliminar Rol: <?php echo $f['Nombre'] ?>" class="btndel btn-jh waves-effect waves-light red"> <i class="fa fa-trash"></i> </button>
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
          </div>
          <?php
            include_once("../../footer.php");
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
      function Eliminar(id){
        swal({
          title: "Estas Seguro?",
          text: "El rol se eliminara",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {      
          $.ajax({
            url: "eliminar.php",
            type: "POST",
            data: "id="+id,
            success: function(resp){
              $("#idresultado").html(resp);
            }   
          });
        }); 
      }
    </script>
</body>

</html>