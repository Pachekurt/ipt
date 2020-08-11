<?php
  $ruta="../../";
  include_once($ruta."class/admgestion.php");
  $admgestion=new admgestion;

  include_once($ruta."class/admsemana.php");
  $admsemana=new admsemana;
  include_once($ruta."class/admvigencia.php");
  $admvigencia=new admvigencia;

  include_once($ruta."funciones/funciones.php");
  session_start();
  $dvigencia=$admgestion->mostrarUltimo("estado=1");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Vigencias ".$dvigencia['anio'];
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
          $idmenu=20;
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
                      <th>Semana</th>
                      <th>Vigencia</th>
                      <th>Nro</th>
                      <th>Fecha Inicio</th>
                      <th>Fecha Fin</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Semana</th>
                      <th>Vigencia</th>
                      <th>Nro</th>
                      <th>Fecha Inicio</th>
                      <th>Fecha Fin</th>
                      <th>Estado</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $sw=true;
                    foreach($admsemana->mostrarTodo(" idadmgestion=".$dvigencia['idadmgestion']." and estado<>2") as $f)
                    {
                      $dvigencia=$admvigencia->mostrar($f['idadmvigencia']);
                      $dvigencia=array_shift($dvigencia);
                      switch ($f['estado']) {
                        case '0'://pendiente nueva gestion
                          $estilo="background-color: #ffb36d;";
                        break;
                        case '1'://gestion activa
                          $estilo="background-color: #68ff49; color:#005b12; font-weight: bold;";
                        break;
                        case '2'://gestion pasada
                          $estilo="background-color: #dbdbdb;";
                        break;
                      }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['semana'] ?></td>
                      <td><?php echo $dvigencia['nombre'] ?></td>
                      <td><?php echo $f['nro'] ?></td>
                      <td><?php echo $f['fechain'] ?></td>
                      <td><?php echo $f['fechafin'] ?></td>
                      <td><?php 
                        switch ($f['estado']) {
                          case '0'://pendiente nueva gestion
                            echo "PENDIENTE";
                            if($sw)
                              {
                                ?>
                                  <button onclick="activarSemana('<?php echo $f["idadmsemana"] ;?>');" class="btn-jh waves-effect waves-light green"><i class="fa fa-star-o"></i> Activar Semana</button>
                                <?php
                              }
                              $sw=false;
                          break;
                          case '1'://gestion activa
                            ?><i class="fa fa-star"></i> ACTIVO
                                <button onclick="cerrarSemana('<?php echo $f["idadmsemana"] ;?>');"  class="btn-jh waves-effect waves-light red"><i class="fa fa-gear"></i> Cerrar Semana</button>
                              <?php
                              $sw=false;
                          break;
                          case '2'://gestion pasada
                            ?>
                               <i class="fa fa-unlock-alt"></i> Vencido
                              <?php
                          break;
                        }?>                        
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
      $('#idAdGestion').click(function(){
         var str=$("#idform").serialize();; 
         //alert(str);
        swal({
          title: "Estas Seguro?",
          text: "Agregaras una nueva Gestion",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        },function(){   
           
          $.ajax({
            url: "generarSemanas.php",
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
    function cerrarSemana(id){
      swal({
        title: "Estas Seguro?",
        text: "Cerraras la Semana",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "cerrarSemana.php",
          type: "POST",
          data: "id="+id,
          success: function(resp){
            $("#idresultado").html(resp);
          }   
        });
      }); 
    }
    function activarSemana(id){
      swal({
        title: "Estas Seguro?",
        text: "Activaras la Semana",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "activarSemana.php",
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