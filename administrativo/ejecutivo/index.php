<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admejecutivo.php");
  $admejecutivo=new admejecutivo;
  include_once($ruta."class/rol.php");
  $rol=new rol;
  include_once($ruta."funciones/funciones.php");
  session_start();  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Ejecutivos";
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
          $idmenu=12;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
              </div>
            </div>
          </div>


 <div class="row">
      <div class="col s12">
        <ul class="tabs tab-demo-active z-depth-1 cyan">
          <li class="tab col s3"><a class="white-text waves-effect waves-light" active href="#sapien">PRODUCCION</a>
          </li>
          <li class="tab col s3"><a class="white-text waves-effect waves-light " href="#activeone">ADMINISTRACION</a>
          </li>
          <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#vestibulum">ACADEMICO</a>
          </li>
        </ul>
      </div>
      <div class="col s12">
        <div id="sapien" class="col s12   ">
            <div class="container">
            <div class="section">
              <div class="col s12 m12 l12">
                <table id="example1" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>CI</th>
                      <th>Nombre</th> 
                      <th>Cargo</th>
                      <th>Fecha Ingreso</th>
                      <th>Sede</th>
                      <th>Organizacion</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>CI</th>
                      <th>Nombre</th> 
                      <th>Cargo</th>
                      <th>Fecha Ingreso</th>
                      <th>Sede</th>
                      <th>Organizacion</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    foreach($vejecutivo->mostrarTodo("idarea=121") as $f)
                    {
                      $lblcode=ecUrl($f['idvejecutivo']);
                      $lblcodep=ecUrl($f['idpersona']);
                      $deje=$admejecutivo->muestra($f['idvejecutivo']);
                      switch ($deje['estado']) {
                        case '0':
                          $estilo="background-color: #f4a742;";
                        break;
                        case '1':
                          $estilo="background-color: #6cd17f;";
                        break;
                      }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['carnet']." ".$f['expedido']?></td>
                      <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td>
                       
                      <td><?php echo $f['njerarquia'] ?></td>
                      <td><?php echo $f['fechaingreso'] ?></td>
                      <td><?php echo $f['nsede'] ?></td>
                      <td><?php echo $f['norganizacion'] ?></td>
                      <td>
                        <?php 
                          if ($deje['estado']==0) echo "INACTIVO";else echo "ACTIVO";
                        ?>
                      </td>
                      <td>
                        <?php 
                          if ($deje['estado']==0) {
                            ?>
                              <button onclick="cambiaestado('<?php echo $lblcode ?>','1');" class="btn-jh darken-4 green tooltipped" data-position="top" data-delay="50" data-tooltip="Habilitar" ><i class="mdi-action-thumb-up"></i></button>
                            <?php
                          }else {
                            ?>
                              <a onclick="cambiaestado('<?php echo $lblcode ?>','0');" class="btn-jh waves-effect darken-4 red tooltipped" data-position="top" data-delay="50" data-tooltip="Dar de Baja"><i class="mdi-action-thumb-down"></i></a>
                            <?php
                          }
                        ?>
                        <a href="editar/ver.php?lblcode=<?php echo $lblcodep ?>" class="btn-jh waves-effect darken-4 blue tooltipped" data-tooltip="Ver"  ><i class="fa fa-eye" ></i> </a>

                        <a href="impresion/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 orange tooltipped" target="_blank"  data-position="top" data-delay="50" data-tooltip="Imprimir"><i class="fa fa-print"   ></i></a>

                        <!-- <a href="editar/cambia.php?lblcode=<?php echo $lblcodep ?>" class="btn-jh waves-effect darken-4 yellow tooltipped"  data-position="top" data-delay="50" data-tooltip="Cambiar de Organizacion" target="_blank"><i class="mdi-action-swap-horiz"   ></i> </a>-->
                        
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
        <div id="activeone" class="col s12  ">
         <div class="container">
            <div class="section">
              <div class="col s12 m12 l12">
                <table id="example1" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>CI</th>
                      <th>Nombre</th> 
                      <th>Cargo</th>
                      <th>Fecha Ingreso</th>
                      <th>Sede</th>
                      <th>Organizacion</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>CI</th>
                      <th>Nombre</th> 
                      <th>Cargo</th>
                      <th>Fecha Ingreso</th>
                      <th>Sede</th>
                      <th>Organizacion</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    foreach($vejecutivo->mostrarTodo("idarea =120") as $f)
                    {
                      $lblcode=ecUrl($f['idvejecutivo']);
                      $lblcodep=ecUrl($f['idpersona']);
                      $deje=$admejecutivo->muestra($f['idvejecutivo']);
                      switch ($deje['estado']) {
                        case '0':
                          $estilo="background-color: #f4a742;";
                        break;
                        case '1':
                          $estilo="background-color: #6cd17f;";
                        break;
                      }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['carnet']." ".$f['expedido']?></td>
                      <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td>
                      
                      <td><?php echo $f['njerarquia'] ?></td>
                      <td><?php echo $f['fechaingreso'] ?></td>
                      <td><?php echo $f['nsede'] ?></td>
                      <td><?php echo $f['norganizacion'] ?></td>
                      <td>
                        <?php 
                          if ($deje['estado']==0) echo "INACTIVO";else echo "ACTIVO";
                        ?>
                      </td>
                      <td>
                        <?php 
                          if ($deje['estado']==0) {
                            ?>
                              <button onclick="cambiaestado('<?php echo $lblcode ?>','1');" class="btn-jh darken-4 green">HABILITAR</button>
                            <?php
                          }else {
                            ?>
                              <button onclick="cambiaestado('<?php echo $lblcode ?>','0');" class="btn-jh red">DESHABILITAR</button>
                            <?php
                          }
                        ?>
                        <a href="editar/ver.php?lblcode=<?php echo $lblcodep ?>" class="btn-jh waves-effect darken-4 blue"><i class="fa fa-eye"></i>  </a>
                        <a href="impresion/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 orange" target="_blank"><i class="fa fa-print"></i></a>
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
        <div id="vestibulum" class="col s12  ">
          <div class="container">
            <div class="section">
              <div class="col s12 m12 l12">
                <table id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>CI</th>
                      <th>Nombre</th> 
                      <th>Cargo</th>
                      <th>Fecha Ingreso</th>
                      <th>Sede</th>
                      <th>Organizacion</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>CI</th>
                      <th>Nombre</th> 
                      <th>Cargo</th>
                      <th>Fecha Ingreso</th>
                      <th>Sede</th>
                      <th>Organizacion</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    foreach($vejecutivo->mostrarTodo("idarea=122") as $f)
                    {
                      $lblcode=ecUrl($f['idvejecutivo']);
                      $lblcodep=ecUrl($f['idpersona']);
                      $deje=$admejecutivo->muestra($f['idvejecutivo']);
                      switch ($deje['estado']) {
                        case '0':
                          $estilo="background-color: #f4a742;";
                        break;
                        case '1':
                          $estilo="background-color: #6cd17f;";
                        break;
                      }
                    ?>
                    <tr style="<?php echo $estilo ?>">
                      <td><?php echo $f['carnet']." ".$f['expedido']?></td>
                      <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td>
                      
                      <td><?php echo $f['njerarquia'] ?></td>
                      <td><?php echo $f['fechaingreso'] ?></td>
                      <td><?php echo $f['nsede'] ?></td>
                      <td><?php echo $f['norganizacion'] ?></td>
                      <td>
                        <?php 
                          if ($deje['estado']==0) echo "INACTIVO";else echo "ACTIVO";
                        ?>
                      </td>
                      <td>
                        <?php 
                          if ($deje['estado']==0) {
                            ?>
                              <button onclick="cambiaestado('<?php echo $lblcode ?>','1');" class="btn-jh darken-4 green">HABILITAR</button>
                            <?php
                          }else {
                            ?>
                              <button onclick="cambiaestado('<?php echo $lblcode ?>','0');" class="btn-jh red">DESHABILITAR</button>
                            <?php
                          }
                        ?>
                        <a href="editar/ver.php?lblcode=<?php echo $lblcodep ?>" class="btn-jh waves-effect darken-4 blue"><i class="fa fa-eye"></i>  </a>
                        <a href="impresion/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 orange" target="_blank"><i class="fa fa-print"></i></a>
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
      </div>
    </div>
          </div>
          <?php
            include_once("../footer.php");
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
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
        $('#example1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
          $('#example2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });
    function cambiaestado(id,estado){
      swal({
        title: "Estas Seguro?",
        text: "Cambiaras el estado al ejecutivo",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "Estoy Seguro",
        closeOnConfirm: false
      }, function () {      
        $.ajax({
          url: "cambiaestado.php",
          type: "POST",
          data: "id="+id+"&estado="+estado,
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