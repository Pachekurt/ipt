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
  include_once($ruta."class/personaplan.php");
  $personaplan=new personaplan;
  include_once($ruta."class/admplan.php");
  $admplan=new admplan;
   include_once($ruta."class/titular.php");
  $titular=new titular;
  include_once($ruta."class/vvinculado.php");
  $vvinculado=new vvinculado;
  include_once($ruta."class/domicilio.php");
  $domicilio=new domicilio;

  include_once($ruta."funciones/funciones.php");
  session_start();  
  extract($_GET);
  $valor=dcUrl($lblcode);
  //echo $valor;
  $_SESSION["codempresa"]=$valor;
  $idusuario=$_SESSION["codusuario"];
  $lblcontrato=$valor;
  $dcontrato=$admcontrato->muestra($valor);

  $consulta="SELECT max(cuenta)  as 'maximo' FROM admcontrato where idsede= ".$_SESSION['idsede'];
  $dcont=$admcontrato->sql($consulta);
  $dcont=array_shift($dcont);

  $dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
  $idpersona=$dtit['idpersona'];
  $dper=$persona->muestra($dtit['idpersona']);
  $dsede=$sede->muestra($dcontrato['idsede']);
  $destado=$dominio->muestra($dcontrato['estado']);
  $dejec=$vejecutivo->muestra($dcontrato['idadmejecutivo']);
  $ddom=$domicilio->mostrarUltimo("idpersona=".$idpersona."");
  $swDom=true;
  if (count($ddom)<=0) {
    $swDom=false;
    $dom=0;
  }
  else{
    $dom=$ddom['iddomicilio'];
  }
  //echo "DOMICILIO ".$dom;
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
  //ACA FALTA LA VALIDACION QUE SIEMPRE HAYA UN ORGANIGRAMA ACTIVO
  if ($dcontrato['estado']==65) {
    $newCod=$dcontrato['cuenta'];
  }
  else{
    $newCod=$dcont['maximo']+1;
  }
  $dordet=$personaplan->mostrarTodo("idpersona=".$dper['idpersona']." and idcontrato=$valor");
  $sww=false;
  if (count($dordet)<1) {
    $sww=true;
  }
  $fechahoy = date('Y-m-j');
  $nuevafecha = strtotime ('+1 month', strtotime($fechahoy)) ;
  $fechapago = date ( 'Y-m-d' , $nuevafecha );

  //Especial cuidado en las fechas 31 o 28
  $date = new DateTime('01-10-2017');
  if(in_array(strtolower($date->format('l')), array('sunday')))
  {
    //echo "Es domingo";
  } 

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Verificacion";
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_foto.php");
    include_once($ruta."includes/head_tabla.php");
  ?>
  <style type="text/css">
    #mapa{
      height: 300px;
    }
    .ideditar{
      cursor: hand;
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
          $idmenu=43;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--validacion que haya siempre un organigrama activo-->
          <?php
          if ($sww) {
          ?>
          <div class="orange" id="breadcrumbs-wrapper">
            <center style="color: white;" > El titular no cuenta con un plan asignado </center>
          </div>
          <?php
            }
          ?>
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
                        <th>Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?php echo $ejecutivo ?></td>
                        <td><?php echo $titulaper ?></td>
                        <td><?php echo $dcontrato['nrocontrato'] ?></td>
                        <td>
                          <?php echo $destado['nombre'] ?>
                        </td>
                        <td>
                          <a href="../../administrar/titular/editar/?lblcode=<?php echo $lblcode ?>" target="_blank" class="btn-jh waves-effect darken-4 green"><i class="fa fa-edit"></i> Editar Datos</a>
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
                <div class="col s12 m12 l6">
                    <div id="card-alert" class="card red lighten-5">
                      <div class="card-content red-text">
                        <div class="titulo">Observaciones a la Información</div>
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
                      <button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
                        <span style="font-size: 10px;" class="btn-jh red" aria-hidden="true"><i class="fa fa-times"></i> Visto</span>
                      </button>
                    </div>
                    <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <div class="formcontent">
                      <div class="row">
                        <div class="input-field col s12">
                          <label>Plan Asignado</label>
                          <select id="idpersonaplan" name="idpersonaplan">
                            <?php
                              $sw=true;
                              $idperplan=0;
                              $idplan=0;
                              foreach($dordet as $f)
                              {
                                if ($sw) {
                                  $idperplan=$f['idpersonaplan'];
                                  $idplan=$f['idadmplan'];
                                  $sw=false;
                                }
                                $dplan=$admplan->mostrar($f['idadmplan']);
                                $dplan=array_shift($dplan);
                                ?>
                                  <option value="<?php echo $f['idpersonaplan']; ?>"><?php echo "PLAN ".$dplan['nombre']." ".$dplan['personas']." Personas ".$dplan['cuotas']." Cuotas"; ?></option>
                                <?php
                              }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12">
                          
                          
                          <div id="card-alert" class="card light-blue lighten-5">
                            <div class="card-content light-blue-text">
                              
                              <?php
                              $cont=0;
                              foreach($vvinculado->mostrarTodo("idpersonaplan=".$idperplan) as $f){
                                ?>
                                  <p>Ben. <?php echo $f['nombre'].' '.$f['paterno'].' '.$f['materno']; ?></p>
                                <?php
                                $cont++;
                              }
                              if ($cont<=0) {
                                ?>
                                  <div class="card-content red light-blue-text">
                                    <span style="color:white" >No existen beneficiarios Agregados</span>
                                  </div>
                                <?php
                              }
                              $dplan=$admplan->muestra($idplan);
                              if ($cont<$dplan['personas']) {
                                ?>
                                  <a href="../../administrar/titular/plan/beneficiario/?lblcode=<?php echo $lblcode ?>&lblperplan=<?php echo $idperplan ?>" class="waves-effect" target="_blank"><i class="fa fa-plus"></i> Beneficiarios</a>
                                <?php
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                        <div class="input-field col m6 s12 l6">
                          <input id="idfechaInicio" name="idfechaInicio" type="date" value="<?php echo date('Y-m-d'); ?>" class="validate">
                          <label for="idfechaInicio">Fecha Inicio del Plan</label>
                        </div>
                        <div class="input-field col m6 s12 l6">
                          <input id="idfechaprimero" name="idfechaprimero" type="date" value="<?php echo $fechapago; ?>" class="validate">
                          <label for="idfechaprimero">Fecha Primer Pago</label>
                        </div>
                        <div class="input-field col m6 s12 l6">
                          <input id="idcuenta" name="idcuenta" value="<?php echo $newCod ?>"  type="number" class="validate">
                          <label for="idcuenta">Cuenta de asignacion.</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <textarea id="idobs" name="idobs" class="materialize-textarea"></textarea>
                          <label for="idobs">Observaciones</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <center>
                            <a href="../" class="btn darken-3 blue" style="width: 100%"><i class="fa fa-reply"></i> Volver</a>
                          </center>
                        </div> 
                        <div class="input-field col s12 m4 l4">
                          <center>
                            <button id="btnSave" class="btn darken-4 green" style="width: 100%"><i class="fa fa-check"></i> VERIFICAR</button>
                          </center>
                        </div>
                        <div class="input-field col s12 m4 l4">
                          <center>
                            <button id="btnRechazar" class="btn darken-2 red" style="width: 100%"><i class="fa fa-times"></i> RECHAZAR</button>
                          </center>
                        </div> 
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col s12 m12 l6">
                  <div class="row">
                    <div class="formcontent">
                      <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                          <li>
                            <div class="collapsible-header titulo"><i class="mdi-image-photo-camera"></i> TOMAR FOTOS</div>
                            <div class="collapsible-body" style="">
                              <div class="col-md-12">
                                <div class="editarfotoperfil">
                                    <div class="ibox">
                                        <div class="ibox-content">
                                            <div class="clients-list">
                                              <!-- The file upload form used as target for the file upload widget -->
                                              <form id="fileupload"  method="POST" enctype="multipart/form-data">
                                                  <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                                                  <div class="row fileupload-buttonbar">
                                                      <div class="col s12 m12 l12">
                                                        <span class="btn darken-4 green fileinput-button">
                                                          <i class="fa fa-folder-open-o"></i>
                                                          <span>Seleccionar Imagenes</span>
                                                          <input multiple="true" type="file" name="files[]" >
                                                        </span>
                                                        <button type="submit" class="btn orange darken-3 start">
                                                          <i class="fa fa-check"></i>
                                                          <span>Empezar</span>
                                                        </button>
                                                        <span class="fileupload-process"></span>
                                                      </div>
                                                  </div>
                                                  <!-- The table listing the files available for upload/download -->
                                                  <div id="scroll">
                                                    <div id="scrollin">
                                                        <table role="presentation" class="table table-striped table-hover">
                                                        <tbody class="files"></tbody>
                                                        </table>
                                                    </div>
                                                  </div>
                                              </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                              
                            </div>
                          </li>
                        </ul>
                    </div>
                  </div>
                  <div class="row">
                    <form id="idformMap" action="return false" onsubmit="return false" method="POST">
                      <div class="formcontent">
                        <h4 class="titulo"> <i class="mdi-maps-place"></i> Ubicación en Google Maps</h4>
                          <?php
                            if ($swDom) {
                              ?>
                                <div id="mapa"></div>
                                <input type="hidden" name="iddom" id="iddom" value="<?php echo $dom; ?>">
                                <div class="row">
                                  <div class="input-field col s12 m12 l4">
                                    <input id="geox" name="geox" readonly="" value="<?php echo $ddom['geox'] ?>" type="text" class="validate">
                                    <label for="geox">Coordenada X</label>
                                  </div>
                                  <div class="input-field col s12 m12 l4">
                                    <input id="geoy" name="geoy" readonly="" value="<?php echo $ddom['geoy'] ?>" type="text" class="validate">
                                    <label for="geoy">Coordenada Y</label>
                                  </div>
                                  <div class="input-field col s12 m12 l4">
                                    <button id="btnMap" style="width: 100%;" class="btn green"><i class="mdi-content-save"></i> Guardar</button>
                                  </div>
                                </div>
                              <?php
                            }
                            else{
                              ?>
                                <p>Debe definir una dirección de domicilio para tener acceso a hubicacion por Google Maps</p>
                                <a target="_blank" href="../../administrar/titular/domlab/?lblcode=<?php echo $lblcode ?>"><i class="mdi-maps-place"></i>Definir Direccion de Domicilio</a>
                              <?php
                            }
                          ?>
                      </div>
                    </form>
                  </div>
                </div>
              
            </div>
          </div>
          <?php
            include_once("../../../footer.php");
          ?>
        </section>
      </div>
    </div>
   <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
                    <strong class="error text-danger"></strong>
                    <input name="description[]" value="foto verificacion" style="visibility: hidden;">
                    <input name="url_proc[]" value="<?php echo $adress;?>" style="visibility: hidden;" >
                    <input name="id_usuario[]" value="<?php echo $idusuario;?>" style="visibility: hidden;" >
                    <input name="tipo_foto[]" value="verificacion" style="visibility: hidden;" >
                    <input name="tipo_usuario[]" value="1" style="visibility: hidden;" >
                    <input name="id_publicacion[]" value="<?php echo $valor;?>" style="visibility: hidden;">
                    <input name="principal[]" value="0" style="visibility: hidden;">
                <br>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn blue start" disabled>
                        <i class="fa fa-save"></i>
                        <span>Confirmar</span>
                    </button>
                {% } %}

                {% if (!i) { %}
                    <button class="btn red cancel">
                        <i class="fa fa-trash"></i>
                        <span>Descartar</span>
                    </button>
                {% } %}
            </td>

        </tr>
        {% } %}
    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade" >
                <td>
                    <p>
                    <span>
                        {% if (file.url) { %}
                            <a href="{%=file.url%}" target="_blank" title="{%=file.name%}" data-gallery>
                                <img class="col s12 m12 l5" src="{%=file.url%}">
                            </a>
                        {% } %}
                    </span>
                    </p>
                    {% if (file.error) { %}
                        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                    {% if (file.deleteUrl) { %}
                        <button class="btn red darken-4 delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                            <i class="fa fa-trash"></i>
                            <span>Eliminar</span>
                        </button>
                        <input type="checkbox" style="visibility: hidden;" name="delete" value="1" class="toggle">
                    {% } else { %}
                        <button class="btn btn-warning cancel">
                            <i class="fa fa-trash"></i>
                            <span>Cancelar</span>
                        </button>
                    {% } %}
                </td>
            </tr>
        {% } %}
    </script>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_foto.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDasVEB9cdyjgRJD9ax76BvSs-Z9w8SeU"></script>
    <script type="text/javascript">
      listarProductos();
      function listarProductos(){
        $("#tablajson").dataTable().fnDestroy();
        idcontrato="<?php echo $valor ?>";
        var table=$("#tablajson").dataTable({
          "ajax":{
              "method":"POST",
              "url":"../../auditoria/operaciones/muestraerroresInfoProd.php?idcontrato="+idcontrato
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
      $(document).ready(function() {
        var marcadores_nuevos = [];
      var marcadores_bd= [];
      //FUNCION PARA QUITAR MARCADORES DE MAPA
      function quitar_marcadores(lista)
      {
          for (i in lista){//RECORRER EL ARRAY DE MARCADORES
            lista[i].setMap(null);//QUITAR MARCADOR DEL MAPA
          }
      }
      var idlab="<?php echo $dom ?>";
      var image = 'icon.png';
       $.ajax({
              type:"POST",
              url:"listarPuntos.php?id="+idlab
            }).done(function(data){
            console.log(data);
            var datoPub = JSON.parse(data);
            for(var i in datoPub){
                var posi = new google.maps.LatLng(datoPub[i].coordX, datoPub[i].coordY);//bien
                //CARGAR LAS PROPIEDADES AL MARCADOR
                var marca = new google.maps.Marker({
                    idMarcador:datoPub[i].idmaps,
                    position:posi,
                    icon:image,
                    titulo:  "DOMICILIO DEL TITULAR",
                });
                //AGREGAR EVENTO CLICK AL MARCADOR
                /*
                google.maps.event.addListener(marca, "click", function(){
                   alert("Hiciste click en "+marca.idMarcador + " - " + marca.titulo) ;
                });
                */
                //AGREGAR EL MARCADOR A LA VARIABLE MARCADORES_BD
                marcadores_bd.push(marca);
                //UBICAR EL MARCADOR EN EL MAPA
                marca.setMap(mapa);
            }
          });
        
      //COORDENADAS INICIALES -13.163622,-72.545926
        //VARIABLE PARA PUNTO INICIAL
        var punto = new google.maps.LatLng(-16.4697103,-68.2344965);
        //VARIABLE PARA CONFIGURACION INICIAL
        var config = {
            zoom:11,
            center:punto,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
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
      });
      $("#btnOrg").click(function(){
        window.open("../../../../organizacion/administrar/organigrama/data.php?lblcode=<?php echo $lblcod ?>" , "ventana1" , "width=1000,height=400,scrollbars=NO"); 
      });
      $("#btnRechazar").click(function(){
        $('#btnRechazar').attr("disabled",true);
        swal({
          title: "RECHAZAR ?",
          text: "Estas Seguro de Rechazar el Contrato",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#2c2a6c",
          confirmButtonText: "Si. Estoy Seguro",
          closeOnConfirm: false
        }, function () {
          var str = $( "#idform" ).serialize();
          $.ajax({
            url: "rechazar.php",
            type: "POST",
            data: str+'&idcontrato=<?php echo $valor ?>',
            success: function(resp){
              console.log(resp);
               $("#idresultado").html(resp);
            }
          }); 
        });
      });
      $("#btnSave").click(function(){
        $('#btnSave').attr("disabled",true);
        swal({
          title: "VERIFICAR ?",
          text: "Marcaras el contrato como verificado",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#2c2a6c",
          confirmButtonText: "Si. Verificar",
          closeOnConfirm: false
        }, function () {
          var str = $( "#idform" ).serialize();
          $.ajax({
            url: "verificar.php",
            type: "POST",
            data: str+'&idcontrato=<?php echo $valor ?>',
            success: function(resp){
              console.log(resp);
               $("#idresultado").html(resp);
            }
          }); 
        });
      });
      $("#btnMap").click(function(){
        $('#btnMap').attr("disabled",true);
          var str = $( "#idformMap" ).serialize();
          $.ajax({
            url: "guardamap.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
               $("#idresultado").html(resp);
            }
          }); 
      });
    </script>
</body>

</html>