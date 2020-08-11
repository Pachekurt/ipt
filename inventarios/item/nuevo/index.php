<?php
  $ruta="../../../";
 include_once($ruta."class/invcategoria.php");
  $invcategoria=new invcategoria;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/modulo.php");
  $modulo=new modulo;
   include_once($ruta."class/horario.php");
  $horario=new horario;
  session_start(); 
  //if (!isset($lblcode)) {
   // $query="";
   // $tituloSede="Contratos en todas las Sedes";
 // }
 // else{
  //  $query=" and idsede=".dcUrl($lblcode);
  //  $dSelSede=$admmodulo->mostrar(dcUrl($lblcode));
  //  $dSelSede=array_shift($dSelSede);
  //  $tituloSede="Contratos en Sede ".$dSelSede['nombre'];
 // }


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="NUEVO ITEM";
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
          $idmenu=91;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                 <!--  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                     <h1 align="center">Nuevo Curso</h1> -->&nbsp;
                  
                </div>
              </div>   
            </div>
          </div>
          <div class="container">
              <div class="row">
                <div class="col s12 m12">
                 <!-- <h4 class="header">Actualizar Curso</h4> -->
                  <a href="../" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>                 
                  <form class="col s12" id="idform" name="idform" action="return false" onsubmit="return false" method="POST">
                    <div class="row">
                      <div class="section grey lighten-5">
                        <div class="container">
                          <div class="row">
                            <div class="col l6 m10 s12 offset-l3 offset-m1">
                              <div class="card">
                                <div class="card-content">
                                  <ul data-method="GET" class="stepper horizontal"> <!-- stepper linear -->
                                    <li class="step active">
                                      <div class="titulo waves-effect waves-dark"><i class="fa fa-plus"></i> <strong>Datos del Item</strong> </div>
                                      <div class="step-content">
                                        <div class="row">
                                          <div class="input-field col s12 m12 l12">
                                            <label>Categoría</label>
                                            <select id="idcategoria" name="idcategoria">
                                              <option value="0">Seleccionar Categoría...</option>
                                              <?php
                                              foreach($invcategoria->mostrarTodo("") as $f)
                                              {
                                                ?>
                                                  <option value="<?php echo $f['idinvcategoria']; ?>"><?php echo $f['nombre']; ?></option>
                                                <?php
                                              }
                                              ?>
                                            </select>
                                          </div>
                                          <div class="input-field col col s12 m12">
                                            <input id="idnombre" name="idnombre" type="text" class="validate">
                                            <label for="idnombre">Nombre</label>
                                          </div>
                                          <div class="input-field col col s12 m12">
                                            <input id="idprecio" name="idprecio" type="number" class="validate">
                                            <label for="idprecio">Precio</label>
                                          </div>
                                          <div class="input-field col s12">
                                            <textarea id="iddesc" name="iddesc" class="materialize-textarea"></textarea>
                                            <label for="iddesc">Descripcion</label>
                                          </div>
                                        </div>
                                        <div class="step-actions">
                                          <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo"> <i class="fa fa-save"></i> Guardar Item </button><!--  -->
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
                  </form>
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
        swal({   
          title: "Estas Seguro?",   
          text: "Esta Seguro de Crear item?",   
          type: "warning",   
          showCancelButton: true,   
          closeOnConfirm: false,   
          showLoaderOnConfirm: true,
        }, 
        function(){
          if (validar()) {
            var str = $( "#idform" ).serialize();
            $.ajax({
              url: "guardar.php",
              type: "POST",
              data: str,
              success: function(resp){
                setTimeout(function(){     
                  console.log(resp);
                  $('#idresultado').html(resp);
                }, 1000); 
              }
            });
          }
          else{
            Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
          }
        });
      });
      function validar(){
        retorno=true;
        nombre=$('#idmodulo').val();
        precio=$('#idfechaini').val();
        if(nombre=="" || precio=="0"){
          retorno=false;
        }
        return retorno;
      }
      function anyThing() {
        setTimeout(function(){ $('.stepper').nextStep(); }, 1500);
      }

      $(function(){
         $('.stepper').activateStepper();
      });


   $(document).ready(function(){
      $('.scrollspy').scrollSpy();
      $('.stepper').activateStepper();
   });  
    </script>
</body>

</html>