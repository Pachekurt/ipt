<?php
  session_start();  
  extract($_GET);
  $idusuario=$_SESSION["codusuario"];
  
  $ruta="../../../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admorganidet.php");
  $admorganidet=new admorganidet;
  include_once($ruta."class/vorganigrama.php");
  $vorganigrama=new vorganigrama;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/admorgani.php");
  $admorgani=new admorgani;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/admsemana.php");
  $admsemana=new admsemana;
  include_once($ruta."class/admvigencia.php");
  $admvigencia=new admvigencia;
  include_once($ruta."funciones/funciones.php");
  $dusuario=$usuario->muestra($idusuario);
  $idejecutivo=$dusuario['idadmejecutivo'];
  $dejecutivo=$vejecutivo->muestra($idejecutivo);

  $idorganizacion=dcUrl($lblcode);
  $dorg=$admorganizacion->muestra($idorganizacion);
  $dsede=$sede->muestra($dorg['idsede']);

  $dsemana=$admsemana->mostrarUltimo("estado=1");
  $dvig=$admvigencia->muestra($dsemana['idadmvigencia']);


  $dejec=$vejecutivo->muestra($idejecutivo);

  $encargado=$dejec['nombre'].' '.$dejec['paterno'].' '.$dejec['materno'];
  $nsede=$dsede['nombre'];
  $organizacion=$dorg['nombre'];
  $vigencia=$dvig['nombre']." VIGENCIA - SEMANA ".$dsemana['nro'];


  /*********************************************************************************/
  $deje=$vorganigrama->mostrarPrimero("padre=1");
  //echo $dusuario['idadmejecutivo'].$deje['nombre']." EN VIVO";

  $idOrg=$lblcod;

  $idOgrz=dcUrl($lblcode);
  $lblcodigo=ecUrl($idOrg);
  $dorgDet=$admorganidet->mostrarPrimero("padre=0 and idadmorgani=".$idOrg);
  $idorgdeta=$dorgDet['idadmorganidet'];
  $dorg=$admorgani->muestra($dorgDet['idadmorgani']);
  $dorgz=$admorganizacion->muestra($dorg['idadmorganizacion']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Configurar Organigrama";
      include_once($ruta."includes/head_basico.php");
    ?>
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <style type="text/css">
    .btj{
      border: none;
      padding: 0px 4px;
      color: white;
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
                        <th>Vigencia</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $encargado ?></td>
                        <td><?php echo $nsede ?></td>
                        <td><?php echo $organizacion ?></td>
                        <td><?php echo $vigencia ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <button id="btnOrg" class="btn"><i class="fa fa-eye"></i> VER ORGANIGRAMA RESULTANTE</button>
              </div>
              
              <div id="modal-bottom-sheet">
                <div class="row">
                  <div class="col s12 m4 l3">
                    &nbsp;
                  </div>
                  <div class="col s12 m8 l9">
                    <div id="modal5" class="modal bottom-sheet">
                      <div class="modal-content">
                        <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                          <div class="row">
                            <input type="hidden" name="idorganigrama" id="idorganigrama" value="<?php echo $idOrg ?>">
                            <input type="hidden" name="idpadre" id="idpadre">
                            <div class="input-field col s12">
                              <label>AÑADIR A </label>
                              <select id="idejecuti" name="idejecuti">
                              </select>
                            </div>
                            <div class="input-field col s12">
                              <label>AGREGAR COMO</label>
                              <select id="idtipoeje" name="idtipoeje">
                                <option value="0">EJECUTIVO</option>
                                <option value="1">SERVICIOS PROFESIONALES</option>
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <a href="#" class="btn waves-effect waves-light light-blue darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</a>
                            <button id="btnSave" class="btn waves-effect waves-light darken-4 green"><i class="fa fa-save"></i> CREAR DEPENDENCIA</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col s12 m12 l12">
                <div class="organigrama">
                  <?php
                    $idinicio=$idorgdeta;
                    $f=$vorganigrama->mostrarPrimero("idvorganigrama =".$idinicio);
                    $acciones=' <button href="#modal5" onclick="agregarBtn('.$f["idvorganigrama"].');" style="color: white;" class="green modal-trigger btj"> <i class="fa fa-plus-square"></i> </button> ';
                    echo '<ul><li ><a class="ornombre">'.$f["nombre"].'<br>'.$f["paterno"].' '.$f["materno"].'</a><br><span class="orcargo">'.$f['ncargo'].'</span>'.$acciones;
                    $dato=$vorganigrama->mostrarTodo("padre=".$idinicio);
                    if (count($dato)>0)$vorganigrama->bucleOrgConfig($idinicio);
                    echo '</li></ul>';
                  ?>
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
    $("#btnOrg").click(function(){
      window.open("../data.php?lblcode=<?php echo $lblcodigo ?>" , "ventana1" , "width=1000,height=400,scrollbars=NO"); 
    });
    $("#btnSave").click(function(){
      $('#btnSave').attr("disabled",true);
      var str = $( "#idform" ).serialize();
      //alert(str);
      $.ajax({
        url: "guardar.php",
        type: "POST",
        data: str,
        success: function(resp){
          console.log(resp);
           $("#idresultado").html(resp);
        }
      }); 
    });
    function agregarBtn(id){
      $("#idpadre").val(id);
      $("#idejecuti").empty().html(' ');
      $.post("cargarEjecutivo.php",{"idorgz":"<?php echo $idOgrz ?>","ideje":id,},function(ejecutivos){  
        console.log(ejecutivos);   
        var cmdejec=$("#idejecuti");
          cmdejec.empty();
          $.each(ejecutivos,function(idejecutivo,ejec){
            $("#idejecuti").append( $("<option></option>").attr("value",ejec.idejecutivo).text(ejec.nombre+' :'+ejec.cargo));
          });
          $("#idejecuti").material_select('update');
          $("#idejecuti").closest('.input-field').children('span.caret').remove();
      },'json');
      /*************************************************************************************/
    }
    function quitarBtn(id){
        swal({
          title: "Estas Seguro?",
          text: "Quitaras al ejecutivo del organigrama",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {      
          $.ajax({
            url: "quitar.php",
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