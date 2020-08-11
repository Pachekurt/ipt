<?php
  $ruta="../../../../../../";
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
  $dlab=$laboral->mostrar($lab);
  $dlab=array_shift($dlab);

  $dcontrato=$admcontrato->mostrar($valor);
  $dcontrato=array_shift($dcontrato);

  $dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
  $dtitular=$persona->mostrar($dtit['idpersona']);
  $dtitular=array_shift($dtitular);

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
                  <h5 class="breadcrumbs-title">Registrar Titular</h5>
                  <ol class="breadcrumbs">
                    <li><a href="../../editar/?lblcode=<?php echo $lblcode ?>"> Persona y Facturación </a></li>
                    <li class="activoTab"><a href="../../domlab/?lblcode=<?php echo $lblcode ?>"> Domicilios y Trabajos</a></li>
                    <li><a href="../../plan/?lblcode=<?php echo $lblcode ?>"> Plan </a></li>
                  </ol>
                </div>
                <div class="col s7 m7 l7">
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
            <div class="section">
             <div class="col s6 m6 l6">
              <h4 class="header"><a href="../?lblcode=<?php echo $lblcode ?>" class="btn waves-effect waves-light blue"><i class="fa fa-mail-reply"></i> Atras</a> Editar Direccion de domicilio</h4>
              <form class="col s6" id="idformdom" action="return false" onsubmit="return false" method="POST">
                <input id="idlab" name="idlab" value="<?php echo $lab ?>" type="hidden">
                <div class="formcontent">
                  <div class="row">
                    <div class="input-field col s6">
                      <input id="idzonal" name="idzonal" value="<?php echo $dlab['idbarrio'] ?>" type="text" class="validate">
                      <label for="idzonal">Zona</label>
                    </div>
                    <div class="input-field col s6">
                      <input id="iddireccionl" name="iddireccionl" value="<?php echo $dlab['nombre'] ?>" type="text" class="validate">
                      <label for="iddireccionl">Direccion</label>
                    </div>
                    <div class="input-field col s6">
                      <input id="idfonol" name="idfonol" type="text" value="<?php echo $dlab['telefono'] ?>" class="validate">
                      <label for="idfonol">Telefono</label>
                    </div>
                    <div class="input-field col s6">
                      <input id="iddescl" name="iddescl" type="text" value="<?php echo $dlab['descripcion'] ?>" class="validate">
                      <label for="iddescl">Dir. Descriptiva</label>
                    </div>
                    <div class="input-field col s6">
                      <input id="idempresa" name="idempresa" value="<?php echo $dlab['empresa'] ?>" type="text" class="validate">
                      <label for="idempresa">Empresa</label>
                    </div>
                    <div class="input-field col s6">
                      <input id="idcargo" name="idcargo" type="text" value="<?php echo $dlab['cargo'] ?>" class="validate">
                      <label for="idcargo">Cargo</label>
                    </div>
                    <div class="input-field col s6">
                      <input id="idantiguedad" name="idantiguedad" type="text" value="<?php echo $dlab['antiguedad'] ?>" class="validate">
                      <label for="idantiguedad">Antiguedad en Años</label>
                    </div>
                    <div class="input-field col s6">
                      <input id="idmensual" name="idmensual" type="text" value="<?php echo $dlab['ingresos'] ?>" class="validate">
                      <label for="idmensual">Ingreso Mensual en Bolivianos</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <a id="btnSave" class="btn waves-effect waves-light green"><i class="fa fa-save"></i> Actualizar Datos</a>
                    </div>
                  </div>
                </div>
              </form>    
              </div> 
            </div>
          </div>
          <?php
            include_once("../../../../../footer.php");
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
        window.open("../../../../../organizacion/administrar/organigrama/data.php?lblcode=<?php echo $lblcod ?>" , "ventana1" , "width=1000,height=400,scrollbars=NO"); 
      });
    $(document).ready(function() {
      /**********************************************************************************/
      $("#btnSave").click(function(){
        var strDom = $("#idformdom").serialize();
        swal({
            title: "Modificar ?",
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
              data: strDom,
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