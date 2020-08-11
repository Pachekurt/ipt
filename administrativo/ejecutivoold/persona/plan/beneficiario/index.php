<?php
  $ruta="../../../../../../";
  include_once($ruta."class/vejecutivopersona.php");
  $vejecutivopersona=new vejecutivopersona;
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


  $dejecutivo=$vejecutivopersona->mostrar($dcontrato['idadmejecutivo']);
  $dejecutivo=array_shift($dejecutivo);

  $titulaper= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
  $ejecutivo= $dejecutivo['nombre']." ".$dejecutivo['paterno']." ".$dejecutivo['materno'];
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
                </div>
            </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <a href="nuevo/?lblcode=<?php echo $lblcode ?>&lblperplan=<?php echo $lblperplan ?>" class="btn blue"><i class="fa fa-plus"></i> NUEVO</a>
              <button id="btnSave" class="btn orange"><i class="fa fa-arrow-down"></i> AGREGAR TITULAR COMO BENEFICIARIO</button>
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
                    $dcontratos=$admcontrato->mostrar($f['idadmcontrato']);
                    $dcontratos=array_shift($dcontratos);
                    ?>
                    <tr>
                      <td><?php echo $f['carnet']." ".$f['expedido'] ?></td>
                      <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td>
                      <td><?php echo $f['nrocontrato'] ?></td>
                      <td>
                        <?php 
                          if ($f['estado']>0) {
                             echo "ESTUDIANTE INSCRITO";
                           } 
                           else echo "AUN SIN INSCRIBIR";
                        ?>
                      </td>
                      <td>
                        <a href="editar.php?lblcode=<?php echo $idrol ?>" class="btn-jh waves-effect waves-light blue"><i class="fa fa-edit"></i> Editar</a>
                        <button onclick="eliminar('<?php echo $f['idvvinculado'] ?>');" class="btn-jh waves-effect waves-light red"><i class="fa fa-edit"></i> Dar de Baja</button>
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