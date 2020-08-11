<?php
  $ruta="../../../";
  session_start();
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/cobcartera.php");
  $cobcartera=new cobcartera;
  include_once($ruta."class/admcontratodelle.php");
  $admcontratodelle=new admcontratodelle;
  include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;
  include_once($ruta."class/factura.php");
  $factura=new factura;
  include_once($ruta."class/vpagotit.php");
  $vpagotit=new vpagotit;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
  $valor=dcUrl($lblcode);
  $dfactura=$factura->muestra($valor);
  $dpago=$vpagotit->muestra($dfactura['idtabla']);
  $razonT=$dpago['razon'];
  $nitT=$dpago['nit'];
/************************************************/
// condicionamos la fecha inicio
//echo $dfactura['nro'];
/*************************************/
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Anulación de Factura";
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_tabla.php");
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
          $idmenu=58;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
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
            <div class="row">
              <div class="formcontent">
                <div class="col s12 m4 l3">
                  <h4 class="titulo">Anulación de Factura</h4>
                  <p style="text-align: justify;">
                    En esta opcion podras anular la factura. Deberas hacer click en solicitar autorizacion para poder realizar esta operacion. Solo se podra anular facturas por cambio de nit o razón social y no asi montos.
                  </p>
                </div>
                <div class="col s12 m8 l9">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                    <div class="row">
                      <div class="input-field col s12 m6 l2">
                        <button id="btnSolicita" style="width: 100%" id="idsolicita" class="btn purple "><i class="fa fa-send"></i> Solicitar Anulación</button>
                      </div>
                      <div class="input-field col s12 m6 l4">
                        <textarea id="iddesc" name="iddesc" class="materialize-textarea">Solicito la anulación de la factura de recaudaciones número <?php echo $dfactura['nro'] ?> con matrícula <?php echo $dfactura['matricula'] ?> por motivo de error en  </textarea>
                        <label for="iddesc">Motivo de Anulación</label>
                      </div>
                      <div class="input-field col s12 m6 l4">
                        <div id="respuestaSol"></div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col s12 m12 l12">
                  <div class="divider"></div>
                  <div id="opsAnular" style="display: none;" >
                    <div class="col s12 m12 l6">
                      <div class="titulo">Datos de factura</div>
                      <table class="cssdato">
                        <tr>
                          <td class="sub" style="width: 15%;">Nro Factura</td>
                          <td style="width: 35%;"><?php echo $dfactura['nro'] ?></td>
                          <td class="sub" style="width: 15%;">Matricula</td>
                          <td><?php echo $dfactura['matricula'] ?></td>
                        </tr>
                        <tr>
                          <td class="sub" style="width: 15%;">Nit</td>
                          <td style="width: 35%;"><?php echo $nitT ?></td>
                          <td class="sub" style="width: 15%;">Razon Social</td>
                          <td><?php echo $razonT ?></td>
                        </tr>
                        <tr>
                          <td class="sub" style="width: 15%;">Fecha</td>
                          <td style="width: 35%;"><?php echo $dfactura['fecha'] ?></td>
                          <td class="sub" style="width: 15%;">Total</td>
                          <td><?php echo $dfactura['total'] ?></td>
                        </tr>
                        <tr>
                          <td class="sub" style="width: 15%;">Codigo Control</td>
                          <td style="width: 35%;"><?php echo $dfactura['control'] ?></td>
                          <td class="sub" style="width: 15%;"></td>
                          <td><a style="width: 100%" href="../../../factura/impresion/computarizada/?lblcode=<?php echo $lblcode ?>" target="_blank" class="btn-jh purple"><i class="fa fa-eye"></i> Ver factura</a></td>
                        </tr>
                      </table>
                    </div>
                    <div class="col s12 m12 l6">
                      <form class="col s12" id="idformfact" action="return false" onsubmit="return false" method="POST">
                        <input type="text" name="idautorizacion" id="idautorizacion">
                        <div class="titulo">Rectificar Factura</div>
                        <div class="input-field  col s12">
                          <input id="idnit" value="<?php echo $nitT ?>" name="idnit" type="text"  >
                          <label for="idnit">NIT/CI</label>
                        </div>
                        <div class="input-field  col s12">
                          <input id="idrazon" name="idrazon" value="<?php echo $razonT ?>" type="text"  >
                          <label for="idrazon">NOMBRE/RAZON SOCIAL</label>
                        </div>
                        <div class="input-field  col s12">
                          <button id="btnSavefact" class="btn orange darken-4" style="width: 100%;"><i class="fa fa-save"></i> Anular Factura</button>
                        </div>&nbsp;
                      </form>
                    </div>
                  </div>&nbsp;
                </div>&nbsp;<br><br><br><br><br><br><br><br><br><br>
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
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">
      $("#iddesc").focus();
      $("#btnSolicita").click(function(){
        /************************************/
        codigo="<?php echo $valor ?>";
        detalle=$("#iddesc").val();
        origen=140;
        /************************************/
        var str="codigo="+codigo+"&detalle="+detalle+"&origen="+origen;
        $.ajax({
          async: true,
          url: "../../../administracion/autorizacion/solicitar.php?"+str,
          type: "get",
          dataType: "html",
          success: function(data){
            console.log(data);
            var json = eval("("+data+")");
            if (json.estado==-1) {
              //registrado
              $('#opsAnular').hide();
              $("#respuestaSol").html('<div id="card-alert" class="card green lighten-5"><div class="card-content green-text"><p>'+json.msg+'</p></div></div>');
            }
            if (json.estado==0) {
              //en espera
              $('#opsAnular').hide();
              $("#iddesc").val(json.detalle);
              $("#respuestaSol").html('<div id="card-alert" class="card light-blue"> <div class="card-content white-text"><p>'+json.msg+'</p></div</div>');
            }
            if (json.estado==1) {
              //aprobado
              $("#idautorizacion").val(json.id);
              $('#opsAnular').show("slow");
              $("#iddesc").val(json.detalle);
              $("#respuestaSol").html('<div id="card-alert" class="card green"><div class="card-content white-text"><p><i class="mdi-navigation-check"></i>'+json.msg+'</p></div></div>');
              $("#idnit").focus();
            }
            if (json.estado==2) {
              $('#opsAnular').show("slow");
              $("#iddesc").val(json.detalle);
              $("#respuestaSol").html('<div id="card-alert" class="card red"><div class="card-content white-text"><p><i class="mdi-notification-sync-disabled"></i> '+json.msg+'</p></div></div>');
            }
          }
        });
      });
      $("#btnSavefact").click(function(){
        swal({   
            title: "Anular?",   
             text: "Esta Seguro de Anular Factura?",   
             type: "warning",   
             showCancelButton: true,   
             closeOnConfirm: false,   
             showLoaderOnConfirm: true, 
           }, 
             function(){
              if (validar()) {
                $('#btnSavefact').attr("disabled",true);
                var str = $( "#idformfact" ).serialize();
              //  alert(str);
                $.ajax({
                  url: "guardar.php",
                  type: "POST",
                  data: str+"&idfactura=<?php echo $valor ?>",
                  success: function(resp){
                    
                    setTimeout(function(){     
                      console.log(resp);
                      $('#idresultado').html(resp);   
                    }, 2000); 
                  }
                });
              }
        });
      });
      function validar(){
        retorno=true;
        /*
        operacion=$("#idoperacion").val();
        if (operacion=="0") {
          retorno=false;
          swal(
            'Error','Tiene que Seleccionar el Monto','error'
          );
        }
        */
        return retorno;
      }
    </script>
</body>
</html>