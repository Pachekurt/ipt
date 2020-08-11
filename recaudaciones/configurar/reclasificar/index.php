<?php
  $ruta="../../../";
  session_start();
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/cobcartera.php");
  $cobcartera=new cobcartera;
  include_once($ruta."class/cobcarteradet.php");
  $cobcarteradet=new cobcarteradet;
  include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;
  include_once($ruta."class/cobresumen.php");
  $cobresumen=new cobresumen;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Gestionar Periodos";
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_tabla.php");
    include_once($ruta."includes/head_tablax.php");
  ?>
  <style type="text/css">
    .estIn input{
      border:solid 1px #4286f4;
      width: 110px;
    }
  </style>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=60;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l5">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="input-field col s12 m6 l6">
              <a style="width: 100%" id="btnSsave" class="btn waves-effect waves-light darken-3 green"><i class="fa fa-save"></i> RECLASIFICAR</a>
            </div>
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
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
      $("#btnSsave").click(function(){
        swal({   
            title: "Iniciar Periodo?",   
             text: "Comenzaras un nuevo periodo",   
             type: "warning",   
             showCancelButton: true,   
             closeOnConfirm: false,   
             showLoaderOnConfirm: true, }, 
             function(){
              if (validar()) {
                $('#btnSsave').attr("disabled",true);
                $.ajax({
                  url: "../../reclasificacion",
                  type: "POST",
                  success: function(resp){
                    setTimeout(function(){     
                      console.log(resp);
                      $('#idresultado').html(resp);   
                    }, 1000); 
                  }
                });
              }
        });
      });
      $('#example').DataTable( {
        dom: 'Bfrtip',
        resonsive: 'true',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
      $('#example2').DataTable( {
        dom: 'Bfrtip',
        resonsive: 'true',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
      function validar(){
        return true;
      }
    </script>
</body>
</html>