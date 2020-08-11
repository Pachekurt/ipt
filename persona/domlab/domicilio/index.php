<?php
  $ruta="../../../../../";
  include_once($ruta."class/domicilio.php");
  $domicilio=new domicilio;
  include_once($ruta."class/persona.php");
  $persona=new persona;
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
  $ddom=$domicilio->mostrar($dom);
  $ddom=array_shift($ddom);
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
                    <li><a href="../../editar/?lblcode=<?php echo $lblcode ?>"> Datos de Persona </a></li>
                    <li class="activoTab"><a href="../../domlab/?lblcode=<?php echo $lblcode ?>"> Domicilios y Trabajos</a></li>
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
             <div class="col s6 m6 l6">
              <h4 class="header"><a href="../?lblcode=<?php echo $lblcode ?>" class="btn waves-effect waves-light blue"><i class="fa fa-mail-reply"></i> Atras</a> Editar Direccion de domicilio</h4>
              <form class="col s6" id="idformdom" action="return false" onsubmit="return false" method="POST">
                <input id="iddom" name="iddom" value="<?php echo $dom ?>" type="text">
                <div class="formcontent">
                  <div class="row">
                    <div class="input-field col s6">
                      <input id="idzona" name="idzona" value="<?php echo $ddom['idbarrio'] ?>"  type="text" class="validate">
                      <label for="idzona">Zona</label>
                    </div>
                    <div class="input-field col s6">
                      <input id="iddireccion" name="iddireccion" value="<?php echo $ddom['nombre'] ?>" type="text" class="validate">
                      <label for="iddireccion">Direccion</label>
                    </div>
                    <div class="input-field col s6">
                      <input id="idfono" name="idfono" type="text" value="<?php echo $ddom['telefono'] ?>" class="validate">
                      <label for="idfono">telefono</label>
                    </div>
                    <div class="input-field col s6">
                      <input id="iddesc" name="iddesc" type="text" value="<?php echo $ddom['descripcion'] ?>" class="validate">
                      <label for="iddesc">Dir. Descriptiva</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <a id="btnSave" class="btn waves-effect waves-light green"><i class="fa fa-save"></i> Actualizar Datos</a>
                    </div>
                  </div>
                </div>
              </form>    
              </div> 
            </div>
          </div>
          <?php
            include_once("../../../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">       
    $(document).ready(function() {
      /**********************************************************************************/
      $("#btnSave").click(function(){
        var strDom = $("#idformdom").serialize();
        swal({
            title: "Modificar ?",
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
              data: strDom,
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