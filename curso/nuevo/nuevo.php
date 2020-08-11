<?php
  $ruta="../../";
 include_once($ruta."class/curso.php");
  $curso=new curso;
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
      $hd_titulo="NUEVO CURSO";
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
          $idmenu=1011;
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
                  <a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>                 
                     
                  <form class="col s12" id="idform" name="idform" action="return false" onsubmit="return false" method="POST">
                    <div class="row">
                             <div class="section grey lighten-5">
                                     <div class="container">
                                        <div class="row">

                                           <div class="col l6 m10 s12 offset-l3 offset-m1"><!-- col s12 m12    col l6 m10 s12 offset-l3 offset-m1-->
                                               <label class="light center-align blue-text" style="font-size:17px;"><i class="fa fa-tag"></i><?php echo $hd_titulo; ?></label>
                                              <div class="card">
                                                 <div class="card-content">

                                                    <ul data-method="GET" class="stepper horizontal"> <!-- stepper linear -->
                                                       <li class="step active">
                                                          <div class="step-title waves-effect waves-dark"><strong>Datos del Curso</strong> </div>
                                                          <div class="step-content">
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
                                                                             <strong>Horario:</strong>
                                                                          </div>
                                                                          <div class="input-field col s12 m9">
                                                                            <label>Horario curso</label>
                                                                            <select id="idhorario" name="idhorario">
                                                                              <option value="0">Seleccionar Horario...</option>
                                                                              <?php
                                                                              foreach($horario->mostrarTodo("") as $or)
                                                                              {
                                                                                ?>
                                                                                <option value="<?php echo $or['idhorario']; ?>"><?php echo $or['inicio']." a ".$or['fin'] ?></option>
                                                                                <?php
                                                                              }
                                                                              ?>
                                                                            </select>
                                                                          </div>
                                                                    </div>
                                                                    <?php $date=date('Y-m-d');
                                                                    
                                                                    ?>
                                                                     <div class="row">
                                                                      <div class="input-field col col s12 m6">
                                                                        <input type="hidden" id="idfechaini" name="idfechaini"  class="validate" value="<?php echo $date ?>">
                                                                        <label for="idfechaini"> </label>
                                                                      </div>
                                                                      <div class="input-field col col s12 m6">
                                                                        <input type="hidden" id="idfechafin" name="idfechafin"  class="validate" value="2022-10-10">
                                                                        <label for="idfechafin"> </label>
                                                                      </div>
                                                                    </div>
                                                                    <div class="row">
                                                                      <div class="input-field col s12">
                                                                        <textarea id="iddesc" name="iddesc" class="materialize-textarea"></textarea>
                                                                        <label for="iddesc">Descripcion</label>
                                                                      </div>
                                                                    </div>
                                                                    
                                                                    
                                                             <div class="step-actions">
                                                                <button id="btnsig" class="btn waves-effect light-blue darken-4 indigo" onclick="siguiente();" data-feedback="anyThing">Continue <i class="mdi-navigation-arrow-forward"></i></button><!--  -->
                                                               
                                                             </div>
                                                          </div>
                                                       </li>
                                                       <li class="step">
                                                          <div class="step-title waves-effect waves-dark"><strong>Asignar Docente</strong> </div>
                                                          <div class="step-content">
                                                                      <input type="hidden" name="idejecutivoInport" id="idejecutivoInport">
                                                                    <div class="row">
                                                                      <div class="input-field col s12 m3">
                                                                             <strong>Docente:</strong>
                                                                          </div>
                                                                      <div class="input-field col s12 m9">
                                                                        <input id="idnombreInport" name="idnombreInport" type="text" disabled class="validate" style="color:#191919;">
                                                                        <label for="iddoc">Docente</label>
                                                                         <button id="btngurdar" class="btn waves-effect waves-light light-green darken-4" onclick="seleccionar();"><i class="mdi-action-get-app"></i> Agregar</button>
                                                                      </div>
                                                                       
                                                                    </div>
                                                             <div class="step-actions">
                                                             <!--   <button class="waves-effect waves-dark btn next-step">CONTINUE</button> -->
                                                             <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardar();"><i class="fa fa-save"></i> GUARDAR</button>
                                                                <button class="btn waves-effect waves-light red darken-4 previous-step" onclick="atras();"><i class="mdi-content-reply"></i>VOLVER</button>

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
    function seleccionar()
    {
     
          if (validar()) 
        {               
           
          var modulo=document.getElementById('idmodulo').value;
          var horario=document.getElementById('idhorario').value;
          var fechaini=document.getElementById('idfechaini').value;
          var fechafin=document.getElementById('idfechafin').value;
          popup=window.open("selectDoc.php?idmodulo="+modulo+"&idhorario="+horario+"&idfechaini="+fechaini+"&idfechafin="+fechafin,"neo","width=800,height=600,enumerar=si;");
          popup.focus();
        }
        else{
          Materialize.toast('<span>Ingrese informción correcta en la pantalla anterior</span>', 2500);
        }
         
    }

    $(document).ready(function() {
      $('#example').DataTable({
        responsive: true
      });
      $('.btndel').tooltip({delay: 50});
    }); 
      $("#btnSave").click(function(){        
            if (validar()) 
            {  
              if (validar2()) 
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
                Materialize.toast('<span>Seleccione un docente</span>', 1500);
              }            
                   
            }
            else{
              Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
            }
      });
      function validar(){
        retorno=true;
        mod=$('#idmodulo').val();
        //doc=$('#iddocente').val();
        fechai=$('#idfechaini').val();
        fechaf=$('#idfechafin').val();
        hora=$('#idhorario').val();
        if(mod=="0" || fechai=="" || fechaf=="" || hora=="0"){
          retorno=false;
        }
        return retorno;
      }
      function validar2(){
        retorno2=true;
        doc=$('#idejecutivoInport').val();
        if(doc==""){
          retorno2=false;
        }
        return retorno2;
      }

            function anyThing() {
        setTimeout(function(){ $('.stepper').nextStep(); }, 1500);
      }

      $(function(){
         $('.stepper').activateStepper();
      });

  function siguiente()
  {
    if (validar()) 
    {         
      $('#btnsig').attr("disabled",true);      
      setTimeout(function(){ $('.stepper').nextStep(); }, 1500);
      $( ".next-step" );
    }
    else{
      Materialize.toast('<span>Datos Invalidos Revise Por Favor</span>', 1500);
    }
  }
  function atras()
  {
    $('#btnsig').attr("disabled",false);
  }


   $(document).ready(function(){
      $('.toc-wrapper').pushpin({ top: $('.toc-wrapper').offset().top, offset: 77 });
      $('.scrollspy').scrollSpy();
      $('.stepper').activateStepper();
   });

     $("#idhorario").change(function (){
            document.idform.idnombreInport.value = '';
            document.idform.idejecutivoInport.value = '';
       });
      $("#idfechaini").change(function (){
           document.idform.idnombreInport.value = '';
           document.idform.idejecutivoInport.value = '';
       });
       $("#idfechafin").change(function (){
           document.idform.idnombreInport.value = '';
           document.idform.idejecutivoInport.value = '';
       });
     
    </script>

    <!-- <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>-->
   <!-- <script src="./materialize-stepper.min.js"></script> -->
  <!-- <script src="https://rawgit.com/Kinark/Materialize-stepper/master/materialize-stepper.min.js"></script>-->
  

</body>

</html>