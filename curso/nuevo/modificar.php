<?php
  $ruta="../../";
 include_once($ruta."class/curso.php");
  $curso=new curso;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/modulo.php");
  $modulo=new modulo;
  session_start();  
  extract($_GET);
  $idcurso=dcUrl($lblcode);
  $cu=$curso->mostrar($idcurso);
  $cu=array_shift($cu);

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
      $hd_titulo="Actualizar Curso";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    ?>
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
              <div class="row">
                <div class="col s12 m12">
                 <!-- <h4 class="header">Actualizar Curso</h4> -->
                  <a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>
                  <a id="btnGuardar" class="btn waves-effect waves-light indigo"><i class="fa fa-save"></i> Guardar Cambios</a>
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input id="idcurso" name="idcurso" type="hidden" value="<?php echo $lblcode; ?>">
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
                                   <option <?php if ($cu['idmodulo']==$f['idmodulo']) echo "selected";?> value="<?php echo $f['idmodulo'];  ?>" ><?php echo $f['nombre']." (".$f['descripcion'].")" ?></option>
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
                                  <option <?php if ($cu['iddocente']==$f['iddocente']) echo "selected";?> value="<?php echo $f['iddocente'];  ?>" ><?php echo $per['nombre']." ".$per['paterno']." ".$per['materno']; ?></option>
                                  <?php
                                }
                                ?>
                              </select>
                            </div>
                      </div>
                       <div class="row">
                        <div class="input-field col col s12 m6">
                          <input id="idfechaini" name="idfechaini" type="date" class="validate" value="<?php echo $cu['fechainicio'] ?>">
                          <label for="idfechaini">Fecha Inicio</label>
                        </div>
                        <div class="input-field col col s12 m6">
                          <input id="idfechafin" name="idfechafin" type="date" class="validate" value="<?php echo $cu['fechafin'] ?>">
                          <label for="idfechafin">Fecha Fin</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12 m6">
                          <input id="idhoraini" name="idhoraini" type="time" class="validate" value="<?php echo $cu['horainicio'] ?>">
                          <label for="idhoraini">Hora Inicio</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input id="idhorafin" name="idhorafin" type="time" class="validate" value="<?php echo $cu['horafin'] ?>">
                          <label for="idhorafin">Hora Fin</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <textarea id="iddesc" name="iddesc" class="materialize-textarea"><?php echo $cu['descripcion'] ?></textarea>
                          <label for="iddesc">Descripcion</label>
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
      $("#btnGuardar").click(function(){        
        if (validar()) {        
          $('#btnGuardar').attr("disabled",true);
          var str = $( "#idform" ).serialize();
          $.ajax({
            url: "actualizar.php",
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
    </script>
</body>

</html>