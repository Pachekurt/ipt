<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/curso.php");
  $curso=new curso;
   include_once($ruta."class/docente.php");
  $docente=new docente;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/modulo.php");
  $modulo=new modulo;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
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
      $hd_titulo="Administrar Curso";
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
          $idmenu=2;
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
              <div id="table-datatables">
             <!-- <a href="../inicio" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> -->
              <a href="#modal1" class="btn waves-effect waves-light indigo modal-trigger"><i class="fa fa-plus-square"></i> Nuevo Curso</a>

                <div id="modal1" class="modal">
                  <div class="modal-content">
                  <h1 align="center">Nuevo Curso</h1>
                    <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                      <div class="row">
                            <div class="input-field col s12 m3">
                               <strong>Modulo:</strong>
                            </div>
                            <div class="input-field col s12 m9">
                              <label>Modulo</label>
                              <select id="idmodulo" name="idmodulo">
                                <option value="0">Seleccionar Modulo...</option>
                                <?php
                                foreach($modulo->mostrarTodo("") as $f)
                                {
                                  ?>
                                  <option value="<?php echo $f['idmodulo']; ?>"><?php echo $f['nombre']." (".$f['descripcion'].")" ?></option>
                                  <?php
                                }
                                ?>
                              </select>
                            </div>
                      </div>
                      <div class="row">
                         <div class="input-field col s12 m3">
                               <strong>Docente:</strong>
                            </div>
                            <div class="input-field col s12 m9">
                              <label>Docente</label>
                              <select id="iddocente" name="iddocente">
                                <option value="0">Seleccionar Docente...</option>
                                <?php
                                foreach($docente->mostrarTodo("") as $f)
                                {
                                  $per=$persona->mostrarTodo("idpersona=".$f['idpersona']);
                                  $per=array_shift($per);
                                  ?>
                                  <option value="<?php echo $f['iddocente']; ?>"><?php echo $per['nombre']." ".$per['paterno']." ".$per['materno'] ?></option>
                                  <?php
                                }
                                ?>
                              </select>
                            </div>
                      </div>
                       <div class="row">
                        <div class="input-field col col s12 m6">
                          <input id="idfechaini" name="idfechaini" type="date" class="validate">
                          <label for="idfechaini">Fecha Inicio</label>
                        </div>
                        <div class="input-field col col s12 m6">
                          <input id="idfechafin" name="idfechafin" type="date" class="validate">
                          <label for="idfechafin">Fecha Fin</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12 m6">
                          <input id="idhoraini" name="idhoraini" type="time" class="validate">
                          <label for="idhoraini">Hora Inicio</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input id="idhorafin" name="idhorafin" type="time" class="validate">
                          <label for="idhorafin">Hora Fin</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <textarea id="iddesc" name="iddesc" class="materialize-textarea"></textarea>
                          <label for="iddesc">Descripcion</label>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo"><i class="fa fa-save"></i> GUARDAR</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
                  </div>
                </div>
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Modulo</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Modulo</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      foreach($curso->mostrarTodo("idsede=".$ID_sede) as $f)
                      {
                        $idcurso=ecUrl($f['idcurso']);
                        $mod=$modulo->mostrarTodo("idmodulo=".$f['idmodulo']);
                        $mod=array_shift($mod);
                      ?>
                      <tr>
                        <td><?php echo $mod['nombre'] ?></td>
                        <td><?php echo $f['horainicio'] ?></td>
                        <td><?php echo $f['horafin'] ?></td>
                        
                        <td><?php echo $f['fechainicio'] ?></td>
                        <td><?php echo $f['fechafin'] ?></td>
                        <td><?php echo $mod['descripcion'] ?></td>
                        <td>
                          <a href="modificar.php?lblcode=<?php echo $idcurso ?>" class="btn-jh waves-effect waves-light blue"><i class="mdi-action-assignment"></i> Editar</a>
                          <button id="btndel"  onclick="Eliminar('<?php echo $f["idcurso"] ;?>');" data-tooltip="Eliminar curso: <?php echo $f['descripcion'] ?>" class="btndel btn-jh waves-effect waves-light red"> <i class="fa fa-trash"></i> </button>
                        </td>
                      </tr>
                      <?php
                        }
                      ?>
                    </tbody>
              </table>
              </div>

           

 <div class="section grey lighten-5">
   <div class="container">
      <div class="row">
         <div class="col s12 m12"><!--col l6 m10 s12 offset-l3 offset-m1 -->
            <h3 class="light center-align blue-text">Sign up form</h3>
            <div class="card">
               <div class="card-content">

                  <ul data-method="GET" class="stepper horizontal"> <!-- stepper linear -->
                     <li class="step active">
                        <div class="step-title waves-effect waves-dark">E-mail</div>
                        <div class="step-content">
                           <div class="row">
                              <div class="input-field col s6">
                                 <input id="email" name="email" type="email" class="validate" required>
                                 <label for="first_name">Your e-mail</label>
                              </div>
                           </div>
                           <div class="step-actions">
                              <button class="waves-effect waves-dark btn next-step" data-feedback="anyThing">Continue</button>
                           </div>
                        </div>
                     </li>
                     <li class="step">
                        <div class="step-title waves-effect waves-dark">Step 2</div>
                        <div class="step-content">
                           <div class="row">
                              <div class="input-field col s6">
                                 <input id="password" name="password" type="password" class="validate" required>
                                 <label for="password">Your password</label>
                              </div>
                           </div>
                           <div class="step-actions">
                              <button class="waves-effect waves-dark btn next-step">CONTINUE</button>
                              <button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
                           </div>
                        </div>
                     </li>
                     <li class="step">
                        <div class="step-title waves-effect waves-dark">Callback</div>
                        <div class="step-content">
                          INGRESA OK
                           <div class="step-actions">
                              <button class="waves-effect waves-dark btn next-step" data-feedback="anyThing">ENDLESS CALLBACK!</button>
                           </div>
                        </div>
                     </li>
                  </ul>

               </div>
            </div>
         </div>
      </div>
   </div>
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
        responsive: true
      });
      $('.btndel').tooltip({delay: 50});
    }); 
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

      function anyThing() {
        setTimeout(function(){ $('.stepper').nextStep(); }, 1500);
      }

      $(function(){
         $('.stepper').activateStepper();
      });




   $(document).ready(function(){
      $('.toc-wrapper').pushpin({ top: $('.toc-wrapper').offset().top, offset: 77 });
      $('.scrollspy').scrollSpy();
      $('.stepper').activateStepper();
   });

    </script>

    <!-- <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>-->
   <!-- <script src="./materialize-stepper.min.js"></script> -->
  <!-- <script src="https://rawgit.com/Kinark/Materialize-stepper/master/materialize-stepper.min.js"></script>-->
</body>

</html>