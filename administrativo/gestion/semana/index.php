<?php
  $ruta="../../../";
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admsemana.php");
  $admsemana=new admsemana;
  include_once($ruta."class/admvigencia.php");
  $admvigencia=new admvigencia;

  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Administrar Semanas";
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
          $idmenu=19;
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
              <div class="col s12 m12 l12">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input id="idgestion" type="hidden" value="<?php echo dcUrl($lblcode); ?>" name="idgestion">
                    <h4 class="header">Generar Semanas para las vigencias</h4>
                    <div id="input-fields"> 
                    <?php
                            $sw=true;
                            $dsemana=$admsemana->mostrarTodo(" idadmgestion=".dcUrl($lblcode));
                            if (count($dsemana)>0) {
                              $sw=false;
                            }
                          ?>
                      <div class="row">
                        <div class="input-field col s4">
                          <input id="idfechain" <?php if (!$sw) {echo "disabled";} ?>  type="date" name="idfechain" class="validate">
                          <label for="idfechain">Fecha Inicio</label>
                        </div>
                        <div class="input-field col s4">
                          
                          <button id="idAdGestion" <?php if (!$sw) {echo "disabled";} ?> class="btn waves-effect waves-light red"><i class="fa fa-bolt"></i> GENERAR SEMANAS Y VIGENCIAS</button>
                        </div>  
                      </div>
                    </div>
                    <div class="divider"></div>
                  </form>
              </div>   
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>COD</th>
                      <th>Vigencia</th>
                      <th>Semana</th>
                      <th>Nro</th>
                      <th>Fecha Inicio</th>
                      <th>Fecha Fin</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>COD</th>
                      <th>Vigencia</th>
                      <th>Semana</th>
                      <th>Nro</th>
                      <th>Fecha Inicio</th>
                      <th>Fecha Fin</th>
                      <th>Estado</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $sw=true;
                    foreach($admsemana->mostrarTodo(" idadmgestion=".dcUrl($lblcode)) as $f)
                    {
                      $dvigencia=$admvigencia->mostrar($f['idadmvigencia']);
                      $dvigencia=array_shift($dvigencia);
                      switch ($f['estado']) {
                        case '0'://pendiente nueva gestion
                          $estilo="background-color: #ffad49;";
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
                      <td><?php echo $f['idadmsemana'] ?></td>
                      <td><?php echo $dvigencia['nombre'] ?></td>
                      <td><?php echo $f['semana'] ?></td>
                      <td><?php echo $f['nro'] ?></td>
                      <td><?php echo $f['fechain'] ?></td>
                      <td><?php echo $f['fechafin'] ?></td>
                      <td><?php switch ($f['estado']) {
                        case '0'://pendiente nueva gestion
                          echo "PENDIENTE";
                        break;
                        case '1'://gestion activa
                          echo "ACTIVO";
                        break;
                        case '2'://gestion pasada
                          echo "VENCIDO";
                        break;
                      }?></td>
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
    </script>
</body>

</html>