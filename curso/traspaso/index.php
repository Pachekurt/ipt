<?php
  $ruta="../../";
   include_once($ruta."class/estudiante.php");
  $estudiante=new estudiante;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/estudiantecurso.php");
  $estudiantecurso=new estudiantecurso;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  session_start(); 

  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede']; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="LISTA DE ALUMNOS ";
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
          $idmenu=1012;
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
                        <h1 align="center">INFORMACIÓN</h1>
                      </div>
                      <div class="col s12 m12 l6" align="right">
                        <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>
                      </div>
                     </div> 
                    
                  
                      <form class="col s12" id="idform" name="idform" action="return false" onsubmit="return false" method="POST">
                        <div class="row">

                          <div id="card-alert" class="col s12 m12 l6 card green lighten-5">
                            <div class="col s12 m12 l12" >
                              <label class="light center-align green-text" style="font-size:25px;"><i class="mdi-image-timer-auto"></i>ESTUDIANTE</label>
                            </div>
                            <div class="col s12 m12 l12">
                            <div class="card-content green-text">
                              <p> <strong>ESTUDIANTE: </strong><label id="estudianteEC" style="color:#252525; font-size:15px;"></label></p>
                              <p> <strong>CARNET: </strong><label id="carnetEC" style="color:#252525; font-size:15px;"></label></p>
                            </div>
                             </div>
                          </div>
                          <div id="card-alert3" class="col s12 m12 l6 card green lighten-5">
                          <div class="col s12 m12 l12" >
                            <label class="light center-align green-text" style="font-size:25px;"><i class="mdi-navigation-check"></i>CURSO ACTUAL INSCRITO</label>
                            </div>
                            <div class="card-content green-text">
                            <p> <strong>DOCENTE: </strong><label id="docenteEC" style="color:#252525; font-size:15px;"></label></p>
                             <p> <strong>MODULO: </strong><label id="moduloEC" style="color:#252525; font-size:15px;"></label></p>
                              <p> <strong>HORARIO: </strong><label id="horarioEC" style="color:#252525; font-size:15px;"></label></p>
                             
                            </div>
                         </div>
   
                              <input id="idestudianteSel" name="idestudianteSel" type="hidden">
                            
                        </div>
                      </form>
                    </div>
               <!--     <div class="modal-footer">
                                    
                    </div> -->
            </div>
          <div class="container">
            <div class="section">
              <div id="table-datatables">
             <!-- <a href="../inicio" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> -->
             
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Carnet</th>
                        <th>Celular</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Estudiante</th>
                        <th>Carnet</th>
                        <th>Celular</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      $consulta="SELECT ec.idestudiantecurso,ec.idestudiante,e.idsede,p.idpersona,p.nombre,p.paterno,p.materno,p.carnet,p.expedido,p.celular,ec.idcurso,ec.estado,ec.fechacreacion,ec.horacreacion,ec.activo
                                FROM duartema_nacional.estudiantecurso ec
                                inner join estudiante e on e.idestudiante = ec.idestudiante
                                inner join persona p on p.idpersona = e.idpersona
                                where ec.estado=1 and ec.activo = 1 and e.idsede=$idsede";
                      foreach($estudiante->sql($consulta) as $f)
                      {
                        $idest=ecUrl($f['idestudiante']);
                      ?>
                      <tr style="background-color:#ffe6ba;color: #ff6c00" >
                        
                              <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td>
                              <td><?php echo $f['carnet']." ".$f['expedido'] ?></td>
                              <td><?php echo $f['celular'] ?></td>
                             <td>
                             <a href="traspaso.php?lblcode=<?php echo $idest ?>" class="btn-jh waves-effect red"><i class="mdi-action-assignment"></i> Traspasar</a> 
                             <a href="#modal1" class="btn-jh waves-effect light-green darken-4 indigo modal-trigger" onclick="cursoactual('<?php echo $f['idestudiante'] ?>');"><i class="mdi-action-visibility"></i> Curso Actual</a>
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
      function cursoactual(ide)
     {
        
        $('#idestudianteSel').val(ide);
        $.ajax({
            async: true,
            url: "../asignar/cargarCursoEst.php?ide="+ide,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#idestudianteSel").val(json.idestudianteInport);
                $("#docenteEC").text(json.docenteEC);
                $("#moduloEC").text(json.moduloEC);
                $("#horarioEC").text(json.horarioEC);
                $("#fechainicioEC").text(json.fechainicioEC);
                $("#fechafinEC").text(json.fechafinEC);
                $("#estudianteEC").text(json.estudianteEC);
                $("#carnetEC").text(json.carnetEC);              
            }
            
          });
     }
    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
      $('.btndel').tooltip({delay: 50});
    }); 
      $("#btnSave").click(function(){        
        if (validar()) 
        {        
          $('#btnSave').attr("disabled",true);
          var str = $( "#idform" ).serialize();
          alert(str);
          $.ajax({
            url: "guardar.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
        }
        else{
          Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
        }
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
      function Eliminar(id){
        swal({
          title: "Estas Seguro?",
          text: "El rol se eliminara",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {      
          $.ajax({
            url: "eliminar.php",
            type: "POST",
            data: "id="+id,
            success: function(resp){
              $("#idresultado").html(resp);
            }   
          });
        }); 
      }
    </script>
</body>

</html>