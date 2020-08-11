<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vadmusuario.php");
  $vadmusuario=new vadmusuario; 
  include_once($ruta."class/rol.php");
  $rol=new rol;
  include_once($ruta."funciones/funciones.php");
 
  session_start();  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="PERSONAL";
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
          $idmenu=3;
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
          <li class="tab col s3"><a class="white-text waves-effect waves-light " href="#activeone">ADMINISTRACION</a>
          </li>
        </ul>
      </div>
      <div class="col s12">
        <div id="activeone" class="col s12  ">
         <div class="container">
            <div class="section">
              <div class="col s12 m12 l12">
                <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr> 
                      <th>N</th>
                      <th>Cargo</th>  
                      <th>Nombre</th>    
                      <th>Ingreso</th> 
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr> 

                      <th>N</th>
                      <th>Usuario</th>  
                      <th>Nombre</th> 
                      <th>Cargo</th>    
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $x =1;
                    foreach($vadmusuario->mostrarTodo("idarea in (120,122)") as $f)

                    
                    {
                      $lblcode=ecUrl($f['idusuario']); 
                    
                      switch ($f['estadousuario']) {
                        case '0':
                          $estilo="background-color: #18CDCA;";
                        break;
                        case '1':
                          $estilo="background-color: #6cd17f;";
                        break;
                      }
                    ?>
                    <tr style="<?php echo $estilo ?>">

                      <td><?php echo $x ?></td>
                      <td><?php echo $f['nick'] ?></td>

                      <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td>
                       
                      
                      <td><?php echo $f['norganizacion'] ?></td>
                     
                      <td>
                        <?php 
                          if ($f['estadousuario']==0) echo "INACTIVO";else echo "ACTIVO";
                        ?>
                      </td>
                      <td>


                        <a href="pass/?lblcode=<?php echo $lblcode ?>" class="btn-jh waves-effect darken-4 red"><i class="fa fa-lock"></i>  </a>


                          <?php 
                          if ($f['estadousuario']==0) {
                                if($f['nick']=='SIN USUARIO'){

                                }
                                else
                                {
                                    ?>
                                        <button onclick="cambiaestado('<?php echo $f['idusuario'] ?>','1');" class="btn-jh darken-4 green tooltipped" data-position="top" data-delay="50" data-tooltip="Habilitar" ><i class="mdi-action-thumb-up"></i>HABILITAR</button>
                                      <?php
                                }
                            
                          }else {
                            ?>
                              <a onclick="cambiaestado('<?php echo $f['idusuario']   ?>','0');" class="btn-jh waves-effect darken-4 red tooltipped" data-position="top" data-delay="50" data-tooltip="Dar de Baja"><i class="mdi-action-thumb-down"></i>DESHABILITAR</a>
                            <?php
                          }
                        ?>
                      </td>
                    </tr>
                    <?php
                      $x=$x+1;
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
    $('#example').DataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": false,
        responsive: true,
        "bAutoWidth": true,
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
          url: "cambiarestado.php",
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