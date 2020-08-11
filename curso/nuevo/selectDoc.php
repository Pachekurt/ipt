<?php
  $ruta="../../";
  include_once($ruta."class/curso.php");
  $curso=new curso;
   include_once($ruta."class/estudiante.php");
  $estudiante=new estudiante;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/modulo.php");
  $modulo=new modulo;
  include_once($ruta."class/estudiantecurso.php");
  $estudiantecurso=new estudiantecurso;
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  session_start(); 
  extract($_GET);
  //$idestudiante=dcUrl($idestudiante);
  //$idcurso=dcUrl($idcurso); 
  //echo $idestudiante;
  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="ASIGNAR";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
</head>
<body>
   
    <div id="main">
      <div class="wrapper">
       
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12" align="right">
                <!--  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php //echo $hd_titulo; ?></h5> -->
                   <button id="btncerrar" onclick="cerrar();" class="btn waves-light red darken-4"><i class="mdi-content-clear"></i>Cerrar</button>
                </div>
              </div>
            </div>
          </div>

          <div class="container">
            <div class="section"> 
              <div id="table-datatables">
             <!-- <a href="../inicio" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> -->
             
              
               
              <div class="row">
              <div class="col s12 m12 l12" align="center">
                  <label class="light center-align blue-text" style="font-size:20px;"><i class="fa fa-tag"></i><strong>Docentes disponibles para el horario</strong></label>
                </div>
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                       <th>Carnet</th>
                       <th>Docente</th>
                       <th>Opciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                         <th>Carnet</th>
                        <th>Docente</th>
                        <th>Opciones</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                        //  $consulta="SELECT * FROM vejecutivo WHERE idvejecutivo   not  in (
                          //      SELECT idejecutivo FROM curso
                              //  WHERE idcurso not in (
                            //    SELECT idcurso FROM  curso WHERE idhorario not in($idhorario)
                              //  or idcurso not in (SELECT idcurso FROM duartema_nacional.curso 
                               // WHERE '$idfechaini' BETWEEN fechainicio and fechafin or '$idfechafin' BETWEEN //fechainicio and fechafin
                                //))
                                 //) and idarea=122 and idsede=$idsede and activo =1 and estado =1";
           $consulta="SELECT * FROM vejecutivo WHERE idvejecutivo AND idarea=122 and idsede=$idsede and activo =1 and estado =1";
        // $consulta="SELECT * FROM vejecutivo WHERE idvejecutivo  AND idarea=122  and activo =1 and estado =1";
                      foreach($curso->sql($consulta) as $f)
                      {
                        //$idcurso=ecUrl($f['idcurso']);
                      ?>
                      <tr>
                      <td>
                          <?php
                            $carnet=$f['carnet']." ".$f['expedido'];
                            echo $carnet;
                          ?>
                      </td>
                        <td><?php $nombre=$f['nombre']." ".$f['paterno']." ".$f['materno'];
                            echo $nombre;
                            $nombre=str_replace(" ", "&nbsp;", $nombre);
                         ?></td>
                        <td><button class="btn-jh waves-effect waves-light blue" onclick="Enviar('<?php echo $f["idvejecutivo"] ;?>','<?php echo $nombre ;?>');"><i class="mdi-action-assignment"></i> Seleccionar</button></td>
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
    function Enviar(id,nombre){
      //alert(id+' '+nombre);
        opener.document.idform.idejecutivoInport.value = id;
        opener.document.idform.idnombreInport.value = nombre;
        window.close();
    }
    function cerrar()
    {
     window.close(); 
    }
    
          
   

    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
      $('.btndel').tooltip({delay: 50});
    }); 
   
      function validar(){
        retorno=true;
        mod=$('#idmodulo').val();
        doc=$('#iddocente').val();
        fechai=$('#idfechaini').val();
        fechaf=$('#idfechafin').val();
        horai=$('#idhoraini').val();
        horaf=$('#idhorafin').val();
        if(mod=="0" || doc=="0" || fechai=="" || fechaf=="" || horai=="" || horaf==""){
          retorno=false;
        }
        return retorno;
      }
    
    </script>
</body>

</html>