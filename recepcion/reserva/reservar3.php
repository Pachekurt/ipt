<?php
  $ruta="../../";
   include_once($ruta."class/estudiante.php");
  $estudiante=new estudiante;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
   include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/vactividadhabil.php");
  $vactividadhabil=new vactividadhabil;
  include_once($ruta."class/actividadreserva.php");
  $actividadreserva=new actividadreserva;
  session_start(); 
  extract($_GET);
  $idestudiante=dcUrl($lblcode); 
  //echo $idestudiante;

  $est=$estudiante->mostrar($idestudiante);
  $est=array_shift($est);
  $per=$persona->mostrarTodo("idpersona=".$est['idpersona']);
  $per=array_shift($per);
   $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrar($idusuario);
  $us=array_shift($us);
  $idsede=$us['idsede'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Asignar a un Curso";
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
          $idmenu=1010;
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
                 <a href="index.php" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a>
                    <div id="card-alert" class="card deep-purple lighten-5">
                      <div class="card-content deep-purple-text">
                       <p><strong>NOMBRE: </strong> <?php echo $per['nombre']." ".$per['paterno']." ".$per['materno'] ?></p>
                        <p><strong>CARNET: </strong> <?php echo $per['carnet']." ".$per['expedido'] ?></p>
                      </div>
                  </div>
              </div>
            </div>
          <div class="container">
            <div class="section">
              <div id="table-datatables">               
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Actividad</th>
                        <th>Docente</th>
                        <th>Fecha</th>
                        <th>Duración</th>
                        <th>Hora actividad</th>
                        <th>Cantidad</th>                        
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Actividad</th>
                        <th>Docente</th>
                        <th>Fecha</th>
                        <th>Duración</th>
                        <th>Fecha</th>
                        <th>Hora actividad</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      $fechaactual=date('Y-m-d');
                       
                      foreach($vactividadhabil->mostrarTodo("idsede=".$idsede." and fecha >='$fechaactual'") as $f)
                      {
                        $estC=$actividadreserva->mostrarTodo("idactividadhabil=".$f['idvactividadhabil']);
                      ?>
                      <tr>
                       <td><?php echo $f['actividad']." (".$f['descripcion'].")" ?></td>
                        <td><?php echo $f['nombre'].' '.$f['paterno'].' '.$f['materno']  ?></td>
                        <td><?php echo $f['fecha'] ?></td>
                        
                        <td><?php echo $f['duracion'].' Hrs' ?></td>
                        <?php 
                          $horafin=$f['horainicio'] + $f['duracion'];
                         ?>
                        <td><?php echo $f['horainicio'].':00 hasta '.$horafin.':00'  ?></td>
                        <td style="font-size:17px; color:green;"><strong><?php echo count($estC) ?></strong> </td>
                        <td>
                         <button class="btn-jh waves-effect waves-light teal indigo" onclick="asignar('<?php echo $f['idvactividadhabil'] ?>');"><i class="mdi-social-group-add"></i> Reservar</button>
                         <button class="btn-jh waves-effect waves-light light-blue darken-4" onclick="ver('<?php echo $idvactividadhabil ?>');"><i class="mdi-av-my-library-books"></i> Ver Reservas</button>
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
   function agregar(id)
    {
      var idest='<?php echo $lblcode ?>'
          popup=window.open("seleccionar.php?idcurso="+id+"&idestudiante="+idest,"neo","width=1050,height=600,enumerar=si;");
          popup.focus();
          //$('#btnSendDirecto').attr("disabled",false);
    }
     function selecion(idc)
     {
        //document.idform.idcursoSel.value = idc;
        var idest='<?php echo $idestudiante ?>';
        $('#idcursoSel').val(idc);
        $.ajax({
            async: true,
            url: "cargarCurso.php?idc="+idc+"&ide="+idest,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#idcursoSel").val(json.idcursoInport);
                $("#modulo").text(json.modulo);
                $("#horario").text(json.horario);
                $("#fechainicio").text(json.fechainicio);
                $("#fechafin").text(json.fechafin);

                $("#moduloEC").text(json.moduloEC);
                $("#horarioEC").text(json.horarioEC);
                $("#fechainicioEC").text(json.fechainicioEC);
                $("#fechafinEC").text(json.fechafinEC);
                $("#existe").val(json.existe);
                if (json.existe==1) 
                {
                  document.getElementById('card-alert3').style.display='block';
                  document.getElementById('smsSi').style.display='none';
                  document.getElementById('smsNo').style.display='block';
                  
                }
                if (json.existe==0) 
                {
                  document.getElementById('card-alert3').style.display='none';
                  document.getElementById('smsNo').style.display='none';
                  document.getElementById('smsSi').style.display='block';
                }
            }
            
          });
     }   
        function ver(idc)
     {
        popup=window.open("ver.php?idcurso="+idc,"neo","width=800,height=600,enumerar=si;");
        popup.focus();
     }  
    function asignar(idah)
    {
      var idest='<?php echo $idestudiante ?>';
           // alert(idest+' '+idah);     
          $('#btnasignar').attr("disabled",true);
          $.ajax({
            url: "guardar.php",
            type: "POST",
            data: "idactividadhabil="+idah+"&idestudiante="+idest,
            success: function(resp){
             console.log(resp);
              $('#idresultado').html(resp);
              //location.reload();
             // alert(resp);
            }
          });
        
    }

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


    </script>
</body>

</html>