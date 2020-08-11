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
  session_start();
   extract($_GET);
  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $ID_sede=$us['idsede'];

   $idm=dcUrl($idmcod);
   $ida=dcUrl($idacod);
   $idp=dcUrl($idpcod);

   $mo=$modulo->mostrar($idm);
   $mo=array_shift($mo); 
   $do=$dominio->mostrar($ida);
   $do=array_shift($do); 
   $opcion=$do['nombre'];

    $pr=$pregunta->mostrar($idp);
   $pr=array_shift($pr);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="ACTUALIZAR DATOS DE PREGUNTA DE ".$do['nombre'];
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
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1023;
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
          
            <a href="listar.php?idmcod=<?php echo $idmcod ?>&idacod=<?php echo $idacod ?>" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> 
           
          <div class="container">
            <div class="section">
              <div class="row">
              <div class="col s12 m2">&nbsp;</div>
              <div class="col s12 m8">
                <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                         <input id="idmodulo" name="idmodulo" value="<?php echo $idm ?>" type="hidden" >
                         <input id="idasignatura" name="idasignatura" value="<?php echo $ida ?>" type="hidden" >
                         <input id="idpregunta" name="idpregunta" value="<?php echo $idp ?>" type="hidden" >
                         <div class="col s12 m12"  align="center">
                            <label style="font-size:20px; color:#66ae43; font-weight: bold;">ACTUALIZAR DATOS</label>
                          </div>  
                    <div class="formcontent col s12 m12">
                      <div class="row">  
                           <div class="input-field col s12 m6">
                           <input id="idmod" name="idmod" type="text" style="color:#454545; font-weight: bold;" value="<?php echo $mo['nombre'].' - '.$mo['descripcion']; ?>" readonly class="validate">
                          <label for="idmodulo">MODULO</label>
                        </div>
                        <div class="input-field col s12 m6">
                           <input id="idasig" name="idasig" type="text" style="color:#454545; font-weight: bold;" value="<?php echo $do['nombre'] ?>" readonly class="validate">
                          <label for="idasig">ASIGNATURA</label>
                        </div>                 
                        <div class="input-field col s12 m3">
                           <strong>TIPO:</strong>
                        </div>
                        <div class="input-field col s12 m9">
                          <label>Tipo</label>
                          <select id="idtipo" name="idtipo">
                              <?php
                                foreach($dominio->mostrarTodo("tipo='TIPOTEST' and short in (1,2)") as $f)
                                {
                              ?>
                                  <option <?php if ($pr['idtipo']==$f['iddominio']) echo "selected";?> value="<?php echo $f['iddominio'];  ?>" ><?php echo $f['nombre'] ?></option>
                              <?php
                                }
                              ?>
                          </select>
                        </div>
                        <div class="input-field col s12 m3">
                           <strong>Pregunta:</strong>
                        </div>
                        <div class="input-field col s12 m9">
                           <textarea id="iddetalle" name="iddetalle" type="text" class="validate"><?php echo $pr['detalle']; ?></textarea>
                        </div>
                        <div class="input-field col s12 m3">
                           <strong>Opcion A:</strong>
                        </div>
                        <div class="input-field col s12 m9">
                           <input id="idopa" name="idopa" type="text" value="<?php echo $pr['a']; ?>" class="validate">
                          <label for="idopa">Opcion A</label>
                        </div>
                        <div class="input-field col s12 m3">
                           <strong>Opcion B:</strong>
                        </div>
                        <div class="input-field col s12 m9">
                           <input id="idopb" name="idopb" type="text" value="<?php echo $pr['b']; ?>" class="validate">
                          <label for="idopb">Opcion B</label>
                        </div>
                        <div class="input-field col s12 m3">
                           <strong>Opcion C:</strong>
                        </div>
                        <div class="input-field col s12 m9">
                           <input id="idopc" name="idopc" type="text" value="<?php echo $pr['c']; ?>" class="validate">
                          <label for="idopc">Opcion C</label>
                        </div>
                        <div class="input-field col s12 m3">
                           <strong>Respuesta:</strong>
                        </div>
                        <div class="input-field col s12 m9">
                          <label>Respuesta</label>
                          <select id="idrespuesta" name="idrespuesta">
                              <option value="A" <?php if ($pr['respuesta']=='A') echo "selected"; ?>>A</option>
                              <option value="B" <?php if ($pr['respuesta']=='B') echo "selected"; ?>>B</option>
                              <option value="C" <?php if ($pr['respuesta']=='C') echo "selected"; ?>>C</option>
                          </select>
                        </div>
                        <div class="col s12 m12">&nbsp;</div>
                         <div class="modal-footer" align="right">                      
                            <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardar();"><i class="fa fa-save"></i> ACTUALIZAR</button>                                                     
                        </div>
                        <div class="col s12 m12">&nbsp;</div>
                      </div>
                      
                    </div>
                     
                  </form>
                  </div>
                  <div class="col s12 m2">&nbsp;</div>
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
  
function guardar( )
{
 // $("#mensajesVacio").html("").slideUp(300);
  var flag=2;

  var tipo=$("#idtipo").val();
  var det=$("#iddetalle").val();
  //var ref=$("#idreferencia").val();
  var aa=$("#idopa").val();
  var bb=$("#idopb").val();
  var cc=$("#idopc").val();
  var res=$("#idrespuesta").val();


       if (det=='' || aa=='' || bb=='' || cc=='' || res=='' || tipo=='') 
        {
          flag = 1;
        }else{
          flag = 0;
        }

    

  if (flag==0) 
  {
         var str = $( "#idform" ).serialize();
              //alert(str);
             $.ajax({
                      url: "actualizarPre.php",
                      type: "POST",
                      data: str,
                    success: function(resp){
                       console.log(resp);
                        $('#idresultado').html(resp);
                       //alert(resp);
                      }
                    });
  }else{
        swal("Error", "Error: Verificar datos requeridos!!! :)", "error");
  }
               

}

   
    </script>

    <!-- <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>-->
   <!-- <script src="./materialize-stepper.min.js"></script> -->
  <!-- <script src="https://rawgit.com/Kinark/Materialize-stepper/master/materialize-stepper.min.js"></script>-->
</body>

</html>