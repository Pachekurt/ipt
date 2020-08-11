<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vfactura.php");
  $vfactura=new vfactura; 
  include_once($ruta."class/cobcarteradet.php");
  $cobcarteradet=new cobcarteradet; 
  include_once($ruta."class/admcontratodelle.php");
  $admcontratodelle=new admcontratodelle; 
  include_once($ruta."funciones/funciones.php");
  session_start();
   extract($_GET);
$valor=dcUrl($lblcode); 

$dfactura=$vfactura->muestra($valor);

switch ($dfactura['tipotabla']) {
  case 'CART':
          $dato=$cobcarteradet->muestra($dfactura['idtabla']);
          $tipopago=$dato['tipopago'];
    break;
   case 'RECO':
        $dato=$admcontratodelle->muestra($dfactura['idtabla']);
          $tipopago=$dato['tiopago'];
    break;
  default:
        
    break;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="MODIFICAR TIPO PAGO";
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
          $idmenu=31;
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
                <div class="titulo">Datos de Factura</div>
                <div class="col s12 m12 l12">
                  <form class="col s12" id="idform"   method="POST">
                    <input type="hidden" name="idtabla" id="idtabla" value="<?php echo $dfactura['idtabla'] ?>"  >
                    <div class="row">
                      <div class="input-field col s12 m9 l3">
                        <input id="idnit" style="text-align: center;" readonly value="<?php echo $dfactura['nit'] ?>"   name="idnit" type="number" class="validate">
                        <label for="idnit">CI/NIT</label>
                      </div>
                      <div class="input-field col s12 m9 l3">
                        <input id="idrazhon" style="text-align: center;" readonly value="<?php echo $dfactura['razon'] ?>" name="idrazhon" type="text" class="validate">
                        <label for="idrazon">RAZON SOCIAL</label>
                      </div>
                      <div class="input-field col s12 m3 l2">
                        <input id="idrahzon" style="text-align: center;" readonly value="<?php echo $dfactura['total'] ?>" name="idrazron" type="text" class="validate">
                        <label for="idrazon">MONTO</label>
                      </div>
                      <div class="input-field col s12 m3 l2">
                        <input id="idIthem" style="text-align: center;"  readonly value="<?php echo $dfactura['matricula'] ?>" type="text" class="validate">
                        <label for="idItem">MATRICULA</label>
                      </div>
                      <div class="input-field col s12 m3 l2">
                        <input id="idmonto" style="text-align: center;"   readonly value="<?php echo $dfactura['tipotabla'] ?>" name="idmonto" step="any" type="text" class="validate">
                        <label for="idmonto">PAGO EN</label>
                      </div>
                      <div class="input-field col s12 m3 l2">
                        <input id="idtipo" style="text-align: center;"   value="<?php echo $tipopago ?>"name="idtipo" type="text" class="validate">
                        <label for="idmatricula">TIPO PAGO</label>
                      </div>
                       <div class="input-field col s12 m3 l2">
                        <input id="idref" style="text-align: center;"  value="<?php echo $dato['referencia'] ?>" name="idref" type="text" class="validate">
                        <label for="idItem">REF</label>
                      </div>
                      <div class="input-field col s12 m3 l2">
                        <input id="idlote" style="text-align: center;"  value="<?php echo $dato['lote'] ?>" name="idlote" step="any" type="text" class="validate">
                        <label for="idlote">LOTE</label>
                      </div>
                      
                      <div class="input-field col s12 m2 l2">
                        <a style="width: 100%" id="btnSave" class="btn waves-effect waves-light darken-3 green"><i class="fa fa-save"></i> MODIFICA TIPO PAGO </a>
                      </div>
                    </div>
                  </form>
                </div>&nbsp;
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
       $("#btnSave").click(function(){
        var str = $("#idform").serialize();
       // alert(str);
                swal({
                title: "Estas Seguro?",
                text: "se modificara el tipo pago",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28e29e",
                confirmButtonText: "Estoy Seguro",
                closeOnConfirm: false
              }, function () {      
                $.ajax({
                  url: "actualiza.php",
                  type: "POST",
                  data: str,
                  success: function(resp){
                    $("#idresultado").html(resp);
                  }   
                });
            }); 

        });
    </script>
</body>

</html>