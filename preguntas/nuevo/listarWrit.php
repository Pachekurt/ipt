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

   $idm=dcUrl($idmcod);
   $ida=dcUrl($idacod);

  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $ID_sede=$us['idsede'];


   $mo=$modulo->mostrar($idm);
   $mo=array_shift($mo); 
   $do=$dominio->mostrar($ida);
   $do=array_shift($do); 
   $opcion=$do['nombre'];
 
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
                  <?php echo $idm.$ida ?>
                </div>
              </div>
            </div>
          </div>
           <a href="#modal1" class="btn waves-effect waves-light indigo modal-trigger"><i class="fa fa-plus-square"></i> Nuevo</a>
            <a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> 
           <div id="modal1" class="modal modal-fixed-footer">
                  <div class="modal-content">
                       <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                         <input id="idmodulo" name="idmodulo" value="<?php echo $idm ?>" type="hidden" >
                         <input id="idasignatura" name="idasignatura" value="<?php echo $ida ?>" type="hidden" >
                         <input id="idreferencia" name="idreferencia" value="<?php echo $idr ?>" type="hidden" >
                         <div class="col s12 m12"  align="center">
                            <label style="font-size:20px; color:#66ae43; font-weight: bold;">NUEVA PREGUNTA - WRITING</label>
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
                                foreach($dominio->mostrarTodo("tipo='TIPOTEST' and short in (4)") as $f)
                                {
                              ?>
                                <option value="<?php echo $f['iddominio']; ?>" ><?php echo $f['nombre'];  ?></option>
                              <?php
                                }
                              ?>
                          </select>
                        </div>
                        <div class="input-field col s12 m3">
                           <strong>Pregunta:</strong>
                        </div>
                        <div class="input-field col s12 m9">
                           <textarea id="iddetalle" name="iddetalle" type="text" class="validate" style="height:150px;"></textarea>
                        </div>
                       
                      </div>
                      
                    </div>
                     
                  </form>
                   
                  </div>
                     <div class="modal-footer" align="right">                      
                       <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardar();"><i class="fa fa-save"></i> GUARDAR</button>
                       <button class="btn waves-effect waves-light red modal-close" ><i class="mdi-content-reply"></i> Cancelar</button>                                                        
                        </div>
                </div>
             
               </div>
             </div>

          <div class="container">
            <div class="section">
              <div class="row">
              <div id="table-datatables">
            
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                       <th>Pregunta</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Pregunta</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      $fechaactual=date('Y-m-d'); 
                      foreach($pregunta->mostrarTodo("idmodulo=".$idm." and idasignatura=".$ida) as $f)
                      {
                        $idpcod=ecUrl($f['idpregunta']);
                        $doA=$dominio->mostrar($f['idtipo']);
                        $doA=array_shift($doA);
                      ?>
                      <tr>
                       <td><?php echo $f['detalle'] ?></td>
                        <td><?php echo $doA['nombre'] ?></td>
                        <td>
                         <a href="modificarWrit.php?idmcod=<?php echo $idmcod ?>&idacod=<?php echo $idacod ?>&idpcod=<?php echo $idpcod ?>" class="btn-jh waves-effect waves-light blue"><i class="mdi-action-assignment"></i> Editar</a> 
                          
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
  var idm = $("#idmodulo").val();
  var ida=$("#idasignatura").val();
  //alert(opcion);

  var tipo=$("#idtipo").val();
  var det=$("#iddetalle").val();


       if (det=='' || tipo=='') 
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
                      url: "guardarPreWrit.php",
                      type: "POST",
                      data: str,
                    success: function(resp){
                       console.log(resp);
                        $('#idresultado').html(resp);
                       
                      }
                    });
  }else{
        swal("Error", "Error: Verificar datos requeridos!!! :)", "error");
  }
               

}
    </script>

   
</body>

</html>