<?php
  $ruta="../../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/admsemana.php");
  $admsemana=new admsemana;
  include_once($ruta."funciones/funciones.php");
  session_start();
  $fechahoy=date("Y-m-d");
  //$fechahoy="2017-10-03";
  $dsemana=$admsemana->mostrarUltimo("estado=1");
  $fechaVig=$dsemana['fechafin'];
  //$fechaVig="2017-10-02";
  $diferencia=diferenciaDias($fechaVig, $fechahoy);

  $idsede=$_SESSION["idsede"];
  $dSelSede=$sede->muestra($idsede);
  $tituloSede="Contratos en Sede ".$dSelSede['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Administrar de Contratos";
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_tabla.php");
    include_once($ruta."includes/head_tablax.php");
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
          if ($diferencia>=0) {
          ?>
          <div class="orange" id="breadcrumbs-wrapper">
            <center style="color: white;" > Por favor tenga cuidado con la vigencia anterior y la vigencia actual. Ya que la diferencia de fechas podria ocasionar conflictos en la base de datos </center>
          </div>
          <?php
            }
          ?>
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $tituloSede; ?>  <a class="btn blue darken-2" href="../administrar/"><i class="fa fa-reply"></i> Atrás</a></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div id="table-datatables">
              <div class="row">
                <form id="idform" action="return false" onsubmit="return false" method="POST">
                  <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Contrato</th>
                        <th>Fecha Estado</th>
                        <th>Sede</th>
                        <th>Ejecutivo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Contrato</th>
                        <th>Fecha Habil</th>
                        <th>Sede</th>
                        <th>Ejecutivo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      foreach($admcontrato->mostrarTodo("estado=66 and idsede=$idsede") as $f)
                      {
                        $idcontrato=ecUrl($f['idadmcontrato']);
                        $idcont=$f['idadmcontrato'];
                        $idorganigrama=ecUrl($f['idorganigrama']);
                        $dsede=$sede->mostrar($f['idsede']);
                        $dsede=array_shift($dsede);

                        $destado=$dominio->mostrar($f['estado']);
                        $destado=array_shift($destado);
                        $sw=false;
                        if ($f['estado']==60) {
                          $sw=true;
                        }
                        $estilo="";
                        switch ($f['estado']) {
                          case '60'://sin asignar
                            $estilo="background-color: #5998ff;";
                          break;
                          case '61'://asignado
                            $estilo="background-color: #e2ca7f;";
                          break;
                          case '62'://abono
                            $estilo="background-color: #92f984;";
                          break;
                          case '63'://reportado
                            $estilo="background-color: #55c662;";
                          break;
                          case '64'://anulado
                            $estilo="background-color: #e2858d;";
                          break;
                          case '66'://anulado
                            $estilo="background-color: #e091d0;";
                          break;
                          case '68'://anulado
                            $estilo="background-color: #d6fcda;";
                          break;
                          case '69'://anulado
                            $estilo="background-color: #e091d0;";
                          break;
                        }
                      ?>
                      <tr style="<?php echo $estilo ?>">
                        <td><?php echo $f['nrocontrato'] ?></td>
                        <td><?php echo $f['fechaestado'] ?></td>
                        <td><?php echo $dsede['nombre'] ?></td>
                        <td><?php 
                         if ($f['idadmejecutivo']>0) {
                            $dejecutivo=$vejecutivo->mostrar($f['idadmejecutivo']);
                            $dejecutivo=array_shift($dejecutivo);
                            echo $dejecutivo['nombre']." ".$dejecutivo['paterno']." ".$dejecutivo['materno'];
                         }
                         else{
                            echo "Sin Asignar";
                         }
                          ?>
                        </td>
                        <td><?php echo $destado['nombre'] ?></td>
                        <td>
                          <?php
                            //para el ok de verificacion trabajar en una pestania nueva.
                            switch ($f['estado']) {
                              case '61'://asignado
                                ?>
                                  <a href="titular/nuevo/?lblcode=<?php echo $idcontrato ?>" class="btn-jh waves-effect darken-4 blue"><i class="fa fa-sign-in"></i> Registrar</a>
                                  <a href="acciones/?lblcode=<?php echo $idcontrato ?>" data-position="top" data-delay="50" data-tooltip="Devolver Contrato" class="btn-jh waves-effect darken-4 red tooltipped"><i class="fa fa-recycle"></i></a>
                                  <a href="traspaso/?lblcode=<?php echo $idcontrato ?>" data-position="top" data-delay="50" data-tooltip="Traspaso de contrato" class="btn-jh waves-effect darken-3 orange tooltipped"><i class="fa fa-retweet"></i></a>
                                <?php
                              break;
                              case '62'://Precontrato
                                ?>
                                 <a href="titular/editar/?lblcode=<?php echo $idcontrato ?>" data-position="top" data-delay="50" data-tooltip="Administrar Contrato" class="btn-jh waves-effect darken-4 green tooltipped"><i class="fa fa-eye"></i></a>
                                <a href="acciones/?lblcode=<?php echo $idcontrato ?>" data-position="top" data-delay="50" data-tooltip="Devolver Contrato" class="btn-jh waves-effect darken-4 red tooltipped"><i class="fa fa-recycle"></i></a>
                                <a href="cambio/?lblcode=<?php echo $idcontrato ?>" data-position="top" data-delay="50" data-tooltip="Cambio de  Contrato" class="btn-jh waves-effect indigo tooltipped"><i class="mdi-notification-sync-problem"></i></a>
                                
                                <button class="btn-jh waves-effect darken-4 purple tooltipped"  data-position="top" data-delay="50" data-tooltip="Ver Organigrama Vigente" onclick="verOrg('<?php echo $idorganigrama ?>')"><i class="fa fa-sitemap"></i></button>
                                <a href="traspaso/?lblcode=<?php echo $idcontrato ?>" data-position="top" data-delay="50" data-tooltip="Traspaso de contrato" class="btn-jh waves-effect darken-3 orange tooltipped"><i class="fa fa-retweet"></i></a>
                                <a href="imprimir/?lblcode=<?php echo $idcontrato ?>" class="btn-jh waves-effect darken-4 indigo"><i class="fa fa-print"></i></a>
                                <?php
                              break;
                              case '63'://Reportado
                                ?>
                                <a href="imprimir/?lblcode=<?php echo $idcontrato ?>" class="btn-jh waves-effect darken-4 indigo"><i class="fa fa-print"></i></a>
                                <a href="cambio/?lblcode=<?php echo $idcontrato ?>" data-position="top" data-delay="50" data-tooltip="Cambio de  Contrato" class="btn-jh waves-effect indigo tooltipped"><i class="mdi-notification-sync-problem"></i></a>
                                <button class="btn-jh waves-effect purple tooltipped"  data-position="top" data-delay="50" data-tooltip="Ver Organigrama Vigente" onclick="QuitarCotr('<?php echo $idcont ?>')">Quitar</button>
                                <?php
                              break;
                              case '68'://Precontrato
                                ?>
                                 <a href="titular/editar/?lblcode=<?php echo $idcontrato ?>" data-position="top" data-delay="50" data-tooltip="Administrar Contrato" class="btn-jh waves-effect darken-4 green tooltipped"><i class="fa fa-eye"></i></a>
                                <a href="acciones/?lblcode=<?php echo $idcontrato ?>" data-position="top" data-delay="50" data-tooltip="Devolver Contrato" class="btn-jh waves-effect darken-4 red tooltipped"><i class="fa fa-recycle"></i></a>
                                <a href="cambio/?lblcode=<?php echo $idcontrato ?>" data-position="top" data-delay="50" data-tooltip="Cambio de  Contrato" class="btn-jh waves-effect indigo tooltipped"><i class="mdi-notification-sync-problem"></i></a>
                                
                                <button class="btn-jh waves-effect darken-4 purple" data-position="top" data-delay="50" data-tooltip="Ver Organigrama Vigente" onclick="verOrg('<?php echo $idorganigrama ?>')"><i class="fa fa-sitemap"></i></button>
                                <a href="traspaso/?lblcode=<?php echo $idcontrato ?>" data-position="top" data-delay="50" data-tooltip="Traspaso de contrato" class="btn-jh waves-effect darken-3 orange tooltipped"><i class="fa fa-retweet"></i></a>
                                <a href="imprimir/?lblcode=<?php echo $idcontrato ?>" class="btn-jh waves-effect darken-4 indigo"><i class="fa fa-print"></i></a>
                                <?php
                              break;
                              case '64'://Anulado
                                ?>
                                  <button class="btn-jh waves-effect purple" onclick="QuitarCotr('<?php echo $idcont ?>')">Quitar</button>
                                <?php
                              break;
                              case '66'://Reportado
                                ?>
                                <a href="observado/?lblcode=<?php echo $idcontrato ?>" class="btn-jh waves-effect darken-4 blue"><i class="fa fa-eye"></i></a>
                                <a href="acciones/?lblcode=<?php echo $idcontrato ?>" data-position="top" data-delay="50" data-tooltip="Devolver Contrato" class="btn-jh waves-effect darken-4 red tooltipped"><i class="fa fa-recycle"></i></a>
                                <?php
                              break;
                            }
                          ?>
                        </td>
                      </tr>
                      <?php
                        }
                      ?>
                    </tbody>
                  </table>
                </form>
              </div>
            </div>    
            </div>
          </div>
          <?php
            include_once("../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#example').DataTable({
          "bFilter": true,
          "bInfo": false,
          "bAutoWidth": false,
          responsive: true,
          dom: 'Bfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ]
        });
      });
      function QuitarCotr(id){
        $.ajax({
          url: "quitar.php",
          type: "POST",
          data: "idcontrato="+id,
          success: function(resp){
            console.log(resp);
            $('#idresultado').html(resp);
          }
        });
      }
      function verOrg(id){
        window.open("../../organizacion/administrar/organigrama/data.php?lblcode="+id , "ventana1" , "width=1000,height=400,scrollbars=NO"); 
      }
      $("#btnOrg").click(function(){
      });
    </script>
</body>

</html>