<?php
  $ruta="../../";
   include_once($ruta."class/vestudiante.php");
  $vestudiante=new vestudiante;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/estudiantereserva.php");
  $estudiantereserva=new estudiantereserva;
  include_once($ruta."class/examen.php");
  $examen=new examen;
  include_once($ruta."class/examenfinal.php");
  $examenfinal=new examenfinal;
  session_start(); 
   extract($_GET);

   $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede']; 
  //echo $idsede;

  $datosexamen=$examenfinal->mostrarTodo("idestudiantereserva=".$ides);
  $datosexamen=array_shift($datosexamen);
  $idexfinal=$datosexamen['idexamenfinal'];
  $notafinal=$datosexamen['promedio'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="DETALLE DEL EXAMEN FINAL DEL ESTUDIANTE";
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
          $idmenu=1015;
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
       
          <div class="container">
            <div class="section">
            <div class="row">
            <div class="col s12 m12 l2">&nbsp;</div>
            <div class="col s12 m12 l8">
              <div id="table-datatables">






             	<?php
            //$ides=$vestudiante->muestra($ides);   
            ?>  
            <h1><?php// echo "ESTUDIANTE: ".$ides['nombre']."  ".$ides['paterno'] ?></h1>
<div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">









              <a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>   

              <div class="row">
               <form id="idform" action="return false" onsubmit="return false" method="POST">
              
 
 <div class="col s12 m12 l12">
    <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i>NOTA OBTENIDA <?php echo $notafinal; ?></h5>
  </div>
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                       <th>PREGUNTA</th>
                       <th>OPCIÓN A</th>
                       <th>OPCIÓN B</th>
                       <th>OPCIÓN C</th>
                       <th>OPCIÓN D</th>
                       <th>RESPUESTA CORRECTA</th>
                       <th>RESPUESTA DEL ESTUDIANTE</th>
                      
                      

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                  <th>PREGUNTA</th>
                       <th>OPCIÓN A</th>
                       <th>OPCIÓN B</th>
                       <th>OPCIÓN C</th>
                       <th>OPCIÓN D</th>
                       <th>RESPUESTA CORRECTA</th>
                       <th>RESPUESTA DEL ESTUDIANTE</th>
                       
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      $v=0;
                      foreach($vestudiante->sql("call exfinal($idexfinal)") as $f)
                      {
                                             
                        ?>
                        <tr> 
                          <td><?php echo $f['detalle']  ?></td>
                          <td><?php echo $f['a']?> </td>
 							<td><?php echo $f['b']?> </td>
  								<td><?php echo $f['c']?> </td>
  									 <td><?php echo $f['d']?> </td>
 										   <td><?php echo $f['respuesta']?> </td>
  												   <td><?php echo $f['respuestaest']?> </td>
      










                          <td><?php// echo $idexfinal ?> </td>
                          <td>
                          
                              
                            
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
              <div class="col s12 m12 l2">&nbsp;</div>
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
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">       
  
    </script>
</body>

</html>