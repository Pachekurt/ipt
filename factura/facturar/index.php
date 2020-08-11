<?php
  $ruta="../../";
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Facturar Servicio Adicional";
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
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcliente" id="idcliente" value="0">
                    <div class="row">
                      <div class="input-field col s12 m9 l4">
                        <input id="idnit" style="text-align: center;" placeholder="Ingrese la Nit del Titular..." name="idnit" type="number" class="validate">
                        <label for="idnit">CI/NIT</label>
                      </div>
                      <div class="input-field col s12 m9 l4">
                        <input id="idrazon" style="text-align: center;" placeholder="Ingrese la Nombre o Razon Social..." name="idrazon" type="text" class="validate">
                        <label for="idrazon">RAZON SOCIAL</label>
                      </div>
                      <div class="input-field col s12 m3 l4">
                        <a style="width: 100%" id="btnSavefact" class="btn waves-effect waves-light darken-3 purple"><i class="fa fa-save"></i> GUARDAR CLIENTE </a><br><br><br>
                      </div>
                      <div class="input-field col s12 m3 l4">
                        <input id="idItem" style="text-align: center;" value="Pago Mensualidad" readonly name="idItem" type="text" class="validate">
                        <label for="idItem">ITEM</label>
                      </div>
                      <div class="input-field col s12 m3 l3">
                        <input id="idmonto" style="text-align: center;" placeholder="Ingrese Monto a Facturar..." name="idmonto" step="any" type="number" class="validate">
                        <label for="idmonto">Monto</label>
                      </div>
                      <div class="input-field col s12 m3 l3">
                        <input id="idmatricula" style="text-align: center;" placeholder="Ingrese Matricula..." name="idmatricula" type="text" class="validate">
                        <label for="idmatricula">Matricula</label>
                      </div>
                      <div class="input-field col s12 m2 l2">
                        <a style="width: 100%" id="btnSave" class="btn waves-effect waves-light darken-3 green"><i class="fa fa-save"></i> GENERAR FACTURA </a>
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
       $("#btnSavefact").click(function(){
        var str = $("#idform").serialize();
        $.ajax({
          async: true,
          url: "guardaRazon.php?"+str,
          type: "get",
          dataType: "html",
          success: function(data){
            console.log(data);
            var json = eval("("+data+")");
            if (json.flag==1) {
              $("#idcliente").val(json.idcliente);
              swal(
                'Exito',json.msg,'success'
              );
            }else{
              swal(
                'Error',json.msg,'warning'
              );
            }
          }
        });
      });
      $("#btnSave").click(function(){
        if (validar()) {
        swal({
          title: "GENERAR FACTURA",
          text: "Estas seguro de registrar la operacion?",
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
            swal('Cuidado!','Falstan Datos','warning');
          }
      });
      function validar(){
        retorno=true;
        if ($('#idItem').val()=="" || $('#idItem').val()=="" || $('#idmonto').val()=="" || $('#idmatricula').val()=="") {
          retorno=false;
        }
        return retorno;
      }
    </script>
</body>

</html>