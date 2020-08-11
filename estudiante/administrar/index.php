<?php
  $ruta="../../";
   include_once($ruta."class/vestudiantefull.php");
  $vestudiantefull=new vestudiantefull;
  include_once($ruta."class/persona.php");
  $persona=new persona;
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
      $hd_titulo="Lista de estudiante";
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
          $idmenu=1025;
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
                         
   
                               
                            
                        </div>
                      </form>
                    </div>
               <!--     <div class="modal-footer">
                                    
                    </div> -->
            </div>

            <div class="container">
            <div class="section">
             <div class="row">
                <div id="modal2" class="modal">
                  <div class="modal-content">
                  <h1 align="center">Observación</h1>
                    <form class="col s12" id="idform2" action="return false" onsubmit="return false" method="POST">
                    <input id="idestudianteSel" name="idestudianteSel" type="hidden">
                    <input id="idejecutivo" name="idejecutivo" type="hidden" value="<?php echo $us['idadmejecutivo'] ?>">
                    <div id="card-alert" class="col s12 m12 l12 card deep-purple lighten-5">
                          <div class="col s12 m12 l12" >
                            <label class="light center-align blue-text" style="font-size:25px;"><i class="mdi-social-person"></i>ESTUDIANTE</label>
                            </div>
                            <div class="col s12 m12 l12">
                            <div class="card-content deep-purple-text">                             
                               <p> <strong>CARNET: </strong><label id="idcarnet" style="color:#252525; font-size:15px;"></label></p>
                               <p> <strong>ESTUDIANTE: </strong><label id="idestudiantenombre" style="color:#252525; font-size:15px;"></label></p>
                                <input id="idest" type="hidden">
                            </div>
                             </div>
                          </div>
                        <div    v class="row">
                             <div class="input-field col s12 m3">
                               <strong>Observación:</strong>
                            </div>
                        <div class="input-field col s9">
                          <textarea id="iddescripcion" name="iddescripcion" class="materialize-textarea"></textarea>
                          <label for="iddescripcion">Descripcion</label>
                        </div>
                        </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardarObs();"><i class="fa fa-save"></i> GUARDAR</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
                  </div>
                </div>
             </div>
                </div> </div>
                
          <div class="container">
            <div class="section">
              <div id="table-datatables">
             <!-- <a href="../inicio" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> -->
             
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Cuenta</th>
                        <th>Contrato</th> 
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Modulo</th>
                        <th>Horario</th> 
                        <th>Estado</th>
                        <th> </th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Estudiante</th>
                        <th>Cuenta</th>
                        <th>Contrato</th> 
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Modulo</th>
                        <th>Horario</th> 
                        <th>Estado</th>
                        <th> </th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      foreach($vestudiantefull->mostrarTodo("idsede=".$idsede." and estado in(1,2)  ") as $f)
                      {
                        $idest=ecUrl($f['idestudiante']);
                      ?>
                      
                      <tr style="<?php echo $style ?>" >
                        <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td> 
                        <td><?php echo $f['cuenta'] ?></td>
                        <td><?php echo $f['nrocontrato'] ?></td> 
                        <td><?php echo $f['fechainicio'] ?></td>
                        <td><?php echo $f['fechafin'] ?></td>
                        <td><?php echo $f['modulo'] ?></td>

                        <td><?php echo $f['inicio'] ?></td>

                        <td><?php echo $f['nestadoacademico'] ?></td>
                        <td>
                           <!-- <a href="modificar.php?idecod=<?php echo $idest ?>" class="btn-jh waves-effect waves-light blue"><i class="mdi-content-create"></i> Editar</a>-->
                            <a href="../impresion/asistencia.php?idecod=<?php echo $idest ?>" class="btn-jh waves-effect waves-light green tooltipped" target="_blank" data-position="bottom" data-delay="50" data-tooltip="VER ASISTENCIAS"><i class="mdi-action-assignment-turned-in"></i>  </a>
                       </td>
                        <td>
                            <a href="#modal2" class="btn-jh waves-effect waves-light red modal-trigger tooltipped" onclick="cargar('<?php echo $f['idestudiante'] ?>');" data-position="bottom" data-delay="50" data-tooltip="AGREGAR OBSERVACION"><i class="mdi-image-remove-red-eye"></i> </a>
                        </td>
                          <td>
                             <a href="../impresion/reporte.php?idecod=<?php echo $idest ?>" class="btn-jh waves-effect waves-light blue tooltipped" target="_blank" data-position="bottom" data-delay="50" data-tooltip="VER REPORTE OBSERVACIONES"><i class="mdi-action-print"></i> </a>
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

 
     
     $("#btnSsaveV2").click(function(){
             
        iddocente=$("#idest").val();
        window.open("vistapordocente/?iddocente="+$("#iddocente").val(),"_blank");
         
      });
        
   

  
      $("#btnSave").click(function(){        
        if (validar()) 
        {        
          $('#btnSave').attr("disabled",true);
          var str = $( "#idform" ).serialize();
          //alert(str);
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
     function guardarObs()
    {
       if (validar()) 
        {        
          //$('#btnSave').attr("disabled",true);
          var str = $( "#idform2" ).serialize();
         //alert(str);
          $.ajax({
            url: "guardarObs.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
        }else{
          Materialize.toast('<span>Ingrese una observación porfavor</span>', 1500);
          
        }
    } 
    function cargar(ide)
     {
        $('#idestudianteSel').val(ide);
        $.ajax({
            async: true,
            url: "cargarestudiante.php?ide="+ide,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#idestudiantenombre").text(json.estudiante);
                $("#idcarnet").text(json.carnet);
                
                $("#idest").text(json.idperson);
               
            }
          });
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