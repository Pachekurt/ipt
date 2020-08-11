<?php
  $ruta="../../../";
  include_once($ruta."class/admejecutivo.php");
  $admejecutivo=new admejecutivo;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/admjerarquia.php");
  $admjerarquia=new admjerarquia;

  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $valor=dcUrl($lblcode);
  //echo $valor;
  $deje=$admejecutivo->muestra($valor);
  $dper=$persona->muestra($deje['idpersona']);
  $dorg=$admorganizacion->muestra($deje['idorganizacion']);
  $personan= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
  $dcargo=$admjerarquia->muestra($deje['idcargo']);

  if ($deje['estado']==0) {
    $read="";
  }else{
    $read="readonly";
  }


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Registrar Ejecutivo";
      include_once($ruta."includes/head_basico.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=12;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="row">
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title">Registrar Ejecutivo</h5>
                  <ol class="breadcrumbs">
                    <li><a href="../editar/?lblcode=<?php echo $lblcode ?>"> Datos de Persona </a></li>
                    <li><a href="../foto/?lblcode=<?php echo $lblcode ?>"> Foto</a></li>
                    <li class="activoTab"><a href="../administrar/?lblcode=<?php echo $lblcode ?>"> Administrar</a></li>
                  </ol>
                </div>
                <div class="col s7 m7 l7">
                  <table class="csscontrato">
                    <thead>
                      <tr>
                        <th>Carnet</th>
                        <th>Nombre</th>
                        <th>Cargo</th>
                        <th>Organizacion</th>
                        <th>IMPRIMIR</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $dper['carnet']." ".$dper['expedido'] ?></td>
                        <td><?php echo $personan ?></td>
                        <td><?php echo $dcargo['nombre'] ?></td>
                        <td><?php echo $dorg['nombre'] ?></td>
                        <td><a href="../impresion/?lblcode=<?php echo $lblcode ?>" target="_blank" class="btn-jh green"> <i class="fa fa-print"></i> </a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
          <div class="container">
            <!-- ver si es director -->
            <div class="row">
              <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <div class="row">
                  <div class="input-field col s2">
                    Asignar Organizacion
                  </div>
                  <div class="input-field col s6">
                    <label>Seleccionar Sede</label>
                    <select id="idOrgz" name="idOrgz">
                      <option value="">Seleccionar Sede...</option>
                      <?php
                      foreach($admorganizacion->mostrarTodo("idadmejecutivo=0 and tipo=121") as $f)
                      {
                        ?>
                        <option value="<?php echo $f['idadmorganizacion']; ?>">ORG. <?php echo $f['nombre'] ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="input-field col s4">
                    <button id="btnAsignar" class="btn"><i class="fa fa-save"></i></button>
                  </div>
                </div>
              </form>
            </div>
            <?php
            if ($deje['idarea']==121) {
            ?>
            <div class="row">
              <form class="col s12" id="idform2" action="return false" onsubmit="return false" method="POST">
                <div class="row">
                  <div class="input-field col s2">
                    Ascender Ejecutivo
                  </div>
                  <div class="input-field col s6">
                    <input id="idcargo" readonly="" name="idcargo" value="<?php echo $dcargo['nombre'] ?>" type="text" class="validate">
                    <label for="idcargo">Cargo Actual</label>
                  </div> 
                  <div class="input-field col s4">
                    <button id="btnAscender" class="btn blue darken-4"><i class="fa fa-save"></i> Ascender</button>
                  </div>
                </div>
              </form>
            </div>
            <?php
            }
            ?>
          </div>
          <?php
            include_once("../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
    ?>
    <script type="text/javascript">
      $("#btnAsignar").click(function(){
        $('#btnAsignar').attr("disabled",true);
        swal({
          title: "CONFIRMACION",
          text: "Asignar a ejecutivo como encargado de organizacion?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#2c2a6c",
          confirmButtonText: "SI",
          closeOnConfirm: false
        }, function () {
          var str = $("#idform").serialize();
          $.ajax({
            url: "asignarOrg.php",
            type: "POST",
            data: str+'&idejecutivo=<?php echo $valor ?>',
            success: function(resp){
              console.log(resp);
              $("#idresultado").html(resp);
            }
          }); 
        }); 
      });
      $("#btnAscender").click(function(){
        $('#btnAscender').attr("disabled",true);
        swal({
          title: "CONFIRMACION",
          text: "Ascender a ejecutivo?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#2c2a6c",
          confirmButtonText: "SI",
          closeOnConfirm: false
        }, function () {
          var str = $("#idform2").serialize();
          $.ajax({
            url: "ascender.php",
            type: "POST",
            data: str+'&idejecutivo=<?php echo $valor ?>',
            success: function(resp){
              console.log(resp);
              $("#idresultado").html(resp);
            }
          }); 
        }); 
      });
    </script>
</body>

</html>