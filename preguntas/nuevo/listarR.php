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
      $hd_titulo="Lista de referencias de ".$do['nombre'];
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
           <a href="#modal1" class="btn waves-effect waves-light cyan darken-2 indigo modal-trigger"><i class="mdi-action-list"></i> Nuevo referencia</a>
            <a href="index.php" class="btn waves-effect waves-light red"><i class="fa fa-reply"></i> Atras</a> 
           <div id="modal1" class="modal modal-fixed-footer">
                  <div class="modal-content">
                       <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                         <input id="idmodulo" name="idmodulo" value="<?php echo $idm ?>" type="hidden" >
                         <input id="idasignatura" name="idasignatura" value="<?php echo $ida ?>" type="hidden" >
                         <input id="idmcod" name="idmcod" value="<?php echo $idmcod ?>" type="hidden" >
                         <input id="idacod" name="idacod" value="<?php echo $idacod ?>" type="hidden" >
                         <div class="col s12 m12"  align="center">
                            <label style="font-size:20px; color:#66ae43; font-weight: bold;">Nuevo referencia  (LISTENING)</label>
                          
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
                    
                    </div>
                                                      
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
                        $idrcod=ecUrl($f['idreferencia']);
                      ?>
                      <tr <?php if ($f['duracion']=='00:00:00') { ?> style="background-color:#ffebeb;color: red" <?php } ?> >
                        <td><?php echo $f['nombre'] ?></td>
                        <td><?php echo $f['descripcion'] ?></td>
                        <td><?php echo $f['duracion'] ?>
                        </td>
                        <td>
                     
                      <button class="btn-jh waves-effect waves-light  cyan darken-2 " onclick="selreferencia('<?php echo $idrcod ?>');"><i class="mdi-content-add-circle-outline"></i> Preguntas</button>  
                         <a href="#modal2" class="btn-jh waves-effect blue indigo modal-trigger" onclick="cargardatos('<?php echo $f['idreferencia']; ?>');"><i class="mdi-content-create"></i> Editar</a> 
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

          <div id="modal2" class="modal modal-fixed-footer">
                  <div class="modal-content">
                       <form class="col s12" id="idform2" action="return false" onsubmit="return false" method="POST">
                         <div class="col s12 m12"  align="center">
                            <label style="font-size:20px; color:#66ae43; font-weight: bold;">Actualizar datos de referencia  (LISTENING)</label>
                          
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
                           <input id="idnombre2" name="idnombre2" type="text" class="validate">
                          <label for="idnombre2">Nombre</label>
                        </div>                 
                        
                        <div class="input-field col s12 m3">
                           <strong>Detalle:</strong>
                        </div>
                        <div class="input-field col s12 m9">
                           <textarea id="iddetalle2" name="iddetalle2" type="text" class="validate"></textarea>
                        </div>
                       
                      </div>
                    
                    </div>
                      <input id="idreferenciaSel" name="idreferenciaSel" type="hidden">                                
                  </form>
                   
                  </div>
                     <div class="modal-footer" align="right">                      
                       <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="actualizar();"><i class="fa fa-save"></i> ACTUALIZAR</button>
                       <button class="btn waves-effect waves-light red modal-close" ><i class="mdi-content-reply"></i> Cancelar</button>                                                        
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
   

      function selreferencia(idrcod)
   {
    idmcod='<?php echo $idmcod; ?>';
    idacod='<?php echo $idacod; ?>';
    
         location.href="listarL.php?idmcod="+idmcod+"&idacod="+idacod+"&idrcod="+idrcod;         
     
    
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
   

    </script>
  <script>
   
   function guardar()
{
                 
    if (validar()) 
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
                        if (resp==2) 
                          {
                            swal("Error", "Error: Ya existe el nombre de la referencia, verifique o consulte con de sistemas)", "error");
                          }
                      }
                    });
         
      } else{
        swal("Error", "Error: Ingrese datos validos", "error");
      }
}
 function validar(){
        retorno=true;
        nom=$('#idnombre').val();
        det=$('#iddetalle').val();
        if(nom=="" || det=="")
        {
          retorno=false;
        }
        return retorno;
      }
   function actualizar()
{
                 
    if (validar2()) 
    {  
       var str = $( "#idform2" ).serialize();
                   // alert(str);
                    $.ajax({
                      url: "actualizarreferencia.php",
                      type: "POST",
                      data: str,
                      success: function(resp){
                        console.log(resp);
                        $('#idresultado').html(resp);
                        
                      }
                    });
         
      } else{
        swal("Error", "Error: Ingrese datos validos", "error");
      }
}
 function validar2(){
        retorno=true;
        nom=$('#idnombre2').val();
        det=$('#iddetalle2').val();
        if(nom=="" || det=="")
        {
          retorno=false;
        }
        return retorno;
      }

function cargardatos(idr)
     {
        
        $('#idreferenciaSel').val(idr);
        $.ajax({
            async: true,
            url: "cargarReferencia.php?idr="+idr,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#idreferenciaSel").val(json.idreferenciaInport);
                $("#idnombre2").val(json.nombreRE);
                $("#iddetalle2").val(json.descripcionRE);             
            }
            
          });
     }
    </script>
     
</body>

</html>