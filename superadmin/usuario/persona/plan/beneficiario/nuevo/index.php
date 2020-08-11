<?php
  $ruta="../../../../../../../";
  include_once($ruta."class/vejecutivopersona.php");
  $vejecutivopersona=new vejecutivopersona;
  include_once($ruta."class/personaplan.php");
  $personaplan=new personaplan;
  include_once($ruta."class/admplan.php");
  $admplan=new admplan;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/persona.php");
  $persona=new persona;
   include_once($ruta."class/titular.php");
  $titular=new titular;
  include_once($ruta."funciones/funciones.php");
  session_start();  
  extract($_GET);
  $idcontrato=dcUrl($lblcode);
  $lblcontrato=$idcontrato;
  $dcontrato=$admcontrato->mostrar($idcontrato);
  $dcontrato=array_shift($dcontrato);

  $dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
  $dper=$persona->mostrar($dtit['idpersona']);
  $dper=array_shift($dper);

  $dsede=$sede->mostrar($dcontrato['idsede']);
  $dsede=array_shift($dsede);

  $destado=$dominio->mostrar($dcontrato['estado']);
  $destado=array_shift($destado);


  $dejecutivo=$vejecutivopersona->mostrar($dcontrato['idadmejecutivo']);
  $dejecutivo=array_shift($dejecutivo);

  $titulaper= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
  $ejecutivo= $dejecutivo['nombre']." ".$dejecutivo['paterno']." ".$dejecutivo['materno'];
  $idpersona=$dtit['idpersona'];

  $perplan=$personaplan->mostrarUltimo("idpersonaplan=".$lblperplan);
  //verificamos si tiene cupo para el beneficiario
  $dplan=$admplan->mostrarTodo("idadmplan=".$perplan['idadmplan']);
  $dplan=array_shift($dplan);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Registrar Titular";
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
          $idmenu=26;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="row">
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title">Registrar Plan</h5>
                  <ol class="breadcrumbs">
                    <li><a href="../../../editar/?lblcode=<?php echo $lblcode ?>"> Persona y Facturación </a></li>
                    <li><a href="../../../domlab/?lblcode=<?php echo $lblcode ?>"> Domicilios y Trabajos</a></li>
                    <li class="activoTab"><a href="../../../plan/?lblcode=<?php echo $lblcode ?>"> Plan </a></li>
                  </ol>
                </div>
                <div class="col s7 m7 l7">
                  <table class="csscontrato">
                    <thead>
                      <tr>
                        <th>Plan</th>
                        <th>Ejecutivo</th>
                        <th>Titular</th>
                        <th>Contrato</th>
                        <th>Sede</th>
                        <th>Estado</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $dplan['personas']." ".$dplan['nombre'] ?></td>
                        <td><?php echo $ejecutivo ?></td>
                        <td><?php echo $titulaper ?></td>
                        <td><?php echo $dcontrato['nrocontrato'] ?></td>
                        <td><?php echo $dsede['nombre'] ?></td>
                        <td><?php echo $destado['nombre'] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </di5
              </div>
          </div>
          <div class="container">
            <div class="row">
              <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <div class="col s6 m6 l6">
                    <h4 class="header">Datos del Titular</h4>
                    <div class="formcontent">
                      <div class="row">
                        <div id="valCarnet" class="col s12"></div>
                        <div class="input-field col s6">
                          <input id="idcarnet" name="idcarnet" type="text" class="validate">
                          <label for="idcarnet">CARNET</label>
                        </div>
                        <div class="input-field col s6">
                          <label>Expedido</label>
                          <select id="idexp" name="idexp">
                            <option disabled value="">Seleccionar Departamento</option>
                            <?php
                              foreach($dominio->mostrarTodo("tipo='DEP'") as $f)
                              {
                                ?>
                                  <option value="<?php echo $f['short']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s6">
                          <input id="idnombre" name="idnombre" type="text" class="validate">
                          <label for="idnombre">Nombre(s)</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idpaterno" name="idpaterno" type="text" class="validate">
                          <label for="idpaterno">Paterno</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idmaterno" name="idmaterno" type="text" class="validate active">
                          <label for="idmaterno">Materno</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idnacimiento" name="idnacimiento" type="date" class="validate">
                          <label for="idnacimiento">Fecha Nacimiento</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idemail" name="idemail" type="email" class="validate">
                          <label for="idemail">Email</label>
                        </div>  
                        <div class="input-field col s6">
                          <input id="idcelular" name="idcelular" type="text" class="validate">
                          <label for="idcelular">Celular(es)</label>
                        </div>
                        <div class="input-field col s6">
                          <label>Sexo</label>
                          <select id="idsexo" name="idsexo">
                              <option value="1">MASCULINO</option>
                              <option value="2">FEMENINO</option>
                          </select>
                        </div>
                        <div class="input-field col s6">
                          <label>Parentesco</label>
                          <select id="idparentesco" name="idparentesco">
                            <?php
                              foreach($dominio->mostrarTodo("tipo='PA'") as $f)
                              {
                                ?>
                                  <option value="<?php echo $f['iddominio']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12">
                          <input id="idocupacion" name="idocupacion" type="text" class="validate">
                          <label for="idocupacion">Ocupacion</label>
                        </div>                     
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <a id="btnLimpiar" class="btn waves-effect waves-light orange"><i class="fa fa-save"></i> Limpiar</a>
                          <a id="btnSave" class="btn waves-effect waves-light blue"><i class="fa fa-save"></i> Guardar</a>
                        </div>
                      </div>
                    </div>
                </div>
              </form>
            </div>
          </div>
          <?php
            include_once("../../../../../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
    ?>
    <script type="text/javascript">
      $("#idcarnet").change(function(){
        carnet=$('#idcarnet').val();
          $.ajax({
            url: "validaCarnet.php",
            type: "POST",
            data: "carnet="+carnet+"&lblcode=<?php echo $lblcode ?>&lblperplan=<?php echo $lblperplan ?>&idpersona=<?php echo $idpersona ?>",
            success: function(resp){
              console.log(resp);
              $('#valCarnet').html(resp).slideDown(500);
            }
          });
      });
      $("#btnSave").click(function(){
        $('#btnSave').attr("disabled",true);
        $("#valCarnet").html("").slideUp(300);
        var nombreVal1 = $("#idnombre").val();
        var carnetVal1 = $("#idcarnet").val();
        if (nombreVal1 == '' || carnetVal1 == '') 
        {
          $("#valCarnet").html("<div id='card-alert' class=' red'><div class=' white-text'><p><i class='mdi-navigation-check'></i> Datos Faltantes. Carnet o Nombre</p></div> </div>").slideDown(500);
        }else {
          swal({
            title: "CONFIRMACION",
            text: "Se creara el beneficiario",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "GUARDAR",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idform" ).serialize();
            //alert(str);
            $.ajax({
              url: "guardar.php",
              type: "POST",
              data: str+"&lblcode=<?php echo $lblcode ?>&lblperplan=<?php echo $lblperplan ?>&idpersona=<?php echo $idpersona ?>",
              success: function(resp){
                console.log(resp);
                 $("#idresultado").html(resp);
              }
            }); 
          });
        }  
      });
    </script>
</body>

</html>