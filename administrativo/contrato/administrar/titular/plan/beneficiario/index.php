<?php
  $ruta="../../../../../../";
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
  include_once($ruta."class/admplan.php");
  $admplan=new admplan;
  include_once($ruta."class/personaplan.php");
  $personaplan=new personaplan;
  include_once($ruta."class/vvinculado.php");
  $vvinculado=new vvinculado;
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
 
  $dcontrato=$admcontrato->mostrar($valor);
  $dcontrato=array_shift($dcontrato);

  $dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
  $dper=$persona->mostrar($dtit['idpersona']);
  $dper=array_shift($dper);

  $dsede=$sede->mostrar($dcontrato['idsede']);
  $dsede=array_shift($dsede);

  $destado=$dominio->mostrar($dcontrato['estado']);
  $destado=array_shift($destado);


  $dejec=$vejecutivo->muestra($dcontrato['idadmejecutivo']);

  $titulaper= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
  $ejecutivo= $dejec['nombre']." ".$dejec['paterno']." ".$dejec['materno'];
  $idpersona=$dtit['idpersona'];
  //echo $valor;
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
  $perplan=$personaplan->mostrarUltimo("idpersonaplan=".$lblperplan);
  //verificamos si tiene cupo para el beneficiario
  $dplan=$admplan->mostrarTodo("idadmplan=".$perplan['idadmplan']);
  $dplan=array_shift($dplan);
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
    $hd_titulo="Registro de beneficiarios";
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
                <div class="col s5 m5 l5">
                  <h5 class="breadcrumbs-title">Registro de beneficiarios</h5>
                  <ol class="breadcrumbs">
                    <li><a href="../../editar/?lblcode=<?php echo $lblcode ?>"> Persona y Facturación </a></li>
                    <li><a href="../../domlab/?lblcode=<?php echo $lblcode ?>"> Domicilios y Trabajos</a></li>
                    <li class="activoTab"><a href="../../plan/?lblcode=<?php echo $lblcode ?>"> Plan </a></li>
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
                        <th>Acciones</th>
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
                        <td>
                          <a href="../../../record/?lblcode=<?php echo $lblcode ?>" style="color: green; font-weight: bold;" target="_blank" class="btn-jh waves-effect darken-1 yellow"><i class="fa fa-money"></i></a>
                          <a id="btnOrg" class="btn-jh waves-effect darken-4 purple"><i class="fa fa-sitemap"></i></a>
                          <a href="../../../acciones/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 red"><i class="fa fa-recycle"></i></a>
                          <a href="../../../imprimir/?lblcode=<?php echo $lblcode ?>" target="_blank" class="btn-jh waves-effect darken-4 indigo"><i class="fa fa-print"></i></a>
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
              <a href="nuevo/?lblcode=<?php echo $lblcode ?>&lblperplan=<?php echo $lblperplan ?>" class="btn blue"><i class="fa fa-plus"></i> NUEVO</a>
              <button id="btnSave" class="btn orange darken-2"><i class="fa fa-arrow-down"></i> AGREGAR TITULAR COMO BENEFICIARIO</button>
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Carnet</th>
                        <th>Nombre</th>
                        <th>Contrato</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Carnet</th>
                        <th>Nombre</th>
                        <th>Contrato</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    </tr>
                </tfoot>
                <tbody>
                  <?php
                  foreach($vvinculado->mostrarTodo("idpersonaplan=".$lblperplan) as $f)
                  {
                    $dcontratos=$admcontrato->mostrar($f['idcontrato']);
                    $dcontratos=array_shift($dcontratos);
                    ?>
                    <tr>
                      <td><?php echo $f['carnet']." ".$f['expedido'] ?></td>
                      <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td>
                      <td><?php echo $dcontratos['nrocontrato'] ?></td>
                      <td>
                        <?php 
                          if ($f['estado']>0) {
                             echo "ESTUDIANTE INSCRITO";
                           } 
                           else echo "AUN SIN INSCRIBIR";
                        ?>
                      </td>
                      <td>
                        <button onclick="eliminar('<?php echo $f['idvvinculado'] ?>');" class="btn-jh waves-effect darken-2 red"><i class="fa fa-trash"></i> Dar de Baja</button>
                      </td>
                    </tr>
                    <?php
                    }
                  ?>
                </tbody>
              </table>
              </div>
          </div>
          <?php
            include_once("../../../../../footer.php");
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
    <script type="text/javascript">  
    $("#btnOrg").click(function(){
        window.open("../../../../../organizacion/administrar/organigrama/data.php?lblcode=<?php echo $lblcod ?>" , "ventana1" , "width=1000,height=400,scrollbars=NO"); 
      });     
    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
      /**********************************************************************************/
      $("#btnSave").click(function(){
        $('#btnSave').attr("disabled",true);
          swal({
            title: "CONFIRMACION",
            text: "Agregarás al titular como beneficiario",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "GUARDAR",
            closeOnConfirm: false
          }, function () {
            //alert(str);
            $.ajax({
              url: "agregartitular.php",
              type: "POST",
              data: "lblcode=<?php echo $lblcode ?>"+"&lblperplan=<?php echo $lblperplan ?>&idpersona=<?php echo $idpersona ?>",
              success: function(resp){
                console.log(resp);
                 $("#idresultado").html(resp);
              }
            }); 
          }); 
      });

    }); 
    function eliminar(id)
    {
      swal({
            title: "CONFIRMACION",
            text: "Se dara de baja al beneficiario",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2c2a6c",
            confirmButtonText: "GUARDAR",
            closeOnConfirm: false
          }, function () {
            //alert(str);
            $.ajax({
              url: "eliminar.php",
              type: "POST",
              data: "id="+id,
              success: function(resp){ 
                console.log(resp);
                $("#idresultado").html(resp);
              }
            });  
          }); 
    }
    </script>
</body>

</html>