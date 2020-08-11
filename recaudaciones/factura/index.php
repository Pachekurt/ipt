<?php
  $ruta="../../";
  include_once($ruta."class/factura.php");
  $factura=new factura;
  include_once($ruta."class/vfactura.php");
  $vfactura=new vfactura;
  include_once($ruta."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."funciones/funciones.php");
  session_start();
  $idsede=$_SESSION["idsede"];
  $dse=$sede->muestra($idsede);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Facturas ".$dse['nombre'];
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
          $idmenu=59;
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
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Nro</th>
                      <th>Matricula</th>
                      <th>Monto</th>
                      <th>Saldo</th>
                      <th>Codigo de Control</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $fecha=date("Y-m-d");
                    $sw=true;
                    foreach($vfactura->mostrarTodo("tipotabla='CART' and estado=1 and idsede=$idsede") as $f)
                    {
                      $lblcode=ecUrl($f['idvfactura']);
                      switch ($f['estado']) {
                        case '1':
                          $estilo="background-color: #fff;";
                        break;
                        case '0':
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
                      <td><?php echo $f['fecha'] ?></td>
                      <td><?php echo $f['nro'] ?></td>
                      <td><?php echo $f['matricula'] ?></td>
                      <td><?php echo $f['total'] ?></td>
                      <td><?php echo $f['saldo'] ?></td>
                      <td><?php echo $f['control'] ?></td>
                      <td>
                        <a href="anular/?lblcode=<?php echo $lblcode ?>" class="btn-jh red"><i class="mdi-navigation-cancel"></i> Anular </a>
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
      $('#btnSave').click(function(){
         var str=$("#idform").serialize();; 
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
    function cerrarPlanes(id){
      swal({
        title: "Estas Seguro?",
        text: "Cerraras los planes",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "cerrarplanes.php",
          type: "POST",
          data: "id="+id,
          success: function(resp){
            $("#idresultado").html(resp);
          }   
        });
      }); 
    }
    function activarplanes(id){
      swal({
        title: "Estas Seguro?",
        text: "Activaras los planes",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "activarplanes.php",
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