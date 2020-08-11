<?php
  $ruta="../../../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;
  include_once($ruta."class/titular.php");
  $titular=new titular;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/admlibro.php");
  $admlibro=new admlibro;
  include_once($ruta."class/admlibrocontrato.php");
  $admlibrocontrato=new admlibrocontrato;

  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $idcontrato=dcUrl($lblcode);
  $dcontrato=$admcontrato->muestra($idcontrato);
  $dejec=$vejecutivo->muestra($dcontrato['idadmejecutivo']);
  $dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
  $idpersona=$dtit['idpersona'];
  $dper=$persona->muestra($dtit['idpersona']);
  $titulaper= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
  $ejecutivo= $dejec['nombre']." ".$dejec['paterno']." ".$dejec['materno'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Entrega Material";
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
          $idmenu=43;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l5">
                  <h5 class="breadcrumbs-title"><?php echo $hd_titulo ?></h5>
                </div>
                <div class="col s12 m12 l7">
                  <table class="csscontrato">
                    <thead>
                      <tr>
                        <th>Ejecutivo</th>
                        <th>Titular</th>
                        <th>Contrato</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $ejecutivo ?></td>
                        <td><?php echo $titulaper ?></td>
                        <td><?php echo $dcontrato['nrocontrato'] ?></td>
                        
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div class="row">
                <div class="col s12 m4 l5">&nbsp;</div>
                <div class="col s12 m4 l5">
                  <div>
                    <button id="btnGuardar" class="btn green darken-3"><i class="fa fal-save"></i> Guardar Cambios</button>
                    <br><br>
                  </div>
                  <form id="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato ?>">
                    <?php
                    foreach($admlibro->mostrarTodo("estado=1") as $dl)
                    {
                      $actMenu=$admlibrocontrato->mostrarTodo("idlibro=".$dl['idadmlibro']." and idcontrato=".$idcontrato);
                      if(count($actMenu)>0)$sw="checked disabled"; else $sw="";
                      ?>
                        <input name="numero[]" <?php echo $sw ?> value="<?php echo $dl['idadmlibro']; ?>" type="checkbox" id="ch-<?php echo $dl['idadmlibro']; ?>" />
                        <label for="ch-<?php echo $dl['idadmlibro']; ?>"><i class="fa fa-thumbs-up"></i><?php echo $dl['nombre']; ?></label>
                        <br>
                      <?php
                    }
                    ?>
                  </form>
                </div>
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
    ?>
    <script type="text/javascript">
      $("#btnGuardar").click(function(){
        var str = $("#idform").serialize();
        //alert(str);
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
    </script>
</body>

</html>