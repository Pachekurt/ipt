<?php
  $ruta="../../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/cobcartera.php");
  $cobcartera=new cobcartera;
  include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;
  include_once($ruta."class/cobobservacion.php");
  $cobobservacion=new cobobservacion;
  
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $valor=dcUrl($lblcode);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Observaciones";
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
          $idmenu=63;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i><?php echo $hd_titulo; ?> 
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="formcontent">
              <div class="row"> 
                <div class="titulo">Agregar Observacion</div>
                <div class="col s12 m12 l12">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcartera" id="idcartera" value="<?php echo $valor; ?>">
                    <div class="row">
                      <div class="input-field col s12 m9 l9">
                        <input id="idobs" style="text-align: center;" placeholder="Ingrese la Observacion..." name="idobs" type="text" class="validate">
                        <label for="idobs">Observacion</label>
                      </div>
                      <div class="input-field col s12 m3 l3">
                        <a style="width: 100%" id="btnSave" class="btn waves-effect waves-light darken-3 green"><i class="fa fa-save"></i> AGREGAR </a><br><br><br>
                      </div>
                    </div>
                  </form>
                </div>&nbsp;
              </div>
            </div>   
            <div class="section">
              <div id="table-datatables">
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>FECHA</th>
                      <th>OBSERVACION</th>
                      <th>USUARIO</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($cobobservacion->mostrarTodo("idcartera=$valor") as $f)
                    {
                      $dsu=$usuario->muestra($f['usuariocreacion']); 
                      ?>
                        <tr>
                          <td><?php echo $f['fechacreacion'] ?></td>
                          <td><?php echo $f['observacion'] ?></td>
                          <td><?php echo $dsu['usuario'] ?></td>
                        </tr>
                      <?php
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>FECHA</th>
                      <th>OBSERVACION</th>
                      <th>USUARIO</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">
      $('#example').DataTable( {
        dom: 'Bfrtip',
        responsive:true,
      });
      $("#btnSave").click(function(){
        if (validar()) {
        swal({
          title: "REGISTRAR",
          text: "Estas seguro de registrar la observacion?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "Si, Estoy Seguro",
          closeOnConfirm: false
        }, function () {
          
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
          
        }); 
        }
          else{
            swal('Cuidado!','Tiene que ingresar la observacion','warning');
          }
      });
      function validar(){
        retorno=true;
        if ($('#idobs').val()=="") {
          retorno=false;
        }
        return retorno;
      }
    </script>
</body>

</html>