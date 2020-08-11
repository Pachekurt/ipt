<?php
  $ruta="../../";

    include_once($ruta."class/usuario.php");
  $usuario=new usuario;

  include_once($ruta."class/pregunta.php");
  $pregunta=new pregunta;
   include_once($ruta."class/dominio.php");
  $dominio=new dominio;
     include_once($ruta."class/modulo.php");
  $modulo=new modulo;
    include_once($ruta."class/referencia.php");
  $referencia=new referencia;
  session_start();
   extract($_GET);
  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $ID_sede=$us['idsede'];

   $mo=$modulo->mostrar($idm);
   $mo=array_shift($mo); 
   $do=$dominio->mostrar($ida);
   $do=array_shift($do); 
   $opcion=$do['nombre'];
   $_SESSION["idrefe"]=0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Lista de preguntas de ".$do['nombre'];
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
 <style type="text/css">   
.btn, .btn-large {
  background-color: #2196F3;
}

button:focus {
   outline: none;
   background-color: #2196F3;
}

.btn:hover, .btn-large:hover {
   background-color: #64b5f6;
}
</style>
  
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1014;
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
           <a href="#modal1" class="btn waves-effect deep-orange lighten-1 indigo modal-trigger"><i class="mdi-av-my-library-music"></i> Subir audio</a>
            <a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> 
           <div id="modal1" class="modal modal-fixed-footer">
                  <div class="modal-content">
                       <form class="col s12" id="idform" action="return false" onsubmit="return false" method="post" enctype="multipart/form-data">
                         <input id="idmodulo" name="idmodulo" value="<?php echo $idm ?>" type="hidden" >
                         <input id="idasignatura" name="idasignatura" value="<?php echo $ida ?>" type="hidden" >
                         <div class="col s12 m12"  align="center">
                            <label style="font-size:20px; color:#66ae43; font-weight: bold;">Nuevo audio (referencia)</label>
                          
                          </div>  
                    <div class="formcontent col s12 m12">
                      <div class="row">  
                           <div class="col s12 m12" align="center">
                              <label style="color:#454545; font-weight: bold; font-size:18px;"><?php echo $mo['nombre'].' - '.$mo['descripcion']; ?></label>
                            </div>
                            <div class="input-field col s12 m3">
                           <strong>Nombre:</strong>
                        </div>
                        <div class="input-field col s12 m9">
                           <input id="idnombre" name="idnombre" type="text" class="validate">
                          <label for="idnombre">Nombre</label>
                        </div>                 
                        
                        <div class="input-field col s12 m3">
                           <strong>Detalle:</strong>
                        </div>
                        <div class="input-field col s12 m9">
                           <textarea id="iddetalle" name="iddetalle" type="text" class="validate"></textarea>
                        </div>
                       
                      </div>
                    <div class="input-field col s12 m3">
                     <div class="col s12 m12">Upload de Audio: </div>
                      <table>
                        <tr>
                          <td>
                          <input name="mi_archivo" id="file" type="file" size="150" maxlength="150"> </td> 
                          <td>
                            <input class="btn btn-success" name="" type="submit" value="Subir Audio MP3" onclick="guardarDuracion();" /> 
                            <input name="accion" type="hidden" value="subir" />
                            <button onclick="GUARDARAAAA();">sube</button>
                            
                          </td>
                        </tr>
                      </table>
                     
                     

                     <?php                      
                    function SUBIR()
                    {
                     
                          $nuevo_nombre= $_SESSION["idrefe"];
                          $nueva_ruta='../upload/';
                           $nueva_ruta2=$nueva_ruta.$nuevo_nombre.'.mp3';
                       if(is_uploaded_file($_FILES['mi_archivo']['tmp_name'])) { 
                              if(move_uploaded_file($_FILES['mi_archivo']['tmp_name'], $nueva_ruta2)) 
                              { //movemos el archivo a su ubicacion 
                                 echo 'subio el audio';         
                           
                              }  
                          }
                          

                    }
                    ?>
                      <audio autoplay controls="controls" id="audio" type="audio/mpeg" preload="auto">
                       </audio>  
                      </div>
                    </div>
                                   <p>
                              <label>File Name:</label>
                              <span id="filename"></span>

                              <label>File Type:</label>
                              <span id="filetype"></span>

                              <label>File Size:</label>
                              <span id="filesize"></span>

                              <label>Song Duration:</label>
                              <span id="duration"></span>
                            </p>
                             <?php 

                     function veriiii()
                     {
                      echo 'we';
                     }
                       ?>
                  </form>
                   
                  </div>
                     <div class="modal-footer" align="right">                      
                       <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardar();"><i class="fa fa-save"></i> GUARDAR</button>
                       <button class="btn waves-effect waves-light red modal-close" ><i class="mdi-content-reply"></i> Cancelar</button>                                                        
                        </div>
                </div>
          <div class="container">
            <div class="section">
              <div class="row">
              <div id="table-datatables">
            
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                       <th>Referencia</th>
                        <th>Descripción</th>
                        <th>duracion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Referencia</th>
                        <th>Descripción</th>
                        <th>duracion</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      $fechaactual=date('Y-m-d'); 
                      foreach($referencia->mostrarTodo("idmodulo=".$idm." and tipo=1") as $f)
                      {
                       // $idah=ecUrl($f['idvactividadhabil']);
                      ?>
                      <tr>
                        <td><?php echo $f['nombre'] ?></td>
                        <td><?php echo $f['descripcion'] ?></td>
                        <td><?php echo $f['duracion'] ?></td>
                        <td>
                     
                      <a class="btn-jh waves-effect waves-light blue" href="verAudio.php?id=<?php echo $f['idreferncia']?>" target="_blank"> Escuchar audio <i class="fa fa-headphones"></i> </a>
                      <button class="btn-jh waves-effect deep-orange lighten-2" onclick="preguntas('<?php echo $idreferencia ?>');"><i class="mdi-action-assignment"></i> Ingresar</button>    
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
            //include_once("../../footer.php");
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
    <script src="moment.min.js"></script> 
    <script type="text/javascript">
       
    $(document).ready(function() {
      $('#example').DataTable({
        dom: 'Bfrtip',
        "order": [[ 0, "asc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
      $('.btndel').tooltip({delay: 50});
    }); 
   
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


      $("#btnSave").click(function(){        
            if (validar()) 
            {  
              
                   var str = $( "#idform" ).serialize();
                   // alert(str);
                    $.ajax({
                      url: "guardar.php",
                      type: "POST",
                      data: str,
                      success: function(resp){
                        console.log(resp);
                        $('#idresultado').html(resp);
                      }
                    });
              } else{
                Materialize.toast('<spanDatos invalidos revise porfavor</span>', 1500);
              }            
                   
          
      });
      function validar(){
        retorno=true;
        act=$('#idactividad').val();
        doc=$('#idejecutivo').val();
        fechai=$('#idfecha').val();
        dur=$('#idduracion').val();
        hora=$('#idhorainicio').val();
        if(act=="" || doc=="0" || fechai=="" || dur=="0" || hora=="0"){
          retorno=false;
        }
        return retorno;
      }

    </script>
  <script>
   
document.getElementById('boton').style.display='none';
   function GUARDARAAAA()
{
                 var str = $( "#idform" ).serialize();
                   // alert(str);
                    $.ajax({
                      url: "guardarreferencia.php",
                      type: "POST",
                      data: str,
                      success: function(resp){
                        console.log(resp);
                        $('#idresultado').html(resp);
                        var result="<?php SUBIR(); ?>";
                        alert(result);
                        return false;
                      }
                    });
}


  function scriptnext()
  { 
      location.href="referencias.php";
  }
  

    </script>
      <script>
   
var objectUrl;

$("#audio").on("canplaythrough", function(e){
    var seconds = e.currentTarget.duration;
    var duration = moment.duration(seconds, "seconds");
    
    var time = "";
    var hours = duration.hours();
    if (hours > 0) { time = hours + ":" ; }
    
    time = time + duration.minutes() + ":" + duration.seconds();
    $("#duration").text(time);
    
    URL.revokeObjectURL(objectUrl);
    //alert('entra');
});

$("#file").change(function(e){
    var file = e.currentTarget.files[0];
   
    $("#filename").text(file.name);
    $("#filetype").text(file.type);
    $("#filesize").text(file.size);
    
    objectUrl = URL.createObjectURL(file);
    $("#audio").prop("src", objectUrl);

});
    </script>
           <script>
           function guardarDuracion()
           {
          var id="<?php echo $id?>";
          var tiempo = $("#duration").text();
          var tiempo ='00:'+tiempo;

            $.ajax({
              url: "guardartiempo.php",
              type: "POST",
              data: "idreferencia="+id+"&idtiempo="+tiempo,
              success: function(resp){
                   // location.href = "paso2.php?id="+resp;//idexamen
                   alert(resp);
              }   
            });
            //alert('ingreso');
          }
            </script>  
    <!-- <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>-->
   <!-- <script src="./materialize-stepper.min.js"></script> -->
  <!-- <script src="https://rawgit.com/Kinark/Materialize-stepper/master/materialize-stepper.min.js"></script>-->
</body>

</html>