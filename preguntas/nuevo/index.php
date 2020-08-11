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

    include_once($ruta."class/modulo.php");
  $modulo=new modulo;
    include_once($ruta."class/pregunta.php");
  $pregunta=new pregunta;
   include_once($ruta."class/dominio.php");
  $dominio=new dominio;
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
      $hd_titulo="Administrar Nuevas preguntas";
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

 .selectMod:hover{      
      cursor: pointer;
        transform:scale(1.1);
            -ms-transform:scale(1.1); // IE 9 
            -moz-transform:scale(1.1); // Firefox 
            -webkit-transform:scale(1.1); // Safari and Chrome 
            -o-transform:scale(1.1); // Opera
    } 
.selectMod:hover{
   opacity: 0.5;
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
          <!-- <a href="#modal1" class="btn waves-effect waves-light indigo modal-trigger"><i class="fa fa-plus-square"></i> Habilitar actividad</a> -->
           <div id="modal1" class="modal">
                  <div class="modal-content">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input id="idmoduloIMP" name="idmoduloIMP" type="hidden" readonly class="validate">
                   
                    <div class="formcontent col s12 m12">
                     <div class="row">
                            <?php 
                                  foreach($dominio->mostrarTodo("tipo='ASIGNATURA' and codigo!='spea'") as $f)
                                  {
                                    $ida=ecUrl($f['iddominio']);
                                    switch ($f['codigo']) {
                                        case 'GRAM':
                                         $ico='mdi-av-my-library-books';
                                        break;
                                        case 'LISTE':
                                        $ico='mdi-av-my-library-music';
                                        break;
                                        case 'READ':
                                        $ico='mdi-maps-local-library';
                                        break;
                                        case 'WRIT':
                                         $ico='mdi-editor-border-color';
                                        break;                                
                                    }
                                     ?>
                                      <div class="col s12 m12 l6" onclick="selasignatura('<?php echo $ida ?>','<?php echo $f['iddominio']; ?>');">
                                                <div class="card  selectMod" >
                                                    <div class="card-content  cyan darken-4 white-text " align="center" > <!-- /*darken-2*/ -->
                                                        <h4 class="card-stats-number"><i class="<?php echo $ico ?>"></i> <?php echo $f['nombre']; ?></h4>                                                        
                                                    </div>
                                                </div>
                                      </div>
                                    <?php
                                  }
                             ?>
                             <div class="col s12 m12" align="right">
                               <button class="btn waves-effect waves-light red modal-close" ><i class="mdi-content-reply"></i> Cancelar</button>
                             </div>
                                     
                      </div>
                      <!--   <div class="col s12 m12">&nbsp;</div>
                       <div class="modal-footer" align="right">                      
                    <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardar();"><i class="fa fa-save"></i> GUARDAR</button>
                       <button class="btn waves-effect waves-light red modal-close" ><i class="mdi-content-reply"></i> Cancelar</button>                                                       
                        </div>
                        <div class="col s12 m12">&nbsp;</div>--> 
                    </div>
                  </form>
                  </div>
                </div>
          <div class="container">
            <div class="section">
            <div class="row">
            <?php 
                  foreach($modulo->mostrarTodo("") as $f)
                  {
                    $idm=ecUrl($f['idmodulo']);
                      $cantidad=$pregunta->mostrarTodo("idmodulo=".$f['idmodulo']);
                     ?>
                      <div class="col s12 m6 l2 modal-trigger" href="#modal1" onclick="opcion('<?php echo $idm; ?>');">
                                <div class="card  selectMod" >
                                    <div class="card-content blue-grey darken-2 white-text " align="center" > <!-- /*darken-2*/ -->
                                        <p class="card-stats-title"><i class="mdi-action-description"></i> <?php echo $f['descripcion']; ?></p>
                                        <h4 class="card-stats-number"><?php echo $f['nombre']; ?></h4>
                                        <p class="card-stats-compare"><i class="mdi-editor-format-list-numbered"></i> <?php echo count($cantidad) ?> <span class="blue-grey-text text-lighten-5"> Total en preguntas</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                    <?php
                  }
             ?>
                    
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
   
   function opcion(id)
   {
    $('#idmoduloIMP').val(id);
   }
   function selasignatura(ida,id)
   {
    idm=$('#idmoduloIMP').val();
    
       switch (id) {
          case '39':
           location.href="listar.php?idmcod="+idm+"&idacod="+ida;
          break;
          case '40':
         location.href="listarR.php?idmcod="+idm+"&idacod="+ida;
          break;
          case '41':
          location.href="listarRE.php?idmcod="+idm+"&idacod="+ida;
          break;
          case '42':
            location.href="listarWrit.php?idmcod="+idm+"&idacod="+ida;
          break;                                
      }
     
    
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