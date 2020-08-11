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
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular;

  include_once($ruta."funciones/funciones.php");
  session_start();
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
          $idmenu=43;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $tituloSede; ?></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section">
              <div>
                <a href="material" class="btn purple darken-4">Entrega de Material</a>
                <br><br>
              </div>
              <div id="table-datatables">
              <div class="row">
                <form id="idform" action="return false" onsubmit="return false" method="POST">
                  <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Contrato</th>
                        <th>Titular</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Contrato</th>
                        <th>Titular</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      foreach($admcontrato->mostrarTodo(" estado>62 and estado<>69 and estado<>64 and estado<>65 and estado<>68 and estado<>67 and idsede=$idsede") as $f)
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
                        switch ($f['estado']) {
                          case '60'://sin asignar
                            $estilo="background-color: #5998ff;";
                          break;
                          case '61'://asignado
                            $estilo="background-color: #e2ca7f;";
                          break;
                          case '62'://reportado
                            $estilo="background-color: #5fd384;";
                          break;
                          case '63'://anulado
                            $estilo="background-color: #e2ca7f;";
                          break;
                          case '69'://anulado
                            $estilo="background-color: #e2858d;";
                          break;
                          case '65'://reportado
                            $estilo="background-color: #5fd384;";
                          break;
                        }
                      ?>
                      <tr style="<?php echo $estilo ?>">
                        <td><?php echo $f['nrocontrato'] ?></td>
                        <td><?php
                         if ($f['idadmejecutivo']>0) {
                            $dtitular=$vtitular->muestra($f['idtitular']);
                            echo $dtitular['nombre']." ".$dtitular['paterno']." ".$dtitular['materno'];
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
                              case '61'://sin asignar
                                ?>
                                  <a href="titular/nuevo/?lblcode=<?php echo $idcontrato ?>" class="btn-jh waves-effect darken-4 blue"><i class="fa fa-sign-in"></i> Registrar</a>
                                  <a href="acciones/?lblcode=<?php echo $idcontrato ?>" class="btn-jh waves-effect darken-4 red"><i class="fa fa-recycle"></i></a>
                                <?
                              break;
                              case '62'://Precontrato
                                ?>
                                 <a href="titular/editar/?lblcode=<?php echo $idcontrato ?>" class="btn-jh waves-effect darken-4 green"><i class="fa fa-eye"></i></a>
                                <a href="acciones/?lblcode=<?php echo $idcontrato ?>" class="btn-jh waves-effect darken-4 red"><i class="fa fa-recycle"></i></a>
                                <button class="btn-jh waves-effect darken-4 purple"  onclick="verOrg('<?php echo $idorganigrama ?>')"><i class="fa fa-sitemap"></i></button>
                                <a href="imprimir/?lblcode=<?php echo $idcontrato ?>" class="btn-jh waves-effect darken-4 indigo"><i class="fa fa-print"></i></a>
                                <?php
                              break;
                              case '63'://Reportado
                                ?>
                                <a href="verificar/?lblcode=<?php echo $idcontrato ?>" class="btn-jh waves-effect darken-4 purple"><i class="fa fa-check"></i></a>
                                <a href="../administrar/titular/editar/?lblcode=<?php echo $idcontrato ?>" target="_blank" class="btn-jh waves-effect darken-4 green"><i class="fa fa-eye"></i></a>
                                <?php
                              break;
                              case '65'://Anulado
                                ?>
                                  --
                                <?php
                              break;
                              case '69'://Anulado
                                ?>
                                  --
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