<?php
  $ruta="../../../../../";
  include_once($ruta."class/domicilio.php");
  $domicilio=new domicilio;
  include_once($ruta."class/laboral.php");
  $laboral=new laboral;
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
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/admorgani.php");
  $admorgani=new admorgani;
   include_once($ruta."class/admorganidet.php");
  $admorganidet=new admorganidet;
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $valor=dcUrl($lblcode);
  $lblcontrato=$valor;
  if (!ctype_digit(strval($valor))) {
    if (!isset($_SESSION["faltaSistema"]))
    {  $_SESSION['faltaSistema']="0"; }
    $_SESSION['faltaSistema']=$_SESSION['faltaSistema']+1;
    ?>
      <script type="text/javascript">
        ruta="<?php echo $ruta ?>login/salir.php";
        window.location=ruta;
      </script>
    <?php

  }
    $dcontrato=$admcontrato->mostrar($valor);
    $dcontrato=array_shift($dcontrato);

    $dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
    $dtitular=$persona->mostrar($dtit['idpersona']);
    $dtitular=array_shift($dtitular);
    $idpersona=$dtit['idpersona'];

    $dsede=$sede->mostrar($dcontrato['idsede']);
    $dsede=array_shift($dsede);

    $destado=$dominio->mostrar($dcontrato['estado']);
    $destado=array_shift($destado);


    $dejec=$vejecutivo->muestra($dcontrato['idadmejecutivo']);

    $titulaper= $dtitular['nombre']." ".$dtitular['paterno']." ".$dtitular['materno'];
    $ejecutivo= $dejec['nombre']." ".$dejec['paterno']." ".$dejec['materno'];
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
      $hd_titulo="Domicilios y Trabajos";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
  <style type="text/css">
    #mapa{
      height: 300px;
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
          $idmenu=26;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
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
                    <li><a href="../editar/?lblcode=<?php echo $lblcode ?>"> Persona y Facturación </a></li>
                    <li class="activoTab"><a href="../domlab/?lblcode=<?php echo $lblcode ?>"> Domicilios y Trabajos</a></li>
                    <li><a href="../plan/?lblcode=<?php echo $lblcode ?>"> Plan </a></li>
                  </ol>
                </div>
                <div class="col s12 m12 l7">
                  <table class="csscontrato">
                    <thead>
                      <tr>
                        <th>Ejecutivo</th>
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
                        <td><?php echo $titulaper ?></td>
                        <td><?php echo $dcontrato['nrocontrato'] ?></td>
                        <td><?php echo $dsede['nombre'] ?></td>
                        <td><?php echo $destado['nombre'] ?></td>
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
            <div class="section">
              <div id="table-datatables">
              <a href="#modal1" class="btn waves-effect waves-light indigo modal-trigger"><i class="fa fa-plus-square"></i> Nuevo Domicilio y/o Trabajo</a>
                <div id="modal1" class="modal col s12 m12 modal-fixed-footer" style="width: 98%">
                  <div class="modal-content">
                    <h3><input name="iddomicilio" type="checkbox" id="iddomicilio" /><label for="iddomicilio">Datos de Domicilio</label></h3>
                    <form id="idformdom" action="return false" onsubmit="return false" method="POST">
                      <div class="row">
                        <div class="col s6 m6 l6">
                          <div class="input-field col s12">
                            <input id="idzona" name="idzona"  type="text" class="validate">
                            <label for="idzona">Zona</label>
                          </div>
                          <div class="input-field col s12">
                            <input id="iddireccion" name="iddireccion" type="text" class="validate">
                            <label for="iddireccion">Direccion</label>
                          </div>
                          <div class="input-field col s12">
                            <input id="idfono" name="idfono" type="text" class="validate">
                            <label for="idfono">telefono</label>
                          </div>
                          <div class="input-field col s12">
                            <input id="iddesc" name="iddesc" type="text" class="validate">
                            <label for="iddesc">Dir. Descriptiva</label>
                          </div>
                          <div class="input-field col s12">
                            <input id="geox" name="geox" value="0" readonly="" type="text" class="validate">
                            <label for="geox">Coordenada X</label>
                          </div>
                          <div class="input-field col s12">
                            <input id="geoy" name="geoy" value="0" readonly="" type="text" class="validate">
                            <label for="geoy">Coordenada Y</label>
                          </div>
                        </div>
                        <div class="col s6 m6 l6">
                          <div id="mapa"></div>
                        </div>
                      </div>
                    </form>
                    <h3><input name="idtrabajo" type="checkbox" id="idtrabajo" /><label for="idtrabajo">Datos de Trabajo</label></h3>
                    <form class="col s12" id="idformlab" action="return false" onsubmit="return false" method="POST">
                      <div class="row">
                        <div class="input-field col s6">
                          <input id="idzonal" name="idzonal"  type="text" class="validate">
                          <label for="idzonal">Zona</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="iddireccionl" name="iddireccionl" type="text" class="validate">
                          <label for="iddireccionl">Direccion</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idfonol" name="idfonol" type="text" class="validate">
                          <label for="idfonol">telefono</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="iddescl" name="iddescl" type="text" class="validate">
                          <label for="iddescl">Dir. Descriptiva</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idempresa" name="idempresa"  type="text" class="validate">
                          <label for="idempresa">Empresa</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idcargo" name="idcargo" type="text" class="validate">
                          <label for="idcargo">Cargo</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idantiguedad" name="idantiguedad" type="text" class="validate">
                          <label for="idantiguedad">Antiguedad</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="idmensual" name="idmensual" type="text" class="validate">
                          <label for="idmensual">Ing. Mensual</label>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <a href="#" class="btn waves-effect waves-light light-orange darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</a>
                    <button id="btnSave" href="#" class="btn waves-effect waves-light green"><i class="fa fa-save"></i> GUARDAR DATOS</button>
                  </div>
                </div>
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>DATOS</th>
                        <th>Zona</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>DATOS</th>
                        <th>Zona</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                  <?php
                  foreach($domicilio->mostrarTodo("idpersona=".$dtitular['idpersona']) as $f)
                  {
                  ?>
                  <tr>
                    <td>DOMICILIO</td>
                    <td><?php echo $f['idbarrio'] ?></td>
                    <td><?php echo $f['nombre'] ?></td>
                    <td><?php echo $f['telefono'] ?></td>
                    <td><?php echo $f['tipoDomicilio'] ?></td>
                    <td>
                      <a href="domicilio/?lblcode=<?php echo $lblcode ?>&dom=<?php echo $f['iddomicilio'] ?>" class="btn-jh waves-effect waves-light blue"><i class="fa fa-edit"></i> Editar</a>  
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                  <?php
                  foreach($laboral->mostrarTodo("idpersona=".$dtitular['idpersona']) as $f)
                  {
                  ?>
                  <tr>
                    <td>TRABAJO</td>
                    <td><?php echo $f['idbarrio'] ?></td>
                    <td><?php echo $f['nombre'] ?></td>
                    <td><?php echo $f['telefono'] ?></td>
                    <td><?php echo $f['tipolaboral'] ?></td>
                    <td>
                      <a href="laboral/?lblcode=<?php echo $lblcode ?>&lab=<?php echo $f['idlaboral'] ?>" class="btn-jh waves-effect waves-light blue"><i class="fa fa-edit"></i> Editar</a>  
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
              </table>
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
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDasVEB9cdyjgRJD9ax76BvSs-Z9w8SeU"></script>
    <script type="text/javascript">
      $("#btnOrg").click(function(){
        window.open("../../../../organizacion/administrar/organigrama/data.php?lblcode=<?php echo $lblcod ?>" , "ventana1" , "width=1000,height=400,scrollbars=NO"); 
      });
    $(document).ready(function() {
      /**************************** CARGA MAPA  *********************************************/
      var marcadores_nuevos = [];
      //FUNCION PARA QUITAR MARCADORES DE MAPA
      function quitar_marcadores(lista)
      {
          for (i in lista){//RECORRER EL ARRAY DE MARCADORES
            lista[i].setMap(null);//QUITAR MARCADOR DEL MAPA
          }
      }
      //COORDENADAS INICIALES -13.163622,-72.545926
        //VARIABLE PARA PUNTO INICIAL
        var punto = new google.maps.LatLng(-16.4697103,-68.2344965);
        //VARIABLE PARA CONFIGURACION INICIAL
        var config = {
            zoom:13,
            center:punto,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        //VARIABLE MAPA
        var mapa = new google.maps.Map( $("#mapa")[0], config );

        google.maps.event.addListener(mapa, "click", function(event){
           //MOSTRAR UNA ALERTA AL HACER CLICK AL MAPA
           //EL EVENTO CLICK EN EL MAPA OFRECE UN PARAMETRO EVENT
           //EL CUAL DEVUELVE LAS COORDENADAS DE DONDE SE HIZO CLICK! 
           //alert(event.latLng);
           var coordenadas = event.latLng.toString();           
           //remover los parentesis
           coordenadas = coordenadas.replace("(", "");
           coordenadas = coordenadas.replace(")", "");           
           //coordenadas por separado
           var lista = coordenadas.split(",");           
           coordX=lista[0];
           coordY=lista[1];
           $("#geox").val(coordX);
           $("#geoy").val(coordY);
           //variable para dirección, punto o coordenada
           var direccion = new google.maps.LatLng(coordX, coordY);           
           //variable para marcador
           var image = 'icon.png';
           var marcador = new google.maps.Marker({
               position:direccion,//la posición del nuevo marcador
               map: mapa, //en que mapa se ubicará el marcador
               icon:image,
               animation:google.maps.Animation.DROP,//como aparecerá el marcador
               draggable:false//no permitir el arrastre del marcador
           });
           marcadores_nuevos.push(marcador);
           //ubicar el marcador en el mapa
           quitar_marcadores(marcadores_nuevos);
           marcador.setMap(mapa);
        });   




      /**************************************************************************************/
      $('#idformdom').find('input, textarea, button, select').attr('disabled',true);
      $('#idformlab').find('input, textarea, button, select').attr('disabled',true);
      $('#example').DataTable({
        responsive: true
      });
      //habilita y deshabilita los campos de domicilio y laboral
      $('#iddomicilio').click(function() {
        if (!$(this).is(':checked')) {
          $('#idformdom').find('input, textarea, button, select').attr('disabled',true);
        }
        else{
          $('#idformdom').find('input, textarea, button, select').attr('disabled',false);
        }
      });
      $('#idtrabajo').click(function() {
        if (!$(this).is(':checked')) {
          $('#idformlab').find('input, textarea, button, select').attr('disabled',true);
        }
        else{
          $('#idformlab').find('input, textarea, button, select').attr('disabled',false);
        }
      });
      /**********************************************************************************/
      $("#btnSave").click(function(){
        var strDom = $( "#idformdom" ).serialize();
            var strTrab = $( "#idformlab" ).serialize();
            var str=strDom+"&"+strTrab
            var chkDom=0;
            var chkLab=0;
            if ($('#iddomicilio').is(':checked'))chkDom=1;
            if ($('#idtrabajo').is(':checked'))chkLab=1;
            var str=str+"&dom="+chkDom+"&lab="+chkLab+"&idpersona="+"<?php echo $idpersona ?>";
            //alert(str);
            swal({
                title: "CONFIRMACION",
                text: "Se guardara los datos ingresados", 
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#2c2a6c",
                confirmButtonText: "GUARDAR",
                closeOnConfirm: false
              }, function () {
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
      });

    }); 
    </script>
</body>

</html>