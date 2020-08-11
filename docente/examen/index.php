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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="LISTA DE ESTUDIANTES INSCRITOS";
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
              <a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> 
               























































              <div class="row">
               <form id="idform" action="return false" onsubmit="return false" method="POST">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                       <th>Estudiante</th> 
                       <th>RU</th>
                       <th>PASS</th>
                       <th>Modulo actual</th>
                       <th>Opciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Estudiante</th> 
                       <th>RU</th>
                       <th>PASS</th>
                        <th>Modulo actual</th>
                        <th>Opciones</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      $v=0;
                      foreach($vestudiante->mostrarTodo("idsede=".$idsede." and estado =1") as $f)
                      {
                         $v=$v+1;  
                          $lblcode=ecUrl($f['idvestudiante']);                     
                        ?>
                        <tr> 
                          <td><?php echo $f['nombre'].' '.$f['paterno'].' '.$f['materno'].'-->'.$f['idvestudiante'] ?></td>
                       
                          <td ><?php echo "-".$f['ru']."-"?> </td>
                          <td><?php echo $f['pass']?> </td>
                          <td><?php echo $f['modulo'].' '.$f['descripcion']?> </td>
                          <td>
                          <?php 
                            $cantidad=$estudiantereserva->mostrarTodo("idestudiante=".$f['idvestudiante']." and idtipoclase=1 and evaluado in(0,1)");
                            if (count($cantidad)>0) 
                             { 
                               $res=$estudiantereserva->mostrarTodo("idestudiante=".$f['idvestudiante']." and idtipoclase=1 and evaluado in(0,1)");
                               $res=array_shift($res);
                               $ider=ecUrl($res['idestudiantereserva']);
                               if ($res['evaluado']==0) {
                                      $ex=$examen->mostrarTodo("idestudiantereserva=".$res['idestudiantereserva']);
                                      if (count($ex)>0) 
                                      {
                                        ?>  
                                         <button class="btn-jh waves-effect waves-light blue" onclick="revisarexamen('<?php echo $ider ?>');"><i class="mdi-hardware-desktop-mac"></i> Revisar examen</button>                          
                                       <?php 
                                      }else{
                                        ?>  
                                       <button class="btn-jh waves-effect waves-light green" style="opacity:0.3;" ><i class="mdi-hardware-desktop-mac"></i> Habilitar examen</button>                           
                                        <button class="btn-jh waves-effect waves-light red" onclick="cancelarExam('<?php echo $res['idestudiantereserva'] ?>');"><i class="mdi-action-highlight-remove"></i> Cancelar</button>
                                       <?php 
                                      } 
                               }
                              if ($res['evaluado']==1) {
                                 ?>  
                                 <button class="btn-jh waves-effect waves-light blue" onclick="revisarexamen('<?php echo $ider ?>');"><i class="mdi-hardware-desktop-mac"></i> Revisar examen</button>                          
                               <?php 
                               }

                             }else{
// preguntamos si esta en modulo 10
                                  if ($f['idmodulo']==10) {
                                        switch ($f['examenfinal']) {
                                          case '0':
                                            # code.LISTENING
                                                    if($f['asistio']==5)
                                                    {  ?>  
                                                        <button class="btn-jh waves-effect waves-light red" onclick="cancelarFIN('<?php echo $f['idvestudiante'] ?>');"><i class="mdi-action-highlight-remove"></i> Cancelar LISTENING</button>                           
                                                      <?php 
                                                      }
                                                     else
                                                       {  ?>  
                                                       <button class="btn-jh waves-effect waves-light red" onclick="habilitafinal('<?php echo $f['idvestudiante'] ?>','0');"><i class="mdi-hardware-desktop-mac"></i> Habilitar LISTENING</button>                           
                                                      <?php 
                                                      }
                                            break;
                                          case '1':
                                            # code...grammar
                                                   if($f['asistio']==5)
                                                    {  ?>  
                                                        <button class="btn-jh waves-effect waves-light red" onclick="cancelarFIN('<?php echo $f['idvestudiante'] ?>');"><i class="mdi-action-highlight-remove"></i> Cancelar GRAMMAR</button>                           
                                                      <?php 
                                                      }
                                                     else
                                                       {  ?>  
                                                       <button class="btn-jh waves-effect waves-light orange" onclick="habilitafinal('<?php echo $f['idvestudiante'] ?>','1');"><i class="mdi-hardware-desktop-mac"></i> Habilitar GRAMMAR</button>                           
                                                      <?php 
                                                      }
                                            break;
                                          case '2':
                                          # code...reading
                                               if($f['asistio']==5)
                                                    {  ?>  
                                                        <button class="btn-jh waves-effect waves-light red" onclick="cancelarFIN('<?php echo $f['idvestudiante'] ?>');"><i class="mdi-action-highlight-remove"></i> Cancelar READING</button>                           
                                                      <?php 
                                                      }
                                                     else
                                                       {  ?>  
                                                       <button class="btn-jh waves-effect waves-light orange" onclick="habilitafinal('<?php echo $f['idvestudiante'] ?>','2');"><i class="mdi-hardware-desktop-mac"></i> Habilitar READING</button>                           
                                                      <?php 
                                                      }
                                          break;
                                          case '3':
                                             ?>  
                                                        <a href="#modal2" class="btn-jh waves-effect waves-light blue modal-trigger " onclick="cargar('<?php echo $f['idvestudiante'] ?>');"    ><i class="mdi-image-remove-red-eye">CALIFICAR WRITING</i> </a>                           
                                                      <?php 
                                                       
                                            break;
                                          case '4':
                                            ?>  
                                                        <a href="#modal3" class="btn-jh waves-effect waves-light red modal-trigger " onclick="cargar3('<?php echo $f['idvestudiante'] ?>');"    ><i class="mdi-image-remove-red-eye">CALIFICAR SPEECH</i> </a>                           
                                                      <?php 
                                            break;
                                             case '5':
                                                  echo "CULMINO TEST";
                                            break;
                                           
                                        }

                                  }
                                    else{
                                      ?>  
                                           <button class="btn-jh waves-effect waves-light green" onclick="habilitarexamen('<?php echo $f['idvestudiante'] ?>');"><i class="mdi-hardware-desktop-mac"></i> Habilitar examen</button>                           
                                          <?php 
                                    } 
                             }
                           ?>
                              
                            <a  href="listadoexamenes.php?lblcode=<?php echo $lblcode ?>" target="_blank" class="btn-jh waves-effect darken-4 red  " ><i class="mdi-action-assignment"></i>VER EXAMENES</a>






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
          </div> <div class="row">
                <div id="modal2" class="modal">
                  <div class="modal-content">
                  <h1 align="center">Observación</h1>
                    <form class="col s12" id="idform2" action="return false" onsubmit="return false" method="POST">
                    <input id="idestudianteSel2" name="idestudianteSel2" type="hidden">
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
                              <div     class="row">
                             <div class="input-field col s12 m3">
                               <strong>INGRESE NOTA DE WRITING:</strong>
                            </div>
                        <div class="input-field col s9">
                          <input  id="idnota" name="idnota" class="materialize-textarea"> 
                           
                        </div>
                        </div>
                             </div>
                          </div>
                      
                    </form>
                  </div>
                  <div class="modal-footer">
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardarnota();"><i class="fa fa-save"></i> GUARDAR</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
                  </div>
                </div>
             </div>
             <div class="row">
                <div id="modal3" class="modal">
                  <div class="modal-content">
                  <h1 align="center">Observación</h1>
                    <form class="col s12" id="idform3" action="return false" onsubmit="return false" method="POST">
                    <input id="idestudianteSel3" name="idestudianteSel3" type="hidden">
                    <input id="idejecutivo" name="idejecutivo" type="hidden" value="<?php echo $us['idadmejecutivo'] ?>">
                    <div id="card-alert" class="col s12 m12 l12 card light-blue lighten-5">
                          <div class="col s12 m12 l12" >
                            <label class="light center-align blue-text" style="font-size:25px;"><i class="mdi-social-person"></i>ESTUDIANTE</label>
                            </div>
                            <div class="col s12 m12 l12">
                            <div class="card-content deep-purple-text">                             
                               <p> <strong>CARNET: </strong><label id="idcarnet3" style="color:#252525; font-size:15px;"></label></p>
                               <p> <strong>ESTUDIANTE: </strong><label id="idestudiantenombre3" style="color:#252525; font-size:15px;"></label></p>
                                <input id="idest3" type="hidden">
                            </div>
                              <div     class="row">
                             <div class="input-field col s12 m3">
                               <strong>INGRESE NOTA DE SPEECH:</strong>
                            </div>
                        <div class="input-field col s9">
                          <input  id="idnota3" name="idnota3" class="materialize-textarea"> 
                           
                        </div>
                        </div>
                             </div>
                          </div>
                      
                    </form>
                  </div>
                  <div class="modal-footer">
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardarnota3();"><i class="fa fa-save"></i> GUARDAR</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
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


     function habilitarexamen(idve)
     { 
       swal({
          title: "Estas Seguro?",
          text: "HABILITAR EXAMEN PARA EL ESTUDIANTE?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {      
              $.ajax({
                      url: "habilitarexamen.php",
                      type: "POST",
                      data: "idestudiante="+idve,
                      success: function(resp){
                        console.log(resp);
                        $('#idresultado').html(resp);
                        if (resp==1) 
                          {
                            swal({
                                  title: "Exito",
                                  text: "Se habilito correctamente el examen",
                                  type: "success",
                                  //showCancelButton: true,
                                  confirmButtonColor: "#28e29e",
                                  confirmButtonText: "Estoy Seguro",
                                  closeOnConfirm: false
                                }, function () {      
                                      location.reload();
                                }); 
                          }
                        if (resp==2) 
                          {
                            swal("Error!", "No se registro", "warning");
                          }
                          if (resp==3) 
                          {
                            swal("Error!", "Ya se encuentra habilitado el examen o esta en proceso un examen anterior", "warning");
                          }
                       
                      }
                    });
        });     
          
     } 

       function habilitafinal(idve,tipo)
     { 
     // alert(tipo);
       swal({
          title: "Estas Seguro?",
          text: "HABILITAR EXAMEN PARA EL ESTUDIANTE?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {      
              $.ajax({
                      url: "habilitafinal.php",
                      type: "POST",
                      data: "idestudiante="+idve+"&tipo="+tipo,
                      success: function(resp){
                        console.log(resp);
                        $('#idresultado').html(resp);
                        if (resp==1) 
                          {
                            swal({
                                  title: "Exito",
                                  text: "Se habilito correctamente el examen",
                                  type: "success",
                                  //showCancelButton: true,
                                  confirmButtonColor: "#28e29e",
                                  confirmButtonText: "Estoy Seguro",
                                  closeOnConfirm: false
                                }, function () {      
                                      location.reload();
                                }); 
                          }
                        if (resp==2) 
                          {
                            swal("Error!", "No se registro", "warning");
                          }
                          if (resp==3) 
                          {
                            swal("Error!", "Ya se encuentra habilitado el examen o esta en proceso un examen anterior", "warning");
                          }
                       
                      }
                    });
        });     
          
     } 
      function cancelarExam(ider){
        swal({
          title: "Estas Seguro?",
          text: "Cancelar examen del alumno, puede que este en proceso...",
          type: "error",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {      
          $.ajax({
            url: "cancelarExamen.php",
            type: "POST",
            data: "idestudiantereserva="+ider,
            success: function(resp){
              $("#idresultado").html(resp);
                 if (resp==1) 
                {
                               swal({
                                  title: "Exito",
                                  text: "Se cancelo correctamente el examen",
                                  type: "success",
                                  //showCancelButton: true,
                                  confirmButtonColor: "#28e29e",
                                  confirmButtonText: "Estoy Seguro",
                                  closeOnConfirm: false
                                }, function () {      
                                      location.reload();
                                }); 
                }
                if (resp==2) 
                {
                  swal("Error!", "No se registro", "warning");
                }
                   if (resp==3) 
                {
                               swal({
                                  title: "Error",
                                  text: "No puede Cancelar, El examen esta en proceso, actualize la pagina.",
                                  type: "warning",
                                  //showCancelButton: true,
                                  confirmButtonColor: "#28e29e",
                                  confirmButtonText: "Estoy Seguro",
                                  closeOnConfirm: false
                                }, function () {      
                                      location.reload();
                                }); 
                }
            }   
          });
        }); 
      }

        function cancelarFIN(ider){
        swal({
          title: "Estas Seguro?",
          text: "Cancelar examen final del ESTUDIANTE, puede que este en proceso...",
          type: "error",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Estoy Seguro",
          closeOnConfirm: false
        }, function () {      
          $.ajax({
            url: "cancelarExamenf.php",
            type: "POST",
            data: "idest="+ider,
            success: function(resp){
              $("#idresultado").html(resp);
                 if (resp==1) 
                {
                               swal({
                                  title: "Exito",
                                  text: "Se cancelo correctamente el examen",
                                  type: "success",
                                  //showCancelButton: true,
                                  confirmButtonColor: "#28e29e",
                                  confirmButtonText: "Estoy Seguro",
                                  closeOnConfirm: false
                                }, function () {      
                                      location.reload();
                                }); 
                }
                if (resp==2) 
                {
                  swal("Error!", resp, "warning");
                }
                   if (resp==3) 
                {
                               swal({
                                  title: "Error",
                                  text: "No puede Cancelar, El examen esta en proceso, actualize la pagina.",
                                  type: "warning",
                                  //showCancelButton: true,
                                  confirmButtonColor: "#28e29e",
                                  confirmButtonText: "Estoy Seguro",
                                  closeOnConfirm: false
                                }, function () {      
                                      location.reload();
                                }); 
                }
                
            }   
          });
        }); 
      }

      
  function guardarnota()
    {
         notagrammar=$('#idnota').val();
       if (notagrammar!="") 
        {        
          //$('#btnSave').attr("disabled",true);
          var str = $( "#idform2" ).serialize();
          // alert(str);
          $.ajax({
            url: "guardarnota.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
              location.reload();
            }
          });
        }else{
          Materialize.toast('<span>Ingrese una nota porfavor</span>', 1500);
          
        }
    } 
      function guardarnota3()
    {
         notagrammar=$('#idnota3').val();
       if (notagrammar!="") 
        {        
          //$('#btnSave').attr("disabled",true);
          var str = $( "#idform3" ).serialize();
           alert(str);
          $.ajax({
            url: "guardarnota3.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
              location.reload();
            }
          });
        }else{
          Materialize.toast('<span>Ingrese una nota porfavor</span>', 1500);
          
        }
    } 
    function guardarnotas()
    {
         notas=$('#idnota3').val();
       if (notas!="") 
        {        
          //$('#btnSave').attr("disabled",true);
          var str = $( "#idform3" ).serialize();
           alert(str);
          $.ajax({
            url: "guardarnotas.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
        }else{
          Materialize.toast('<span>Ingrese una nota porfavor</span>', 1500);
          
        }
    } 
       function cargar(ide)
     {
        $('#idestudianteSel2').val(ide);
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
     function cargar3(ide)
     {
        $('#idestudianteSel3').val(ide);
        $.ajax({
            async: true,
            url: "cargarestudiante.php?ide="+ide,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#idestudiantenombre3").text(json.estudiante);
                $("#idcarnet3").text(json.carnet);
                
                $("#idest3").text(json.idperson);
               
            }
          });
     }  
function revisarexamen(ider){
        
    location.href = "revisar.php?ider="+ider;
}
    </script>
</body>

</html>