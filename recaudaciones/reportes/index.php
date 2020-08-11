<?php
  $ruta="../../";
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
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
  $idsede=$_SESSION["idsede"];
  $dse=$sede->muestra($idsede);
/************************************************/
// condicionamos la fecha inicio

/*************************************/
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Reportes Cartera ".$dse['nombre'];
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
                  <h4 class="titulo">Reportes Cartera</h4>
                  <p style="text-align: justify;">
                    Estado de cartera disgregado segun las opciones que se muestra a continuación.
                  </p>
                </div>
                <div class="col s12 m8 l9">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                    <div class="row">
                      <div class="input-field col s2">
                        <label>SEDE</label>
                        <select id="codsede" name="codsede">
                          <?php
                            foreach($sede->mostrarTodo("") as $f)
                            {
                              ?>
                                <option value="<?php echo $f['idsede']; ?>"><?php echo $f['nombre']; ?></option>
                              <?php
                            }
                          ?>
                        </select>
                      </div>
                      <div class="input-field col s12 m6 l2">
                        <input id="idfecha" style="text-align: center;" readonly name="idfecha" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                        <label for="idfecha">Fecha</label>
                      </div>
                      <div class="input-field col s4">
                        <label>SELECCIONE REPORTE</label>
                        <select id="codtipo" name="codtipo">
                          <option value="1">LISTADO GENERAL DE CARTERA</option>
                          <option value="2">CARTERA VIGENTE</option>
                          <option value="3">CARTERA VENCIDA</option>
                          <option value="4">CARTERA PROXIMA VIGENCIA</option>
                          <option value="5">CARTERA PREJURIDICA</option>
                          <option value="6">CARTERA JURIDICA</option>
                          <option value="7">ADMINISTRACION</option>
                        </select>
                      </div>
                      <div class="input-field col s12 m6 l4">
                        <a style="width: 100%" id="btnSsave" class="btn waves-effect waves-light darken-3 purple"><i class="fa fa-save"></i> GENERAR REPORTE</a><br><br><br>
                      </div>
                    </div>
                  </form>
                </div>&nbsp;
                <div class="col s12 m12 l12">
                  <div class="divider"></div>
                </div>
                <div class="col s12 m4 l3">
                  <h4 class="titulo">Cartera Ejecutivo</h4>
                  <p style="text-align: justify;">
                    Estado de cartera disgregado por vigente y vencido por ejecutivo seleccionado
                  </p>
                </div>
                <div class="col s12 m8 l9">
                  <form class="col s12" id="idformej" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                    <div class="row">
                      <div class="input-field col s12 m6 l2">
                        <input id="idfechaej" style="text-align: center;" readonly name="idfechaej" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                        <label for="idfechaej">Fecha</label>
                      </div>
                      <div class="input-field col s4">
                        <select id="idejecutivo" name="idejecutivo">
                        <option disabled value="">Seleccionar Ejecutivo...</option>
                        <?php
                        foreach($vejecutivo->mostrarTodo("estado=1 and idsede=$idsede and idorganizacion in(19,20,21)") as $f)
                        {
                          ?>
                          <option value="<?php echo $f['idvejecutivo']; ?>"><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno']?></option>
                          <?php
                        }
                        ?>
                        <option value="1">PROXIMA VIGENCIA</option>
                        <option value="2">PRE-JURIDICA</option>
                        <option value="3">JURIDICA</option>
                      </select>
                      </div>
                      <div class="input-field col s12 m6 l4">
                        <a style="width: 100%" id="btnSsaveEje" class="btn waves-effect waves-light darken-3 blue"><i class="fa fa-save"></i> GENERAR REPORTE</a><br><br><br>
                      </div>
                    </div>
                  </form>
                </div>&nbsp;
                <div class="col s12 m12 l12">
                  <div class="divider"></div>
                </div>&nbsp;<br><br><br><br><br><br>
              </div>
            </div>
          </div>
          <?php
            include_once("../footer.php");
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
      $("#idfechaCon").change(function() {
        //alert($("#idfechaCon").val() );
        location.href="?fechaGen="+$("#idfechaCon").val();
      });
      $("#btnSsave").click(function(){
        //alert($("#idfechaCon").val() );
        window.open("imprimir/?fechaGen="+$("#idfecha").val()+'&rpt='+$("#codtipo").val()+'&idsede='+$("#codsede").val(),"_blank");
      });
      $("#btnSsaveEje").click(function(){
        window.open("imprimir/ejecutivo.php?fechaGen="+$("#idfechaej").val()+'&idejecutivo='+$("#idejecutivo").val(),"_blank");
      });
      $("#btnSave").click(function(){
        swal({
          title: "Consolidar?",
          text: "Deseas consolidar el Parte diario?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {
          $('#btnSave').attr("disabled",true);
          var str ="fechaGen="+$("#idfechaCon").val();
          $.ajax({
            url: "guardarParte.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
        }); 
      });
      function guardaH(id){
        var hora=$('#c'+id).val();
        var obs=$('#o'+id).val();
        var str="hora="+hora+"&id="+id+"&obs="+obs;
        $.ajax({
          url: "guardar.php",
          type: "POST",
          data: str,
          success: function(resp){
            console.log(resp);
            $('#idresultado').html(resp);
          }
        });
      }
      $('.cuentaCaja').formatter({
        'pattern': '110-1-{{99999}}',
        'persistent': true
      });
      $('#example').DataTable();
       $('#example5').DataTable();
      $('#example1').DataTable();
    </script>
</body>
</html>