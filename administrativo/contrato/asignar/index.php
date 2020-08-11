<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  if (!isset($_SESSION["idsede"])) {
    $query=" and idsede=0";
    $tituloSede="Debe pertenecer a una sede para realizar esta operacion";
  }
  else{
    $query=" and idsede=".$_SESSION["idsede"];
    $dSelSede=$sede->mostrar($_SESSION["idsede"]);
    $dSelSede=array_shift($dSelSede);
    $tituloSede="Contratos en Sede ".$dSelSede['nombre'];
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Asignacion de Contratos";
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
          $idmenu=16;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $tituloSede; ?></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="input-field col s2">
                    Seleccionar Ejecutivo:
                  </div>
                  <div class="input-field col s4">
                    <label>Seleccionar Sede</label>
                    <select id="idejecutivo" name="idejecutivo">
                      <option disabled value="">Seleccionar Ejecutivo...</option>
                      <?php
                      foreach($vejecutivo->mostrarTodo("estado=1 and idarea=121 and idsede=".$_SESSION["idsede"]) as $f)
                      {
                        ?>
                        <option value="<?php echo $f['idvejecutivo']; ?>"><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno']." : ".$f['njerarquia'] ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="input-field col s3">
                    <textarea id="iddesc" name="iddesc" class="materialize-textarea"></textarea>
                    <label for="iddesc">Descripcion</label>
                  </div>
                  <div class="input-field col s3">
                    <button id="btnasignar" class="btn"><i class="fa fa-check"></i> Asignar Contratos</button>
                  </div>
                </div>
              </div>
              <div id="table-datatables">
              <div class="row">
                <form id="idform" action="return false" onsubmit="return false" method="POST">
                  <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Seleccionar</th>
                        <th>Nro Contrato</th>
                        <th>Fecha Habil</th>
                        <th>Sede</th>
                        <th>Ejecutivo</th>
                        <th>Estado</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Seleccionar</th>
                        <th>Nro Contrato</th>
                        <th>Fecha Habil</th>
                        <th>Sede</th>
                        <th>Ejecutivo</th>
                        <th>Estado</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      foreach($admcontrato->mostrarTodo("eshabil=1 and estado=60".$query) as $f)
                      {
                        $dsede=$sede->mostrar($f['idsede']);
                        $dsede=array_shift($dsede);
                        $destado=$dominio->mostrar($f['estado']);
                        $destado=array_shift($destado);
                        $sw=false;
                        if ($f['estado']==60) {
                          $sw=true;
                        }
                        switch ($f['estado']) {
                          case '60':
                            $estilo="background-color: #ffc77a;";
                          break;
                          case '61':
                            $estilo="background-color: #41f462;";
                          break;
                          case '62':
                            $estilo="background-color: #f46741;";
                          break;
                          case '63':
                            $estilo="background-color: #41d6f4;";
                          break;
                        }
                      ?>
                      <tr style="<?php echo $estilo ?>">
                        <td>
                          <input name="numero[]" <?php if (!$sw) echo "disabled"; ?> value="<?php echo $f['idadmcontrato']; ?>" type="checkbox" id="ch-<?php echo $f['idadmcontrato']; ?>" />
                          <label for="ch-<?php echo $f['idadmcontrato']; ?>"><i class="fa fa-thumbs-up"></i><?php echo $f['nrocontrato']; ?></label>
                        </td>
                        <td><?php echo $f['nrocontrato'] ?></td>
                        <td><?php echo $f['fechacreacion'] ?></td>
                        <td><?php echo $dsede['nombre'] ?></td>
                        <td><?php 
                         if ($f['idadmejecutivo']>0) {
                            $dejecutivo=$vejecutivo->mostrar($f['idadmejecutivo']);
                            $dejecutivo=array_shift($dejecutivo);
                            echo $dejecutivo['nombre']." ".$dejecutivo['paterno']." ".$dejecutivo['materno'];
                         }
                         else{
                          echo "Sin Asignar";
                         }
                          ?>
                        </td>
                        <td><?php echo $destado['nombre'] ?></td>
                      </tr>
                      <?php
                        }
                      ?>
                    </tbody>
                  </table>
                </form>
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
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true,
        responsive: true
      });
      $("#btnasignar").click(function(){
        var str = $( "#idform" ).serialize();
        var desc=$("#iddesc").val();
        //alert(str);
        var idejecutivo=$('select[id=idejecutivo]').val();
        $.ajax({
            url: "guardar.php",
            type: "POST",
            data: str+"&idejecutivo="+idejecutivo+"&iddesc="+desc,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
      });
    });
    </script>
</body>

</html>