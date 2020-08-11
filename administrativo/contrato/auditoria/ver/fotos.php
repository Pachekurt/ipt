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
   include_once($ruta."class/files.php");
  $files=new files;

  include_once($ruta."funciones/funciones.php");
  session_start();  
  extract($_GET);
  $valor=dcUrl($lblcode);
  $lblcontrato=$valor;
  $dcontrato=$admcontrato->muestra($valor);

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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Registrar Titular";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_galeria.php");
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
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l5">
                  <h5 class="breadcrumbs-title"><a href="../ver/?lblcode=<?php echo $lblcode ?>" class="btn blue"><i class="fa fa-reply"></i> VOLVER</a> DATOS DEL CONTRATO</h5>
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
              <div class="col s12 m6 l6">
                <div class="formcontent">
                  <div class="masonry-gallery-wrapper">                
                    <div class="popup-gallery">
                      <div class="gallary-sizer"></div>
                      <?php
                        foreach ($files->mostrarTodo("id_publicacion=".$valor." and tipo_foto='verificacion'") as $f) {
                          ?>
                            <div class="gallary-item"><a href="../../verificacion/verificar/server/php/<?php echo $valor ?>/<?php echo $f['name'] ?>" title="The Cleaner"><img src="../../verificacion/verificar/server/php/<?php echo $valor ?>/thumbnail/<?php echo $f['name'] ?>"></a></div>
                          <?php
                        }
                      ?>
                    </div>
                  </div>
                  <div class="fixed-action-btn" style="bottom: 50px; right: 19px;">
                      <a class="btn-floating btn-large">
                        <i class="mdi-action-stars"></i>
                      </a>
                      <ul>
                        <li><a href="css-helpers.html" class="btn-floating red"><i class="large mdi-communication-live-help"></i></a></li>
                        <li><a href="app-widget.html" class="btn-floating yellow darken-1"><i class="large mdi-device-now-widgets"></i></a></li>
                        <li><a href="app-calendar.html" class="btn-floating green"><i class="large mdi-editor-insert-invitation"></i></a></li>
                        <li><a href="app-email.html" class="btn-floating blue"><i class="large mdi-communication-email"></i></a></li>
                      </ul>
                  </div>
                </div>
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
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_galeria.php");
    ?>
    <script type="text/javascript">
      /*
       * Masonry container for Gallery page
       */
      var $containerGallery = $(".masonry-gallery-wrapper");
      $containerGallery.imagesLoaded(function() {
        $containerGallery.masonry({
            itemSelector: '.gallary-item img',
           columnWidth: '.gallary-sizer',
           isFitWidth: true
        });
      });

      //popup-gallery
      $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        closeOnContentClick: true,    
        fixedContentPos: true,
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile mfp-no-margins mfp-with-zoom',
        gallery: {
          enabled: true,
          navigateByImgClick: true,
          preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
          verticalFit: true,
          tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
          titleSrc: function(item) {
            return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
          },
        zoom: {
          enabled: true,
          duration: 300 // don't foget to change the duration also in CSS
        }
        }
      });
    </script>
</body>
</html>