<?php
  $ruta="../../";

       include_once($ruta."class/actividades.php");
  $actividades=new actividades;
    include_once($ruta."class/usuario.php");
  $usuario=new usuario;
   include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/vactividadhabil.php");
  $vactividadhabil=new vactividadhabil;
  session_start();
  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $ID_sede=$us['idsede']; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Administrar Habilitación de actividades";
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
          $idmenu=1020;
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
           <a href="#modal1" class="btn waves-effect waves-light indigo modal-trigger"><i class="fa fa-plus-square"></i> Habilitar actividad</a>
           <div id="modal1" class="modal">
                  <div class="modal-content">
                       <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input id="idcontrato" name="idcontrato" type="hidden" readonly value="<?php echo $idcontrato ?>" class="validate">
                   
                     <div class="col s12 m2">
                      &nbsp;
                      </div>
                    <div class="formcontent col s12 m8 modal-fixed">
                    <div class="input-field col s12 m12 card green lighten-5" style="text-align:center;">
                            <div class="card-content green-text" style="font-size:20px;">
                              <p>HABILITAR ACTIVIDAD</p>
                            </div>
                        </div>
                      <div class="row">                        
                        <div class="input-field col s12 m3">
                           <strong>Actividad:</strong>
                        </div>
                        <div class="input-field col s12 m9">
                          <label>Actividades</label>
                          <select id="idactividad" name="idactividad">
                            <option value="">Seleccionar Actividad...</option>
                            <?php
                            foreach($actividades->mostrarTodo("idtipoclase=4") as $f)
                            {
                              ?>
                              <option value="<?php echo $f['idactividades']; ?>"><?php echo $f['nombre'] ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12 m6">
                           <label>Docente</label>
                          <select id="idejecutivo" name="idejecutivo">
                            <option value="0">Seleccionar...</option>
                            <?php
                            foreach($vejecutivo->mostrarTodo("idarea=122 and idsede=".$ID_sede) as $f)
                            {
                              ?>
                              <option value="<?php echo $f['idvejecutivo']; ?>"><?php echo $f['nombre']." ".$f['paterno'] ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12 m6">
                           <input id="idfecha" name="idfecha" type="date" class="validate">
                          <label for="idfecha">Fecha actividad</label>
                        </div>
                        <div class="input-field col s12 m6">
                           <label>Duración</label>
                              <select id="idduracion" name="idduracion">
                                <option value="0">Seleccionar..</option>
                                <option value="1">1 Hr</option>
                                <option value="2">2 Hrs.</option>
                                <option value="3">3 Hrs.</option>
                                <option value="4">4 Hrs.</option>
                                <option value="5">5 Hrs.</option>                               
                              </select>
                        </div>
                        <div class="input-field col s12 m6">
                            <label>Hora inicio</label>
                              <select id="idhorainicio" name="idhorainicio">
                                <option value="0">Seleccionar..</option>
                                <option value="7">07:00</option>
                                <option value="8">08:00</option>
                                <option value="9">09:00</option>
                                <option value="10">10:00</option>
                                <option value="11">11:00</option>
                                <option value="12">12:00</option>
                                <option value="13">13:00</option>  
                                <option value="14">14:00</option>  
                                <option value="15">15:00</option>
                                <option value="16">16:00</option>  
                                <option value="17">17:00</option>  
                                <option value="18">18:00</option>  
                                <option value="19">19:00</option>  
                                <option value="20">20:00</option>  
                                <option value="21">21:00</option>                                   
                              </select>
                         
                        </div>
                         
                      </div>
                      <div class="col s12 m12">&nbsp;</div>
                       <div class="modal-footer" align="right">                      
                       <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardar();"><i class="fa fa-save"></i> GUARDAR</button>
                       <button class="btn waves-effect waves-light red modal-close" ><i class="mdi-content-reply"></i> Cancelar</button>                                                        
                        </div>
                        <div class="col s12 m12">&nbsp;</div>
                    </div>
                    <div class="col s12 m2"> &nbsp;</div>
                  </form>
                  </div>
                </div>
          <div class="container">
            <div class="section">
            
            
              <div id="table-datatables">
             <!-- <a href="../inicio" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> -->
             
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                       <th>Actividad</th>
                        <th>Docente</th>
                        <th>Fecha</th>
                        <th>Duracion</th>
                        <th>Hora inicio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Actividad</th>
                        <th>Docente</th>
                        <th>Fecha</th>
                        <th>Duracion</th>
                        <th>Horario</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      $fechaactual=date('Y-m-d'); 
                      foreach($vactividadhabil->mostrarTodo("idsede=".$ID_sede." and fecha>='$fechaactual'") as $f)
                      {
                        $idah=ecUrl($f['idvactividadhabil']);
                      ?>
                      <tr>
                       <td><?php echo $f['actividad'] ?></td>
                        <td><?php echo $f['nombre'].' '.$f['paterno'].' '.$f['materno']  ?></td>
                        <td><?php echo $f['fecha'] ?></td>
                        
                        <td><?php echo $f['duracion'].' Hrs' ?></td>
                        <?php 
                          $horafin=$f['horainicio'] + $f['duracion'];
                         ?>
                        <td><?php echo $f['horainicio'].':00 hasta '.$horafin.':00'  ?></td>
                        <td>
                      <!--  <button class="btn-jh waves-effect waves-light blue"><i class="mdi-action-assignment"></i> Modificar</button> -->
                         <a href="modificar.php?idahcode=<?php echo $idah ?>" class="btn-jh waves-effect waves-light blue"><i class="mdi-action-assignment"></i> Editar</a> 
                          <button id="btndel"  onclick="Eliminarrr('<?php echo $f["idvcurso"] ;?>');" data-tooltip="Eliminar curso: <?php echo $f['descripcion'] ?>" class="btndel btn-jh waves-effect waves-light red"> <i class="fa fa-trash"></i> </button>
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
       
    $(document).ready(function() {
      $('#example').DataTable({
        dom: 'Bfrtip',
        "order": [[ 2, "asc" ]],
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

    <!-- <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>-->
   <!-- <script src="./materialize-stepper.min.js"></script> -->
  <!-- <script src="https://rawgit.com/Kinark/Materialize-stepper/master/materialize-stepper.min.js"></script>-->
</body>

</html>