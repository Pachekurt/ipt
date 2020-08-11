<?php
  session_start();
  $idusuario=$_SESSION["codusuario"];
  $ruta="../../../../";
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admsemana.php");
  $admsemana=new admsemana;
  include_once($ruta."class/vsemana.php");
  $vsemana=new vsemana;
  include_once($ruta."class/admvigencia.php");
  $admvigencia=new admvigencia;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/admorgani.php");
  $admorgani=new admorgani;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
  $idorganizacion=dcUrl($lblcode);
  //echo $idorganizacion;
  $dusuario=$usuario->muestra($idusuario);
  $idejecutivo=$dusuario['idadmejecutivo'];
  $dorg=$admorganizacion->muestra($idorganizacion);
  $dsede=$sede->muestra($dorg['idsede']);
  $dejec=$vejecutivo->muestra($idejecutivo);
  $encargado=$dejec['nombre'].' '.$dejec['paterno'].' '.$dejec['materno'];
  $nsede=$dsede['nombre'];
  $organizacion=$dorg['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Administrar Organigramas";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wradmorganizacionapper">
        <?php
          $idmenu=37;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
                <div class="col s7 m7 l7">
                  <table class="csscontrato">
                    <thead>
                      <tr>
                        <th>Encargado</th>
                        <th>Sede</th>
                        <th>Organizacion</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $encargado ?></td>
                        <td><?php echo $nsede ?></td>
                        <td><?php echo $organizacion ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <a href="#modal1" class="btn waves-effect waves-light indigo modal-trigger"><i class="fa fa-plus-square"></i> Nuevo Organigrama</a>
              <div id="modal1" class="modal">
                <div class="modal-content">
                <h1>Nuevo Organigrama</h1>
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <div class="row">
                      <div id="card-alert" class="card orange lighten-5">
                      <div class="card-content orange-text">
                        <p>ALERTA : Se duplicara el organigrama activo en estado pendiente para que pueda configurarlo</p>
                      </div>
                    </div>
                    </div>
                    <div class="row">
                      <input type="hidden" name="idejecutivo" id="idejecutivo" value="<?php echo $idejecutivo ?>">
                      <input type="hidden" name="idorganizacion" id="idorganizacion" value="<?php echo $lblcode ?>">
                      <div class="input-field col s12">
                        <textarea id="iddesc" name="iddesc" class="materialize-textarea"></textarea>
                        <label for="iddesc">Observaciones o detalles del organigrama</label>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <a href="#" class="btn waves-effect waves-light light-blue darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</a>
                  <button id="btnSave" class="btn waves-effect waves-light indigo"><i class="fa fa-save"></i> CREAR ORGANIGRAMA</button>
                </div>
              </div>
              <div class="col s12 m12 l6">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Fecha Registro</th>
                      <th>Detalle</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sw=true;
                    foreach($admorgani->mostrarTodo("idadmorganizacion=".$idorganizacion) as $f)
                    {
                        $lblcod=ecUrl($f['idadmorgani']);
                        switch ($f['estado']) {
                          case '0'://pendiente nueva gestion
                            $estilo="background-color: #ffad49;";
                          break;
                          case '1'://gestion activa
                            $estilo="background-color: #6ac956; color:#005b12; font-weight: bold;";
                          break;
                          case '2'://gestion pasada
                            $estilo="background-color: #dbdbdb;";
                          break;
                        }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['fechacreacion'] ?></td>
                      <td><?php echo $f['detalle'] ?></td>
                      <td><?php  
                        switch ($f['estado']) {
                          case '0'://pendiente nueva gestion
                            echo "PENDIENTE";
                          break;
                          case '1'://gestion activa
                            echo "ACTIVO";
                          break;
                          case '2'://gestion pasada
                            echo "PASADO";
                          break; 
                        }
                        ?>
                        </td>
                      <td>
                        
                        
                        <?php
                          switch ($f['estado']) {
                            case '0'://pendiente nueva gestion
                              if($sw)
                              {
                                ?>
                                  <button onclick="activarGestion('<?php echo $f["idadmorgani"] ;?>');" class="btn-jh waves-effect waves-light green"><i class="fa fa-star-o"></i> Activar Organigrama</button>
                                <?php
                              }
                              ?>
                                <a href="configurar/?lblcode=<?php echo $lblcode ?>&lblcod=<?php echo $f['idadmorgani'] ?>" class="btn-jh orange darken-4"><i class="fa fa-cog"></i> Configurar Organigrama</a>
                              <?php
                              $sw=false;
                            break;
                            case '1'://gestion activa
                              ?>
                                <i class="fa fa-star"></i> ACTIVO
                                <button onclick="cerrarOrgani('<?php echo $f["idadmorgani"] ;?>');"  class="btn-jh waves-effect darken-4 red"><i class="fa fa-gear"></i> Cerrar Organigrama</button>
                              <?php
                              $sw=false;
                            break;
                            case '2'://gestion pasada
                              ?>
                               <i class="fa fa-unlock-alt"></i> Organigrama Pasado
                              <?php
                            break;
                          }
                        ?>
                        <button onclick="verOrg('<?php echo $lblcod ?>');" class="btn-jh blue darken-4"><i class="fa fa-eye"></i> Ver Org.</button>
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
      $('#example').DataTable();
      $("#btnSave").click(function(){     
        $('#btnSave').attr("disabled",true);
        var str = $( "#idform" ).serialize();
        $.ajax({
          url: "crearNuevoOrg.php",
          type: "POST",
          data: str,
          success: function(resp){
            console.log(resp);
            $('#idresultado').html(resp);
          }
        });
      });
    });
    function verOrg(id){
      window.open("data.php?lblcode="+id , "ventana1" , "width=1000,height=400,scrollbars=NO"); 
    }
    function activarGestion(id){
      swal({
        title: "Estas Seguro?",
        text: "Activaras el organigrama y no podras modificarlo",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "activar.php",
          type: "POST",
          data: "id="+id,
          success: function(resp){
            $("#idresultado").html(resp);
          }   
        });
      }); 
    }
    function cerrarOrgani(id){
      swal({
        title: "Estas Seguro?",
        text: "Cerraras el Organigrama",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "cerrar.php",
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