<?php
  $ruta="../../";
   include_once($ruta."class/vactividadreserva.php");
  $vactividadreserva=new vactividadreserva;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/asistenciaact.php");
  $asistenciaact=new asistenciaact;
  include_once($ruta."class/vactividadhabil.php");
  $vactividadhabil=new vactividadhabil;
  session_start(); 
   extract($_GET);
   $idactividadhabil=dcUrl($codeidah);

   $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede']; 

  $vah=$vactividadhabil->mostrar($idactividadhabil);
  $vah=array_shift($vah);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="ACTIVIDAD";
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
          $idmenu=1018;
          include_once($ruta."aside.php");
    ?>
 
   

  
                
<div class="row">
        <div id="modal3" class="modal">
            <div class="modal-content">
            <h1 align="center">Informacion del alumno</h1>
            <form class="col s12" id="idform4" action="return false" onsubmit="return false" method="POST">
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <strong>Nombre:</strong><h5 value=""  class="form-control" name="estudiantenombre" id="estudiantenombre"></h5> 
                                <strong>C.I.:</strong><h5 value=""   class="form-control" name="estudiantecarnet" id="estudiantecarnet"></h5> 
                                <strong>Academico:</strong><h5 value="" class="form-control" name="nacademico" id="nacademico"></h5> 
                                <strong>Contrato:</strong><h5 value="" class="form-control" name="ncontrato" id="ncontrato"></h5> 
                                <label style="visibility:hidden;" type="hidden" value=""   class="form-control" name="estudianteid" id="estudianteid"></label><br>
                                <label style="visibility:hidden;" type="hidden"  class="form-control" name="cursoid" id="cursoid"><?php echo $idactividadhabil; ?></label>
                             
                                 <label style="visibility:hidden;" type="hidden" value="" class="form-control" name="academicoid" id="academicoid"></label>
                                  <label style="visibility:hidden;" type="hidden" value="" class="form-control" name="contratoid" id="contratoid"></label>
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                          
            </form>
            </div>
                        <div class="modal-footer">
                            <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="agregaralumno();"><i class="fa fa-save"></i> AGREGAR</button>
                            <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
                        </div>  
        </div>
</div>
    
            
            
            
            
    <div class="container">
            <div class="section">
             <div class="row">
                <div id="modal1" class="modal">
                  <div class="modal-content">
                  <h1 align="center">Observación - Actividad</h1>
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
                            </div>
                             </div>
                          </div>
                     <div class="row">
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
            </div>  
          </div>  
          
          
          
          <div class="container">
            <div class="section">
                    <div class="row">
                <div class="col s12 m12 l2">&nbsp;</div>
                <div class="col s12 m12 l8" style="">
                        <div class="row">
              <div class="col s12 m4 l3">
                <a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>
              </div>
                <div class="col s12 m8 l9">
                <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                  <li>
                    <div class="collapsible-header" style="color: green">Agregar Estudiante</div>
                    <div class="collapsible-body"> 
                             
                      <input type="text"   name="buscarcarnet" id="buscarcarnet" placeholder="C.I." value="">
                      <a href="#modal3" class="btn-jh waves-effect waves-light green modal-trigger" onclick="buscar();"><i class="mdi-editor-insert-comment"></i> Buscar</a>
                              
                           
                    </div>
                  </li>
                </ul>
              </div>
            </div>
                </div>
                <div class="col s12 m12 l2">&nbsp;</div>
            </div>  
            <div class="row">

            <div class="col s12 m12 l2">&nbsp;</div>
            <div class="col s12 m12 l8" style="background:#b2ebf2;">
              <div id="table-datatables">
              <div align="center"> <label style="font-size:30px; color:#00838f ;"><strong>ACTIVIDAD - <?php echo $vah['actividad'] ?> </strong></label> </div> 
               

              <div class="row" >
               <form id="idform" action="return false" onsubmit="return false" method="POST" >
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                       <th>Estudiante</th>
                       <th>Carnet</th>
                       <th>Asistencia</th>
                       <th>Faltas</th>
                       <th>Asistencia</th>
                       <th>Opciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Estudiante</th>
                        <th>Carnet</th>
                        <th>Asistencia</th>
                        <th>Faltas</th>
                        <th>Asistencia</th>
                        <th>Opciones</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      $v=0;
                      $fechaasis=date('Y-m-d');
                      foreach($vactividadreserva->mostrarTodo("idactividadhabil=".$idactividadhabil." and idsede=".$idsede) as $f)
                      {
                        $idest=$f['idestudiante'];
                         $v=$v+1;
                         $as=$asistenciaact->mostrarTodo("idactividadreserva=".$f['idvactividadreserva']);
                         $as=array_shift($as);
                         $cantidad=$asistenciaact->mostrarTodo("idactividadreserva=".$f['idvactividadreserva']);
                          

                          $consulta="SELECT aa.idasistenciaact, aa.idactividadreserva,ar.idestudiante, aa.asis, aa.fechaasistencia, aa.usuariocreacion, aa.fechacreacion, aa.horacreacion, aa.nombrehost, aa.activo
                                      FROM asistenciaact aa
                                      inner join actividadreserva ar on ar.idactividadreserva = aa.idactividadreserva
                                         where ar.idestudiante=$idest and aa.activo=1";
                              $Casis=0;
                              $Cfaltas=0;
                            foreach($asistenciaact->sql($consulta) as $contar)
                            {
                               if ($contar['asis']==1)
                               {
                                 $Casis=$Casis+1;
                               }
                               if ($contar['asis']==0)
                               {
                                  $Cfaltas=$Cfaltas+1;
                               }
                            }
                          
                     ?>
                      <tr>
                        <td><?php echo $f['nombre'].' '.$f['paterno'].' '.$f['materno'] ?></td>
                        <td><?php echo $f['carnet']?> </td>
                         <td style="color:green;"><?php echo $Casis ?> </td>
                          <td style="color:red;"><?php echo $Cfaltas ?> </td>
                        <td>
                         
                         <?php 
                            if (count($cantidad)>0) 
                            {
                              ?>
                              <p>
                                 <input onclick="guardarasistencia('<?php echo $as['idasistenciaact'] ?>');" name="<?php echo $as['idasistenciaact'] ?>"  value="<?php echo $as['idasistenciaact'] ?>" type="checkbox" <?php if ($as['asis']==1) echo 'checked';?> id="<?php echo $as['idasistenciaact'] ?>" />
                                 <label for="<?php echo $as['idasistenciaact'] ?>"><i class="fa fa-thumbs-up"></i></label>
                              </p>
                              <?php
                            }else{
                               ?>
                              <p>
                                 <label>SIS</label>
                              </p>
                              <?php
                            }
                          ?>
                                                 
                                  
                        </td>
                        <td>
                            <a href="#modal1" class="btn-jh waves-effect waves-light red modal-trigger" onclick="cargar('<?php echo $f['idestudiante'] ?>');"><i class="mdi-editor-insert-comment"></i> Obs.</a>
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
         <!-- <?php
           // include_once("../../footer.php");
          ?> -->
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
    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
      $('.btndel').tooltip({delay: 50});
    });
    function guardarObs()
    {
       if (validar()) 
        {        
          //$('#btnSave').attr("disabled",true);
          var str = $( "#idform2" ).serialize();
         // alert(str);
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
     
      function validar(){
        retorno=true;
        es=$('#idestudianteSel').val();
        des=$('#iddescripcion').val();
        eje=$('#idejecutivo').val();
        if(es=='' || des=='' || eje==''){
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


 function guardarasistencia(id)
 {
  //alert(id); 
        if($("#"+id).is(':checked')) 
        {  
            //alert("Está activado");
            var asistencia= 1;  
        }else{  
            var asistencia= 0;   
        }
        $.ajax({
            url: "guardar.php",
            type: "POST",
            data: "idasistenciaact="+id+"&asis="+asistencia,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });  
     
 }

  function cargar(ide)
     {
        $('#idestudianteSel').val(ide);
        $.ajax({
            async: true,
            url: "../clase/cargarestudiante.php?ide="+ide,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#idestudiantenombre").text(json.estudiante);
                $("#idcarnet").text(json.carnet);
               
            }
            
          });
     }   
        
        function buscar()
     {
        if (validarAlumno()) 
        {
        ci=$('#buscarcarnet').val();
        $.ajax({
            async: true,
            url: "cargarestudiante1.php?ci="+ci,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#estudiantenombre").text(json.estudiante);
                $("#estudiantecarnet").text(json.carnet);  
                $("#estudianteid").text(json.idest);  
                $("#academicoid").text(json.academico);  
                $("#contratoid").text(json.contrato);  
                $("#nacademico").text(json.nacademico);  
                $("#ncontrato").text(json.ncontrato);  
            }         
        });
        }
     }   
    function validarAlumno(){
        retorno=true;
        return retorno;
      }
       
    function agregaralumno()
    {   
         estu=$('#estudianteid').text();
            cur=$('#cursoid').text();
            aca=$('#academicoid').text();
            cont=$('#contratoid').text();
       // alert(estu)
      if (validarAlumno()) 
        {       
            // alert(cur)
          //$('#btnSave').attr("disabled",true);
         
            // alert(estu);  
            // alert(cur); 
          $.ajax({
            url: "guardarestudianteactividad.php",
            type: "POST",
            data: "estudianteid="+estu + "&actividadid="+cur,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
        }else{
          Materialize.toast('<span>Ingrese una observación porfavor</span>', 1500);
        }
    }     
     
    </script>
   
        
</body>

</html>