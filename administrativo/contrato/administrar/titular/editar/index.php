<?php
  $ruta="../../../../../";
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/admorgani.php");
  $admorgani=new admorgani;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/admorganidet.php");
  $admorganidet=new admorganidet;
   include_once($ruta."class/titular.php");
  $titular=new titular;

  include_once($ruta."funciones/funciones.php");
  session_start();  
  extract($_GET);
  $valor=dcUrl($lblcode);
  $lblcontrato=$valor;
  $dcontrato=$admcontrato->mostrar($valor);
  $dcontrato=array_shift($dcontrato);

  $dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
  $idpersona=$dtit['idpersona'];
  $dper=$persona->mostrar($dtit['idpersona']);
  $dper=array_shift($dper);

  $dsede=$sede->mostrar($dcontrato['idsede']);
  $dsede=array_shift($dsede);

  $destado=$dominio->mostrar($dcontrato['estado']);
  $destado=array_shift($destado);

  $dejec=$vejecutivo->mostrar($dcontrato['idadmejecutivo']);
  $dejec=array_shift($dejec);

  $titulaper= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
  $ejecutivo= $dejec['nombre']." ".$dejec['paterno']." ".$dejec['materno'];

  $idpersona=ecUrl($dper['idpersona']);
  $idtitular=ecUrl($dcontrato['idtitular']);

  /************ nuevas validaciones  **********/
  $dorgz=$admorganizacion->muestra($dejec['idorganizacion']);
  $nOrgz=$dorgz['nombre'];
  // validar que hay un organigrama vigente de su organizacion
  $dorg=$admorgani->mostrarUltimo("idadmorganizacion=".$dejec['idorganizacion']." and estado=1");
  $idorganigrama=$dorg['idadmorgani'];
  $dordet=$admorganidet->mostrarUltimo("idadmejecutivo=".$dcontrato['idadmejecutivo']." and idadmorgani=".$idorganigrama);
  $lblcod=ecUrl($idorganigrama);
  //   ACA FALTA LA VALIDACION QUE SIEMPRE HAYA UN ORGANIGRAMA ACTIVO
  $sww=false;
  if (count($dordet)<1) {
    $sww=true;
  }

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
          $idmenu=1000;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--validacion que haya siempre un organigrama activo-->
          <?php
          if ($sww) {
          ?>
          <div class="orange" id="breadcrumbs-wrapper">
            <center style="color: white;" > <?php echo $ejecutivo; ?> no esta incluido en el organigrama vigente de su organizacion. Esto puede generar conflicos al realizar las operaciones. </center>
          </div>
          <?php
            }
          ?>
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l5">
                  <h5 class="breadcrumbs-title">Registrar Titular</h5>
                  <ol class="breadcrumbs">
                    <li class="activoTab"><a href="../editar/?lblcode=<?php echo $lblcode ?>"> Persona y Facturación </a></li>
                    <li><a href="../domlab/?lblcode=<?php echo $lblcode ?>"> Domicilios y Trabajos</a></li>
                    <li><a href="../plan/?lblcode=<?php echo $lblcode ?>"> Plan </a></li>
                  </ol>
                </div>
                <div class="col s12 m12 l7">
                  <table class="csscontrato">
                    <thead>
                      <tr>
                        <th>Ejecutivo</th>
                        <th>Organizacion</th>
                        <th>Titular</th>
                        <th>Contrato</th>
                        <th>Sede</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $ejecutivo ?></td>
                        <td><?php echo $nOrgz ?></td>
                        <td><?php echo $titulaper ?></td>
                        <td><?php echo $dcontrato['nrocontrato'] ?></td>
                        <td><?php echo $dsede['nombre'] ?></td>
                        <td>
                          <?php echo $destado['nombre'] ?>
                        </td>
                        <td>
                          <a href="../../record/?lblcode=<?php echo $lblcode ?>" style="color: green; font-weight: bold;" target="_blank" class="btn-jh waves-effect darken-1 yellow"><i class="fa fa-money"></i></a>
                          <a id="btnOrg" class="btn-jh waves-effect darken-4 purple"><i class="fa fa-sitemap"></i></a>
                          <a href="../../acciones/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 red"><i class="fa fa-recycle"></i></a>
                          <a href="../../imprimir/?lblcode=<?php echo $lblcode ?>" target="_blank" class="btn-jh waves-effect darken-4 indigo"><i class="fa fa-print"></i></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                <div class="col s12 m12 l6">
                    <input id="idpersona" name="idpersona" type="hidden" readonly value="<?php echo $idpersona; ?>">
                    <input id="idtitular" name="idtitular" type="hidden" readonly value="<?php echo $idtitular; ?>">
                    <h4 class="header">Datos del Titular</h4>
                    <div class="formcontent">
                      <div class="row">
                        <div id="valCarnet" class="col s12"></div>
                        <div class="input-field col s6">
                          <input id="idcarnet" name="idcarnet" readonly value="<?php echo $dper['carnet'] ?>" type="text" class="validate">
                          <label for="idcarnet">CARNET</label>
                        </div>
                        <div class="input-field col s6">
                          <label>Expedido</label>
                          <select id="idexp" name="idexp">
                            <option disabled value="">Seleccionar Departamento</option>
                            <?php
                              foreach($dominio->mostrarTodo("tipo='DEP'") as $f)
                              {
                                $sw="";
                                if ($dper['expedido']==$f['short']) {
                                   $sw="selected";
                                }
                                ?>
                                  <option <?php echo $sw ?> value="<?php echo $f['short']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s6">
                          <input id="idnombre" name="idnombre" value="<?php echo $dper['nombre'] ?>" type="text" class="validate">
                          <label for="idnombre">Nombre(s)</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idpaterno" name="idpaterno" value="<?php echo $dper['paterno'] ?>" type="text" class="validate">
                          <label for="idpaterno">Paterno</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idmaterno" name="idmaterno" value="<?php echo $dper['materno'] ?>" type="text" class="validate active">
                          <label for="idmaterno">Materno</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idnacimiento" name="idnacimiento" value="<?php echo $dper['nacimiento'] ?>" type="date" class="validate">
                          <label for="idnacimiento">Fecha Nacimiento</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idemail" name="idemail" value="<?php echo $dper['email'] ?>" type="email" class="validate">
                          <label for="idemail">Email</label>
                        </div>  
                        <div class="input-field col s6">
                          <input id="idcelular" name="idcelular" value="<?php echo $dper['celular'] ?>" type="text" class="validate">
                          <label for="idcelular">Celular(es)</label>
                        </div>
                        <div class="input-field col s4">
                          <label>Sexo</label>
                          <select id="idsexo" name="idsexo">
                              <?php
                              foreach($dominio->mostrarTodo("tipo='SX'") as $f)
                              {
                                $sw="";
                                if ($dper['idsexo']==$f['iddominio']) {
                                   $sw="selected";
                                }
                                ?>
                                  <option <?php echo $sw ?> value="<?php echo $f['iddominio']; ?>"><?php echo $f['nombre']; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s8">
                          <input id="idocupacion" name="idocupacion" value="<?php echo $dper['ocupacion'] ?>" type="text" class="validate">
                          <label for="idocupacion">Ocupacion</label>
                        </div>                       
                      </div>
                    </div>
                </div>
                <div class="col s12 m12 l6">
                    <h4 class="header"> Otros Datos</h4>
                    <div class="formcontent">
                      <div class="row">
                      </div>
                      <div class="divider"></div>
                      <div class="row">
                        <div class="input-field col s12">
                          <input id="idrazon" name="idrazon" value="<?php echo $dtit['razon'] ?>" type="text" class="validate">
                          <label for="idrazon">RAZON SOCIAL...</label>
                        </div>
                        <div class="input-field col s12">
                          <input id="idnit" name="idnit" value="<?php echo $dtit['nit'] ?>" type="number"  class="validate">
                          <label for="idnit">CI/NIT...</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <a id="btnSave" class="btn waves-effect waves-light blue"><i class="fa fa-save"></i> Actualizar Datos</a>
                        </div>
                      </div>
                    </div>
                </div>
              </form>
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
        window.open("../../../../organizacion/administrar/organigrama/data.php?lblcode=<?php echo $lblcod ?>" , "ventana1" , "width=1000,height=400,scrollbars=NO"); 
      });
      $("#idcarnet").change(function(){
        carnet=$('#idcarnet').val();
          $.ajax({
            url: "validaCarnet.php",
            type: "POST",
            data: "carnet="+carnet+"&lblcontrato=<?php echo $idcontrato ?>",
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
            text: "Se guardara el titular",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "GUARDAR",
            closeOnConfirm: false
          }, function () {
            var str = $( "#idform" ).serialize();
            $.ajax({
              url: "actualizar.php",
              type: "POST",
              data: str,
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