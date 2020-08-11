<?php
  $ruta="../../";
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/vcurso.php");
  $vcurso=new vcurso;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/modulo.php");
  $modulo=new modulo;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
    include_once($ruta."class/horario.php");
  $horario=new horario;
   include_once($ruta."class/estudiantecurso.php");
  $estudiantecurso=new estudiantecurso;
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
    include_once($ruta."includes/head_tablax.php");
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
          $idmenu=1057;
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
           
              <div class="row">
                <input id="idsede" style="text-align: center;" name="idsede" type="hidden"  class="validate" value= "<?php echo $ID_sede ?>">
                 <table id="tablarecord" class="display" cellspacing="0" width="100%"
                      style="font-size: 13px; color:##060606;">
                <thead>
                    <tr>
                        <th>Modulo</th>
                        <th>Docente</th>
                        <th>Fecha</th>  
                        <th>Horario</th> 
                        <th>Acciones</th>
                    </tr>
                </thead> 
                <tbody>
                      
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
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
       
      
     $(document).ready(function(){
      idsede=$('#idsede').val();
       
       
        $("#tablarecord").dataTable().fnDestroy();
        var str="idsede="+idsede;
       //alert(str);
        var table=$("#tablarecord").dataTable({
        "ajax":{
          "method":"POST",
          "url":"mostrarcursos.php?"+str
        },
        "columns":[
          {"data":"modulo"},
          {"data":"docente"},
          {"data":"fecha"}, 
          {"data":"hora"},  
            {"defaultContent":"<a class='btn-jh red idprint'>VER ASISTENCIA<i class='mdi-action-print'></i></a> "}  
         
        ],
           
            "ordering": false,
            "info":     false,
      }); 
     
      
        GetData("#tablarecord tbody",table);
    });

   function GetData(tbody,table){
        $(tbody).on("click","a.idprint",function(){
          var data=table.api().row( $(this).parents("tr") ).data();        
          console.log(data);
          //alert(data);

           window.open("modulo/?lblcode="+data.idcurso,"_blank");
          
        });
      
      }
    </script> 
</body>

</html>