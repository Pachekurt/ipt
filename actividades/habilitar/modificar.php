<?php
  $ruta="../../";
     include_once($ruta."class/actividades.php");
  $actividades=new actividades;
    include_once($ruta."class/usuario.php");
  $usuario=new usuario;
   include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
    include_once($ruta."class/actividadhabil.php");
  $actividadhabil=new actividadhabil;
  session_start(); 
 extract($_GET);
   $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede'];

  $idactividadhabil=dcUrl($idahcode);
  $ah=$actividadhabil->mostrar($idactividadhabil);
  $ah=array_shift($ah);

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
          $idmenu=1020;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                 <h4 class="header"><a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>
                  
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
                    <input id="idactividadhabil" name="idactividadhabil" type="hidden" readonly value="<?php echo $idactividadhabil ?>" class="validate">
                   
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
                            foreach($actividades->mostrarTodo("idtipoclase=4") as $f)
                            {
                              ?>
                            
                               <option <?php if ($ah['idactividades']==$f['idactividades']) echo "selected";?> value="<?php echo $f['idactividades'];  ?>" ><?php echo $f['nombre'] ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12 m6">
                           <label>Docente</label>
                          <select id="idejecutivo" name="idejecutivo">
                            <?php
                            foreach($vejecutivo->mostrarTodo("idarea=122 and idsede=".$idsede) as $f)
                            {
                              ?>
                               <option <?php if ($ah['idejecutivo']==$f['idvejecutivo']) echo "selected";?> value="<?php echo $f['idvejecutivo'];  ?>" ><?php echo $f['nombre']." ".$f['paterno'] ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="input-field col s12 m6">
                           <input id="idfecha" name="idfecha" type="date" class="validate" value="<?php echo $ah['fecha']; ?>">
                          <label for="idfecha">Fecha actividad</label>
                        </div>
                        <div class="input-field col s12 m6">
                           <label>Duración</label>
                              <select id="idduracion" name="idduracion">
                                <option value="1" <?php if ($ah['duracion']=='1') echo "selected"; ?>>1 Hr</option>
                                <option value="2" <?php if ($ah['duracion']=='2') echo "selected"; ?>>2 Hrs.</option>
                                <option value="3" <?php if ($ah['duracion']=='3') echo "selected"; ?>>3 Hrs.</option>
                                <option value="4" <?php if ($ah['duracion']=='4') echo "selected"; ?>>4 Hrs.</option>
                                <option value="5" <?php if ($ah['duracion']=='5') echo "selected"; ?>>5 Hrs.</option>                               
                              </select>
                        </div>
                        <div class="input-field col s12 m6">
                            <label>Hora inicio</label>
                              <select id="idhorainicio" name="idhorainicio">
                               <!-- <option value="0">Seleccionar..</option> -->
                                <option value="7" <?php if ($ah['horainicio']=='7') echo "selected"; ?>>07:00</option>
                                <option value="8" <?php if ($ah['horainicio']=='8') echo "selected"; ?>>08:00</option>
                                <option value="9" <?php if ($ah['horainicio']=='9') echo "selected"; ?>>09:00</option>
                                <option value="10" <?php if ($ah['horainicio']=='10') echo "selected"; ?>>10:00</option>
                                <option value="11" <?php if ($ah['horainicio']=='11') echo "selected"; ?>>11:00</option>
                                <option value="12" <?php if ($ah['horainicio']=='12') echo "selected"; ?>>12:00</option>
                                <option value="13" <?php if ($ah['horainicio']=='13') echo "selected"; ?>>13:00</option>  
                                <option value="14" <?php if ($ah['horainicio']=='14') echo "selected"; ?>>14:00</option>  
                                <option value="15" <?php if ($ah['horainicio']=='15') echo "selected"; ?>>15:00</option>
                                <option value="16" <?php if ($ah['horainicio']=='16') echo "selected"; ?>>16:00</option>  
                                <option value="17" <?php if ($ah['horainicio']=='17') echo "selected"; ?>>17:00</option>  
                                <option value="18" <?php if ($ah['horainicio']=='18') echo "selected"; ?>>18:00</option>  
                                <option value="19" <?php if ($ah['horainicio']=='19') echo "selected"; ?>>19:00</option>  
                                <option value="20" <?php if ($ah['horainicio']=='20') echo "selected"; ?>>20:00</option>  
                                <option value="21" <?php if ($ah['horainicio']=='21') echo "selected"; ?>>21:00</option>                                   
                              </select>
                         
                        </div>
                         
                      </div>
                      <div class="col s12 m12">&nbsp;</div>
                       <div class="modal-footer" align="right"> 
                        <button class="btn waves-effect waves-light red darken-4 previous-step" onclick="atras();"><i class="mdi-content-reply"></i>CANCELAR</button>                       
                       <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardar();"><i class="fa fa-save"></i> ACTUALIZAR</button>
                                                                               
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
                      url: "actualizar.php",
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