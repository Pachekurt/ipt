<?php
  $ruta="../../../../";
  include_once($ruta."class/domicilio.php");
  $domicilio=new domicilio;
  include_once($ruta."class/laboral.php");
  $laboral=new laboral;
  include_once($ruta."class/vejecutivopersona.php");
  $vejecutivopersona=new vejecutivopersona;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
   include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/persona.php");
  $persona=new persona;
   include_once($ruta."class/titular.php");
  $titular=new titular;
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
    $dper=$persona->muestra($valor);
    $persona= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Domicilios y Trabajos";
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
          $idmenu=35;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title">Registrar Titular</h5>
                  <ol class="breadcrumbs">
                    <li><a href="../editar/?lblcode=<?php echo $lblcode ?>"> Datos de Persona </a></li>
                    <li class="activoTab"><a href="../domlab/?lblcode=<?php echo $lblcode ?>"> Domicilios y Trabajos</a></li>
                  </ol>
                </div>
                <div class="col s7 m7 l7">
                  <table class="csscontrato">
                    <thead>
                      <tr>
                        <th>Carnet</th>
                        <th>Nombre</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $dper['carnet']." ".$dper['expedido'] ?></td>
                        <td><?php echo $persona ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div id="table-datatables">
              <a href="#modal1" class="btn waves-effect waves-light indigo modal-trigger"><i class="fa fa-plus-square"></i> Nuevo Domicilio y/o Trabajo</a>

                <div id="modal1" class="modal modal-fixed-footer" style="width: 80%">
                  <div class="modal-content">
                    <h3><input name="iddomicilio" type="checkbox" id="iddomicilio" /><label for="iddomicilio">Datos de Domicilio</label></h3>
                    <form class="col s12" id="idformdom" action="return false" onsubmit="return false" method="POST">
                      <div class="row">
                        <div class="input-field col s6">
                          <input id="idzona" name="idzona"  type="text" class="validate">
                          <label for="idzona">Zona</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="iddireccion" name="iddireccion" type="text" class="validate">
                          <label for="iddireccion">Direccion</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idfono" name="idfono" type="text" class="validate">
                          <label for="idfono">telefono</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="iddesc" name="iddesc" type="text" class="validate">
                          <label for="iddesc">Dir. Descriptiva</label>
                        </div>
                      </div>
                    </form>
                    <h3><input name="idtrabajo" type="checkbox" id="idtrabajo" /><label for="idtrabajo">Datos de Trabajo</label></h3>
                    <form class="col s12" id="idformlab" action="return false" onsubmit="return false" method="POST">
                      <div class="row">
                        <div class="input-field col s6">
                          <input id="idzonal" name="idzonal"  type="text" class="validate">
                          <label for="idzonal">Zona</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="iddireccionl" name="iddireccionl" type="text" class="validate">
                          <label for="iddireccionl">Direccion</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idfonol" name="idfonol" type="text" class="validate">
                          <label for="idfonol">telefono</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="iddescl" name="iddescl" type="text" class="validate">
                          <label for="iddescl">Dir. Descriptiva</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idempresa" name="idempresa"  type="text" class="validate">
                          <label for="idempresa">Empresa</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idcargo" name="idcargo" type="text" class="validate">
                          <label for="idcargo">Cargo</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idantiguedad" name="idantiguedad" type="text" class="validate">
                          <label for="idantiguedad">Antiguedad</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idmensual" name="idmensual" type="text" class="validate">
                          <label for="idmensual">Ing. Mensual</label>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <a href="#" class="btn waves-effect waves-light light-orange darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</a>
                    <button id="btnSave" href="#" class="btn waves-effect waves-light green"><i class="fa fa-save"></i> GUARDAR DATOS</button>
                  </div>
                </div>
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>DATOS</th>
                        <th>Zona</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>DATOS</th>
                        <th>Zona</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                  <?php
                  foreach($domicilio->mostrarTodo("idpersona=".$valor) as $f)
                  {
                  ?>
                  <tr>
                    <td>DOMICILIO</td>
                    <td><?php echo $f['idbarrio'] ?></td>
                    <td><?php echo $f['nombre'] ?></td>
                    <td><?php echo $f['telefono'] ?></td>
                    <td><?php echo $f['tipoDomicilio'] ?></td>
                    <td>
                      <a href="domicilio/?lblcode=<?php echo $lblcode ?>&dom=<?php echo $f['iddomicilio'] ?>" class="btn-jh waves-effect waves-light blue"><i class="fa fa-edit"></i> Editar</a>  
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                  <?php
                  foreach($laboral->mostrarTodo("idpersona=".$valor) as $f)
                  {
                  ?>
                  <tr>
                    <td>TRABAJO</td>
                    <td><?php echo $f['idbarrio'] ?></td>
                    <td><?php echo $f['nombre'] ?></td>
                    <td><?php echo $f['telefono'] ?></td>
                    <td><?php echo $f['tipolaboral'] ?></td>
                    <td>
                      <a href="laboral/?lblcode=<?php echo $lblcode ?>&lab=<?php echo $f['idlaboral'] ?>" class="btn-jh waves-effect waves-light blue"><i class="fa fa-edit"></i> Editar</a>  
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
            include_once("../../../footer.php");
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
      $('#idformdom').find('input, textarea, button, select').attr('disabled',true);
      $('#idformlab').find('input, textarea, button, select').attr('disabled',true);
      $('#example').DataTable({
        responsive: true
      });
      //habilita y deshabilita los campos de domicilio y laboral
      $('#iddomicilio').click(function() {
        if (!$(this).is(':checked')) {
          $('#idformdom').find('input, textarea, button, select').attr('disabled',true);
        }
        else{
          $('#idformdom').find('input, textarea, button, select').attr('disabled',false);
        }
      });
      $('#idtrabajo').click(function() {
        if (!$(this).is(':checked')) {
          $('#idformlab').find('input, textarea, button, select').attr('disabled',true);
        }
        else{
          $('#idformlab').find('input, textarea, button, select').attr('disabled',false);
        }
      });
      /**********************************************************************************/
      $("#btnSave").click(function(){
        var strDom = $("#idformdom").serialize();
            var strTrab = $("#idformlab").serialize();
            var str=strDom+"&"+strTrab
            var chkDom=0;
            var chkLab=0;
            if ($('#iddomicilio').is(':checked'))chkDom=1;
            if ($('#idtrabajo').is(':checked'))chkLab=1;
            var str=str+"&dom="+chkDom+"&lab="+chkLab+"&lblcode="+"<?php echo $lblcode ?>";
            //alert(str);
            swal({
                title: "CONFIRMACION",
                text: "Se guardara los datos ingresados", 
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#2c2a6c",
                confirmButtonText: "GUARDAR",
                closeOnConfirm: false
              }, function () {
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

    }); 
    </script>
</body>

</html>