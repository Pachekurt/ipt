<?php
  $ruta="../../";
     include_once($ruta."class/actividades.php");
  $actividades=new actividades;
    include_once($ruta."class/usuario.php");
  $usuario=new usuario;
   include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  session_start(); 

   $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede'];

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
          $idmenu=1023;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                 <h4 class="header"><a href="../" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>
                  
                 </h4>
                
                 <!--  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                     <h1 align="center">Nuevo Curso</h1> -->&nbsp;
                  
                </div>
              </div>   
            </div>
          </div>
           <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input id="idcontrato" name="idcontrato" type="hidden" readonly value="<?php echo $idcontrato ?>" class="validate">
                   
                     <div class="col s12 m2">
                      &nbsp;
                      </div>
                    <div class="formcontent col s12 m8">
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
                            <option value="0">Seleccionar Actividad...</option>
                            <?php
                            foreach($actividades->mostrarTodo("") as $f)
                            {
                              ?>
                              <option value="<?php echo $f['idactividades']; ?>"><?php echo $f['nombre']." (".$f['descripcion'].")" ?></option>
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
                            foreach($vejecutivo->mostrarTodo("idarea=122 and idsede=".$idsede) as $f)
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
                          <label for="idfecha">Fecha Inicio</label>
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
                        <button class="btn waves-effect waves-light red darken-4 previous-step" onclick="atras();"><i class="mdi-content-reply"></i>CANCELAR</button>                       
                       <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardar();"><i class="fa fa-save"></i> GUARDAR</button>
                                                                               
                        </div>
                        <div class="col s12 m12">&nbsp;</div>
                    </div>
                    <div class="col s12 m2"> &nbsp;</div>
                  </form>
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
              } else{
                Materialize.toast('<span>Complete os daots requeridos</span>', 1500);
              }            
                   
          
      });
      function validar(){
        retorno=true;
        act=$('#idactividad').val();
        doc=$('#idejecutivo').val();
        fechai=$('#idfecha').val();
        dur=$('#idduracion').val();
        hora=$('#idhorainicio').val();
        if(act=="0" || doc=="0" || fechai=="" || dur=="0" || hora=="0"){
          retorno=false;
        }
        return retorno;
      }



    </script>
  

</body>

</html>