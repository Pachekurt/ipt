<?php
  $ruta="../../../";
  include_once($ruta."class/admplan.php");
  $admplan=new admplan;
  include_once($ruta."class/admplanes.php");
  $admplanes=new admplanes;
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $valor=dcUrl($lblcode);
  if (!ctype_digit(strval($valor))) {
    if (!isset($_SESSION["faltaSistema"]))
    {  $_SESSION['faltaSistema']="0"; }
    $_SESSION['faltaSistema']=$_SESSION['faltaSistema']+1;
    ?>
      <script type="text/javascript">
        ruta="<?php echo $ruta ?>login/salir.php";
        window.location=ruta;
      </script>
    <?php
  }
  $dplanes=$admplanes->mostrarUltimo("idadmplanes=".$valor);


?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Administrar Planes ";
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
          $idmenu=34;
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
              <a href="#modal1" class="btn waves-effect waves-light indigo modal-trigger"><i class="fa fa-plus-square"></i> Nuevo Plan</a><br><br>
              <?php
                if ($dplanes['estado']!=1) {
                  ?>
                  <?php
                }
              ?>
                <div id="modal1" class="modal">
                  <div class="modal-content">
                  <h1>Nuevo Plan</h1>
                    <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                      <div class="row">
                        <div class="input-field col s6">
                          <input id="idnombre" name="idnombre"  type="text" class="validate">
                          <label for="idnombre">Nombre del Plan</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idtotal" name="idtotal" type="text" class="validate">
                          <label for="idtotal">Total a Pagar</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idinicial" name="idinicial" type="text" class="validate">
                          <label for="idinicial">Pago Inicial</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idmensual" name="idmensual" type="text" class="validate">
                          <label for="idmensual">Cuota Mensual</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idcuotas" name="idcuotas" type="text" class="validate">
                          <label for="idcuotas">Cuotas</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idpersonas" name="idpersonas" type="text" class="validate">
                          <label for="idpersonas">Cantidad de Personas</label>
                        </div>

                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <a href="#" class="btn waves-effect waves-light red modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</a>
                    <button id="btnSave" href="#" class="btn waves-effect waves-light green"><i class="fa fa-save"></i> CREAR PLAN</button>
                  </div>
                </div>
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Plan</th>
                      <th>Total a Pagar</th>
                      <th>Pago Inicial</th>
                      <th>Cuota Mensual</th>
                      <th>Pagos</th>
                      <th>Cantidad de Personas</th>
                      <th>ACCIONES</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Plan</th>
                      <th>Total a Pagar</th>
                      <th>Pago Inicial</th>
                      <th>Cuota Mensual</th>
                      <th>Pagos</th>
                      <th>Cantidad de Personas</th>
                      <th>ACCIONES</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    foreach($admplan->mostrarFull("idadmplanes=".dcUrl($lblcode)) as $f)
                    {
                    ?>
                    <tr>
                      <td><?php echo $f['idadmplan'] ?></td>
                      <td><?php echo $f['nombre'] ?></td>
                      <td><?php echo $f['inversion'] ?></td>
                      <td><?php echo $f['pagoinicial'] ?></td>
                      <td><?php echo $f['mensualidad'] ?></td>
                      <td><?php echo $f['cuotas']+1 ?></td>
                      <td><?php echo $f['personas'] ?></td>
<td>
                          <?php 
                          if ($f['activo']==0) {
                               
                                    ?>
                                        <button onclick="cambiaestado('<?php echo $f['idadmplan'] ?>','1');" class="btn-jh darken-4 green tooltipped" data-position="top" data-delay="50" data-tooltip="Habilitar" ><i class="mdi-action-thumb-up"></i>HABILITAR</button>
                                      <?php
                               
                            
                          }else {
                            ?>
                              <a onclick="cambiaestado('<?php echo $f['idadmplan']   ?>','0');" class="btn-jh waves-effect darken-4 red tooltipped" data-position="top" data-delay="50" data-tooltip="Dar de Baja"><i class="mdi-action-thumb-down"></i>DESHABILITAR</a>
                            <?php
                          }
                        ?></td>
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
      $('#btnSave').click(function(){
        var str=$("#idform").serialize();; 
        $.ajax({
          url: "guardar.php",
          type: "POST",
          data: str+"&lblcode=<?php echo $lblcode ?>",
          success: function(resp){
            console.log(resp);
            $("#idresultado").html(resp);
          }
        });
      });
    });

       function cambiaestado(id,estado){
      swal({
        title: "Estas Seguro?",
        text: "Cambiaras el estado del plan",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "cambiarestado.php",
          type: "POST",
          data: "id="+id+"&estado="+estado,
          success: function(resp){
            console.log(resp);
            $("#idresultado").html(resp);
          }   
        });
      }); 
    }
    </script>
</body>

</html>