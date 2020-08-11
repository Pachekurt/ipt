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
      $hd_titulo="Reservar actividad";
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
          $idmenu=1017;
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
            <div class="row">
              <section class="plans-container" id="plans">
                <?php
                      $fechaactual=date('Y-m-d');    
                      $consulta="SELECT *
                                  FROM vactividadhabil vah
                                  where vah.idsede=$idsede and vah.fecha >='$fechaactual'  order by vah.fecha,vah.horainicio ASC LIMIT 10";
                      foreach($vactividadhabil->sql($consulta) as $f)                   
                     // foreach($vactividadhabil->mostrarTodo("idsede=".$idsede." and fecha >='$fechaactual'") as $f)
                      {
                        $estC=$actividadreserva->mostrarTodo("idactividadhabil=".$f['idvactividadhabil']);
                        $idvah=ecUrl($f['idvactividadhabil']);
                       ?>
                            <article class="col s12 m6 l2">
                              <div class="card hoverable">
                                <div class="card-image purple waves-effect">
                                  <div class="card-title"><?php echo $f['actividad'] ?></div>
                                  <div class="price" style="font-size:40px;" onclick="ver('<?php echo $idvah ?>');"><sup></sup><strong><?php echo count($estC) ?></strong></div>
                                  <div class="price-desc"><?php echo $f['nombre'].' '.$f['paterno'] ?></div>
                                </div>
                                <div class="card-content" align="center">
                                  <ul class="collection">
                                  <div><?php echo $f['nombredia'].' '.$f['horainicio'].':00hrs' ?></div>
                                  <div><?php echo $f['literal'] ?></div>
                                  </ul>
                                </div>
                                <div class="card-action center-align">                      
                                  <button class="waves-effect waves-light  btn" onclick="asignar('<?php echo $f['idvactividadhabil'] ?>');">Reservar</button>
                                </div>
                              </div>
                            </article>
                      <?php
                        }
                      ?>
              </section>
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
        function ver(idvah)
     {
        popup=window.open("ver.php?idvah="+idvah,"neo","width=800,height=600,enumerar=si;");
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