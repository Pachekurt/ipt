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
   include_once($ruta."class/horario.php");
  $horario=new horario;
   include_once($ruta."class/vcurso.php");
  $vcurso=new vcurso;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  session_start(); 
  extract($_GET);
  $idestudiante=dcUrl($lblcode); 
  //echo $idestudiante;

  $est=$estudiante->mostrar($idestudiante);
  $est=array_shift($est);
  $per=$persona->mostrarTodo("idpersona=".$est['idpersona']);
  $per=array_shift($per);
   $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Asignar a un Curso";
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
          $idmenu=1021;
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

            <div id="modal1" class="modal">
                    <div class="modal-content">
                      <div class="row">
                      <div class="col s12 m12 l6" >
                        <h1 align="center">ASIGNAR</h1>
                      </div>
                      <div class="col s12 m12 l6" align="right">
                        <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>
                      </div>
                     </div> 
                    
                  
                      <form class="col s12" id="idform" name="idform" action="return false" onsubmit="return false" method="POST">
                        <div class="row">

                          <div id="card-alert" class="col s12 m12 l6 card deep-purple lighten-5">
                          <div class="col s12 m12 l12" >
                            <label class="light center-align blue-text" style="font-size:25px;"><i class="mdi-social-person"></i>ESTUDIANTE</label>
                            </div>
                            <div class="col s12 m12 l12">
                            <div class="card-content deep-purple-text">
                             <p><strong>NOMBRE: </strong> <?php echo $per['nombre']." ".$per['paterno']." ".$per['materno'] ?></p>
                              <p><strong>CARNET: </strong> <?php echo $per['carnet']." ".$per['expedido'] ?></p>
                            </div>
                             </div>
                          </div>
                          <div id="card-alert3" class="col s12 m12 l6 card red lighten-5">
                          <div class="col s12 m12 l12" >
                            <label class="light center-align blue-text" style="font-size:25px;"><i class="mdi-navigation-check"></i>CURSO INSCRITO</label>
                            </div>
                            <div class="card-content red-text">
                             <p> <strong>MODULO: </strong><label id="moduloEC" style="color:#252525; font-size:15px;"></label></p>
                              <p> <strong>HORARIO: </strong><label id="horarioEC" style="color:#252525; font-size:15px;"></label></p>
                             
                            </div>
                         </div>

                         <div id="card-alert2" class="col s12 m12 l12 card deep-purple lighten-5">
                          <div class="col s12 m12 l12" >
                            <label class="light center-align blue-text" style="font-size:25px;"><i class="fa fa-tag"></i>ASIGNAR ESTUDIANTE</label>
                            </div>
                            <div class="col s12 m12 l6">
                                <div class="card-content deep-purple-text">
                                 <p> <strong>MODULO: </strong><label id="modulo" style="color:#252525; font-size:15px;"></label></p>
                                  <p> <strong>HORARIO: </strong><label id="horario" style="color:#252525; font-size:15px;"></label></p>
                                   
                                </div>
                            </div>
                            <div class="col s12 m12 l6" align="right">
                              
                                    <div id="smsNo">
                                      <label style="color:green; font-size:16px; "><strong>ESTUDIANTE ASIGNADO A UN CURSO</strong></label>
                                    </div>
                                    <div id="smsSi">
                                       <button id="btnasignar" onclick="asignar();" class="btn waves-effect waves-light teal"><i class="mdi-action-assignment"></i>ASIGNAR AL CURSO</button>
                                     
                                   </div>
                            </div>
                         </div>   
                              <input id="idcursoSel" name="idcursoSel" type="hidden">
                               <input id="existe" name="existe" type="hidden">
                            
                        </div>
                      </form>
                    </div>
               <!--     <div class="modal-footer">
                                    
                    </div> -->
            </div>
          <div class="container">
              <div class="row">
                 <a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>
                    <div id="card-alert" class="card deep-purple lighten-5" align="center">
                      <div class="card-content deep-purple-text">
                       <p><strong>NOMBRE: </strong> <?php echo $per['nombre']." ".$per['paterno']." ".$per['materno'] ?></p>
                        <p><strong>CARNET: </strong> <?php echo $per['carnet']." ".$per['expedido'] ?></p>
                      </div>
                  </div>
              </div>
            </div>
          <div class="container">
            <div class="section">
              <div id="table-datatables">               
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Modulo</th>
                        <th>Docente</th>
                        <th>Horario</th> 
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Modulo</th>
                        <th>Docente</th>
                        <th>Horario</th> 
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      foreach($vcurso->mostrarTodo("idsede=".$idsede." and idmodulo=".$est['idmodulo']) as $f)
                      {
                        $idcurso=ecUrl($f['idvcurso']);
                        
                        $estC=$estudiantecurso->mostrarTodo("idcurso=".$f['idvcurso']." and estado =1");
                      ?>
                      <tr>
                        <td><?php echo $f['modulo']." (".$f['mdescripcion'].")" ?></td>
                        <td><?php echo $f['nombre']." ".$f['paterno'] ?></td>
                        <td><?php echo $f['inicio'].' a '.$f['fin'] ?></td>
                         
                        <td><?php echo $f['descripcion'] ?></td>
                        <td style="font-size:17px; color:green;"><strong><?php echo count($estC) ?></strong> </td>
                        <td>
                         
                         <a href="#modal1" class="btn-jh waves-effect waves-light teal indigo modal-trigger" onclick="selecion('<?php echo $f['idvcurso'] ?>');"><i class="mdi-social-group-add"></i> Asignar</a>
                         <button class="btn-jh waves-effect waves-light light-blue darken-4" onclick="ver('<?php echo $idcurso ?>');"><i class="mdi-av-my-library-books"></i> Ver Curso</button>
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
   function agregar(id)
    {
      var idest='<?php echo $lblcode ?>'
          popup=window.open("seleccionar.php?idcurso="+id+"&idestudiante="+idest,"neo","width=1050,height=600,enumerar=si;");
          popup.focus();
          //$('#btnSendDirecto').attr("disabled",false);
    }
     function selecion(idc)
     {
        //document.idform.idcursoSel.value = idc;
        var idest='<?php echo $idestudiante ?>';
        $('#idcursoSel').val(idc);
        $.ajax({
            async: true,
            url: "cargarCurso.php?idc="+idc+"&ide="+idest,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#idcursoSel").val(json.idcursoInport);
                $("#modulo").text(json.modulo);
                $("#horario").text(json.horario);
                $("#fechainicio").text(json.fechainicio);
                $("#fechafin").text(json.fechafin);

                $("#moduloEC").text(json.moduloEC);
                $("#horarioEC").text(json.horarioEC);
                $("#fechainicioEC").text(json.fechainicioEC);
                $("#fechafinEC").text(json.fechafinEC);
                $("#existe").val(json.existe);
                if (json.existe==1) 
                {
                  document.getElementById('card-alert3').style.display='block';
                  document.getElementById('smsSi').style.display='none';
                  document.getElementById('smsNo').style.display='block';
                  
                }
                if (json.existe==0) 
                {
                  document.getElementById('card-alert3').style.display='none';
                  document.getElementById('smsNo').style.display='none';
                  document.getElementById('smsSi').style.display='block';
                }
            }
            
          });
     }   
        function ver(idc)
     {
        popup=window.open("ver.php?idcurso="+idc,"neo","width=800,height=600,enumerar=si;");
        popup.focus();
     }  
    function asignar()
    {
      var idest='<?php echo $idestudiante ?>';
      var idcur=document.getElementById('idcursoSel').value;
            //alert(idest+' '+idcur);     
          $('#btnasignar').attr("disabled",true);
          $.ajax({
            url: "guardar.php",
            type: "POST",
            data: "idcurso="+idcur+"&idestudiante="+idest,
            success: function(resp){
             console.log(resp);
              $('#idresultado').html(resp);
              //location.reload();

              location.href = "index.php";
            }
          });
        
    }

    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
      $('.btndel').tooltip({delay: 50});
    }); 


    </script>
</body>

</html>