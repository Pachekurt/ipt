<?php
  $ruta="../../../../";
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
  include_once($ruta."class/domicilio.php");
  $domicilio=new domicilio;
  include_once($ruta."class/laboral.php");
  $laboral=new laboral;
   include_once($ruta."class/titular.php");
  $titular=new titular;
   include_once($ruta."class/personaplan.php");
  $personaplan=new personaplan;
   include_once($ruta."class/admplan.php");
  $admplan=new admplan;
   include_once($ruta."class/vvinculado.php");
  $vvinculado=new vvinculado;
   include_once($ruta."class/vsemana.php");
  $vsemana=new vsemana;
   include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;

  include_once($ruta."funciones/funciones.php");
  session_start();  
  extract($_GET);
  $valor=dcUrl($lblcode);
  $lblcontrato=$valor;
  $dcontrato=$admcontrato->muestra($valor);
  $dsemana=$vsemana->muestra($dcontrato['idadmsemana']);

  $dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
  $idpersona=$dtit['idpersona'];

  $dper=$persona->muestra($dtit['idpersona']);
  $dsede=$sede->muestra($dcontrato['idsede']);
  $destado=$dominio->muestra($dcontrato['estado']);
  $dejec=$vejecutivo->muestra($dcontrato['idadmejecutivo']);

  $titulaper= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
  $ejecutivo= $dejec['nombre']." ".$dejec['paterno']." ".$dejec['materno'];

  $idpersona=ecUrl($dper['idpersona']);
  $idtitular=ecUrl($dcontrato['idtitular']);
  /************ nuevas validaciones  **********/
  $dorgz=$admorganizacion->muestra($dejec['idorganizacion']);
  $nOrgz=$dorgz['nombre'];
  // validar que hay un organigrama vigente de su organizacion
  $lblcod=ecUrl($dcontrato['idorganigrama']);

  $dcp=$vcontratoplan->muestra($valor);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Registrar Titular";
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
          $idmenu=44;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l5">
                  <h5 class="breadcrumbs-title">DATOS DEL CONTRATO</h5>
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
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $ejecutivo ?></td>
                        <td><?php echo $nOrgz ?></td>
                        <td><?php echo $titulaper ?></td>
                        <td><?php echo $dcontrato['nrocontrato'] ?></td>
                        <td><?php echo $dsede['nombre'] ?></td>
                        <td><?php echo $destado['nombre'] ?></td>
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
                <div class="formcontent">
                  <div class="col s12 m12 l12">
                    <div class="col s12 m12 l12">
                      <a href="../" class="btn blue darken-3"><i class="fa fa-reply"></i> volver</a href="../">
                      <ul id="dropdown2" class="dropdown-content">
                        <li><a id="btnOrg">Ver organigrama<span class="badge"><i class="fa fa-sitemap"></i></span></a></li>
                        <li><a target="_blank" href="../../impresion/pagos/?lblcode=<?php echo $lblcode ?>">Ver Pagos<span class="badge"><i class="mdi-notification-event-note"></i></span></a></li>
                        <li><a href="#!">Imprimir Contrato<span class="badge"><i class="mdi-action-print"></i></span></a></li>
                        <li><a target="_blank" href="../../impresion/historial/?lblcode=<?php echo $lblcode ?>">Historial del Contrato<span class="badge"><i class="mdi-action-history"></i></span></a></li>
                        <li><a href="fotos.php?lblcode=<?php echo $lblcode ?>">Ver fotos<span class="badge"><i class="mdi-image-portrait"></i></span></a></li>
                      </ul>
                      <a class="btn dropdown-button"  data-activates="dropdown2">ACCIONES DEL CONTRATO <i class="mdi-navigation-arrow-drop-down right"></i></a>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div class="col s12 m8 l12">
                    <ul class="collapsible popout collapsible-accordion" data-collapsible="accordion">
                      <li>
                        <div class="collapsible-header"><i class="fa fa-clipboard"></i>Datos de Contrato</div>
                        <div class="collapsible-body">
                          <?php
                            $dperplan=$personaplan->muestra($dcontrato['idpersonaplan']);
                            $dplan=$admplan->muestra($dperplan['idadmplan']);
                          ?>
                          <table class="cssdato">
                            <tr>
                              <td class="sub" style="width: 15%;">Nro. Contrato</td>
                              <td style="width: 35%;"><?php echo $dcontrato['nrocontrato'] ?></td>
                              <td class="sub" style="width: 15%;">Nro. Cuenta</td>
                              <td><?php echo $dcontrato['cuenta'] ?></td>
                            </tr>
                            <tr>
                              <td class="sub">Vigencia</td>
                              <td><?php echo $dsemana['short'] ?></td>
                              <td class="sub">Sede</td>
                              <td><?php 
                                $dsedeC=$sede->muestra($dcontrato['idsede']);
                                echo $dsedeC['nombre'];
                               ?></td>
                            </tr>
                            <tr>
                              <td class="sub">Fecha Inicio</td>
                              <td><?php echo $dperplan['fechainicio'] ?></td>
                              <td class="sub">Fecha Fin</td>
                              <td><?php echo $dperplan['fechafin'] ?></td>
                            </tr>
                            <tr>
                              <td class="sub">Plan</td>
                              <td><?php echo $dplan['personas']." ".$dplan['nombre'] ?></td>
                              <td class="sub">Cuotas Restantes</td>
                              <td>
                                <?php 
                                  echo crestantes($dcp['inversion']-$dcontrato['pagado'],$dcp['inversion']-$dcontrato['pagado'],$dcp['cuotas'])." de ".($dcp['cuotas']+1)." EN PRODUCCION"; 
                                ?>
                              </td>
                            </tr>
                            <tr>
                              <td class="sub">Precio</td>
                              <td><?php echo $dplan['inversion'];?> Bs.-</td>
                              <td class="sub">Total Pagado</td>
                              <td>
                              <?php 
                                echo $dcontrato['pagado']." Bs.-";
                              ?>
                              </td>
                            </tr>
                            <tr>
                              <td class="sub">Fecha Registro</td>
                              <td><?php echo $dperplan['fechacreacion'] ?></td>
                              <td class="sub">Hora Registro</td>
                              <td><?php echo $dperplan['horacreacion'] ?></td>
                            </tr>
                          </table>
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header"><i class="mdi-action-assignment-ind"></i>Datos del Titular</div>
                        <div class="collapsible-body">
                          <table class="cssdato">
                            <tr>
                              <td class="sub" style="width: 15%;">Carnet</td>
                              <td style="width: 35%;"><?php echo $dper['carnet'] ?></td>
                              <td class="sub" style="width: 15%;">Expedido</td>
                              <td><?php echo $dper['expedido'] ?></td>
                            </tr>
                            <tr>
                              <td class="sub">Nombre</td>
                              <td><?php echo $dper['nombre'] ?></td>
                              <td class="sub">Paterno</td>
                              <td><?php echo $dper['paterno'] ?></td>
                            </tr>
                            <tr>
                              <td class="sub">Materno</td>
                              <td><?php echo $dper['materno'] ?></td>
                              <td class="sub">Fecha Nac.</td>
                              <td><?php echo $dper['nacimiento'] ?></td>
                            </tr>
                            <tr>
                              <td class="sub">Sexo</td>
                              <td>
                                <?php
                                  $dsexo=$dominio->muestra($dper['idsexo']);
                                  echo $dsexo['nombre'];
                                ?>
                              </td>
                              <td class="sub">Celulares</td>
                              <td><?php echo $dper['celular'] ?></td>
                            </tr>
                            <tr>
                              <td class="sub">Email</td>
                              <td><?php echo $dper['email'] ?></td>
                              <td class="sub">Ocupacion</td>
                              <td><?php echo $dper['ocupacion'] ?></td>
                            </tr>
                            <tr>
                              <td class="sub">Beneficiarios</td>
                              <td>
                              <?php 
                                foreach($vvinculado->mostrarTodo("idpersonaplan=".$dcontrato['idpersonaplan']) as $f){
                                  ?>
                                      Ben. <?php echo $f['nombre'].' '.$f['paterno'].' '.$f['materno']; ?><br>
                                  <?php
                                }
                              ?>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header"><i class="mdi-notification-event-note"></i>Datos de Facturacion</div>
                        <div class="collapsible-body">
                          <table class="cssdato">
                            <tr>
                              <td class="sub" style="width: 15%;">RAZON SOCIAL</td>
                              <td style="width: 35%;"><?php echo $dtit['razon'] ?></td>
                              <td class="sub" style="width: 15%;">NIT</td>
                              <td><?php echo $dtit['nit'] ?></td>
                            </tr>
                          </table>
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header"><i class="mdi-action-home"></i>Datos Domicilio</div>
                        <div class="collapsible-body">
                          <?php
                            $ddom=$domicilio->mostrarUltimo("idpersona=".$dper['idpersona']." and (indicador=1 or tipoDomicilio='PRINCIPAL')");
                          ?>
                          <table class="cssdato">
                            <tr>
                              <td class="sub" style="width: 15%;">Zona</td>
                              <td style="width: 35%;"><?php echo $ddom['idbarrio'] ?></td>
                              <td class="sub" style="width: 15%;">Direccion</td>
                              <td><?php echo $ddom['nombre'] ?></td>
                            </tr>
                            <tr>
                              <td class="sub">Telefonos</td>
                              <td><?php echo $ddom['telefono'] ?></td>
                              <td class="sub">Descripcion</td>
                              <td><?php echo $ddom['descripcion'] ?></td>
                            </tr>
                          </table>
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header"><i class="mdi-social-domain"></i>Datos Laborales</div>
                        <div class="collapsible-body">
                          <?php
                            $ddom=$laboral->mostrarUltimo("idpersona=".$dper['idpersona']." and indicador=1");
                          ?>
                          <table class="cssdato">
                            <tr>
                              <td class="sub" style="width: 15%;">Zona</td>
                              <td style="width: 35%;"><?php echo $ddom['idbarrio'] ?></td>
                              <td class="sub" style="width: 15%;">Direccion</td>
                              <td><?php echo $ddom['nombre'] ?></td>
                            </tr>
                            <tr>
                              <td class="sub">Telefonos</td>
                              <td><?php echo $ddom['telefono'] ?></td>
                              <td class="sub">Descripcion</td>
                              <td><?php echo $ddom['descripcion'] ?></td>
                            </tr>
                            <tr>
                              <td class="sub">Empresa</td>
                              <td><?php echo $ddom['empresa'] ?></td>
                              <td class="sub">Cargo</td>
                              <td><?php echo $ddom['cargo'] ?></td>
                            </tr>
                            <tr>
                              <td class="sub">Antiguedad</td>
                              <td><?php echo $ddom['antiguedad'] ?></td>
                              <td class="sub">Ingresos Mes</td>
                              <td><?php echo $ddom['ingresos'] ?></td>
                            </tr>
                          </table>
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header red-text"><i class="mdi-alert-error"></i>Observaciones</div>
                        <div class="collapsible-body">
                          <div id="card-alert" class="card lighten-5">
                            <div class="card-content">
                              <table id="tablajson" class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                  <tr>
                                    <th>NRO.</th>
                                    <th>DATO</th>
                                    <th>DETALLE</th>
                                    <!--<th>DATO</th>-->
                                  </tr>
                                </thead>
                                <tbody>                         
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>&nbsp;
                </div>
              </div>
              <?php
              if ($dcontrato['estado']!=67) {
                ?>
                <div class="col s12 m6 l6">
                  <div class="formcontent">
                    <div class="titulo">Observar contrato</div>
                    <div class="col s12 m12 l12">
                      <form id="idform" action="return false" onsubmit="return false" method="POST">
                        <div class="row">
                          <div class="input-field col s12">
                            <textarea id="idobs" name="idobs" class="materialize-textarea"></textarea>
                            <label for="idobs">INDIQUE LA OBSERVACION</label>
                          </div>
                          <div class="input-field col s12 m6 l6">
                            <center>
                              <button id="btnSave" class="btn darken-4 orange" style="width: 100%"><i class="fa fa-pause"></i> OBSERVAR CONTRATO</button>
                            </center>
                          </div> 
                        </div>
                      </form>
                    </div>&nbsp;
                  </div>
                </div>
                <div class="col s12 m6 l6">
                  <div class="formcontent">
                    <div class="titulo">Aprobar contrato</div>
                    <div class="col s12 m12 l12">
                      <form id="idform2" action="return false" onsubmit="return false" method="POST">
                      <div class="row">
                          <div class="input-field col s12">
                            <textarea id="idobs2" name="idobs2" class="materialize-textarea"></textarea>
                            <label for="idobs2">ALGO QUE QUIERA AGREGAR ?</label>
                          </div>
                          <div class="input-field col s12 m6 l6">
                            <center>
                              <button id="btnSave2" class="btn darken-4 green" style="width: 100%"><i class="fa fa-check"></i> APROBAR CONTRATO</button>
                            </center>
                          </div> 
                        </div>
                      </form>
                    </div>&nbsp;
                  </div>
                </div>
                <?php
              }
              ?>
              
            </div>
          </div>
        </div>
        <?php
          include_once("../../../footer.php");
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
      listarProductos();
      function listarProductos(){
        $("#tablajson").dataTable().fnDestroy();
        idcontrato="<?php echo $valor ?>";
        var table=$("#tablajson").dataTable({
          "ajax":{
              "method":"POST",
              "url":"../operaciones/muestraerroresInfoProd.php?idcontrato="+idcontrato
          },
          "columns":[
              {"data":"nro"},
              {"data":"dato"},
              {"data":"detalle"},
              //{"defaultContent":"<a class='btn-jh red ideditar'><i class='fa fa-check-square'></i> Poner Sin Dato</a>"}
          ]
          ,"bPaginate": false,
          "bLengthChange": false,
          "bFilter": false,
          "bInfo": false,
          "bAutoWidth": false
        });
        obtenerDatosProducto("#tablajson tbody",table);
      }
      function obtenerDatosProducto(tbody,table){
        $(tbody).on("click","a.ideditar",function(){
          var data=table.api().row( $(this).parents("tr") ).data();        
          
          console.log(data);
        });
      }
      $("#btnOrg").click(function(){
        window.open("../../../organizacion/administrar/organigrama/data.php?lblcode=<?php echo $lblcod ?>" , "ventana1" , "width=1000,height=400,scrollbars=NO"); 
      });
      $("#btnSave").click(function(){
        $('#btnSave').attr("disabled",true);
        swal({
          title: "CONFIRMACION",
          text: "Se guardara la observacion",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#2c2a6c",
          confirmButtonText: "OBSERVAR",
          closeOnConfirm: false
        }, function (){
          var str = $( "#idform" ).serialize();
          $.ajax({
            url: "observar.php",
            type: "POST",
            data: str+'&idcontrato=<?php echo $valor ?>',
            success: function(resp){
              console.log(resp);
              $("#idresultado").html(resp);
            }
          }); 
        });
      });
      $("#btnSave2").click(function(){
        $('#btnSave2').attr("disabled",true);
        swal({
          title: "CONFIRMACION",
          text: "Se aprobara por auditoria",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#008236",
          confirmButtonText: "APROBAR",
          closeOnConfirm: false
        }, function (){
          var str = $( "#idform2" ).serialize();
          $.ajax({
            url: "aprobar.php",
            type: "POST",
            data: str+'&idcontrato=<?php echo $valor ?>',
            success: function(resp){
              console.log(resp);
              $("#idresultado").html(resp);
            }
          }); 
        });
      });
    </script>
</body>
</html>