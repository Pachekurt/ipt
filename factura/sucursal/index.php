<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($ruta."class/miempresa.php");
  $miempresa=new miempresa;
  include_once($ruta."funciones/funciones.php");
  session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Sucursales INGLES PARA TODOS";
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
          $idmenu=30;
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
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>id</th>

                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Zona</th>
                    <th>Dias Restantes</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Empresa</th>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Zona</th>
                    <th>Acciones</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  foreach($admsucursal->mostrarTodo("") as $f)
                  {
                    $dem=$miempresa->muestra($f['idmiempresa']);
                    $lblcode=ecUrl($f['idadmsucursal']);
                    $dciudad=$dominio->muestra($f['idciudad']);
                    switch ($f['tipo']) {
                      case '0'://pendiente nueva gestion
                        $estilo="background-color: #abd6b1;";
                      break;
                      case '1'://gestion activa
                        $estilo="background-color: #79c684; color:#005b12; font-weight: bold;";
                      break;
                    }
                  ?>
                  <tr style="<?php echo $estilo ?>">
                    <td><?php echo $f['idadmsucursal'] ?></td>
                    <td><?php echo $dem['nombre'] ?></td>
                    <td><?php echo $f['nombre'] ?></td>
                    <td><?php echo $dciudad['nombre'] ?></td>
                    <td><?php echo $f['zona'] ?></td>
                    <td>
                      <a href="editar/?lblcode=<?php echo $lblcode ?>" class="btn-jh orange"><i class="fa fa-edit"></i> Editar</a>
                      <a href="dosificacion/?lblcode=<?php echo $lblcode ?>" class="btn-jh blue"><i class="fa fa-flag-o"></i> Dosificacion</a>
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