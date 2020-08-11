<?php
  $ruta="../../../";
   include_once($ruta."class/admestudiante.php");
  $admestudiante=new admestudiante;
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
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
      $hd_titulo="Lista de estudiante x";
      include_once($ruta."includes/head_basico.php");
      include_once($ruta."includes/head_tabla.php");
    include_once($ruta."includes/head_tablax.php");
    ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1030;
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
           <div id="modal1" class="modal">
                    <div class="modal-content">
                      <div class="row">
                      <div class="col s12 m12 l6" >
                        <h1 align="center">INFORMACIÓN</h1>
                      </div>
                      <div class="col s12 m12 l6" align="right">
                        <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i></button>
                      </div>
                     </div> 
                    
                  
                      <form class="col s12" id="idform" name="idform" action="return false" onsubmit="return false" method="POST">
                        <div class="row">

                          <div id="card-alert" class="col s12 m12 l6 card green lighten-5">
                            <div class="col s12 m12 l12" >
                              <label class="light center-align green-text" style="font-size:25px;"><i class="mdi-image-timer-auto"></i>ESTUDIANTE</label>
                            </div>
                            <div class="col s12 m12 l12">
                            <div class="card-content green-text">
                              <p> <strong>ESTUDIANTE: </strong><label id="estudianteEC" style="color:#252525; font-size:15px;"></label></p>
                              <p> <strong>CARNET: </strong><label id="carnetEC" style="color:#252525; font-size:15px;"></label></p>
                            </div>
                             </div>
                          </div>
                         
   
                               
                            
                        </div>
                      </form>
                    </div>
               <!--     <div class="modal-footer">
                                    
                    </div> -->
            </div>
 
                
          <div class="container">
            <div class="section">
              <div id="table-datatables">
             <!-- <a href="../inicio" class="btn waves-effect waves-light blue"><i class="fa fa-reply"></i> Atras</a> -->
             
              <div class="row">
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Cuenta</th>
                        <th>Contrato</th>  
                        <th>Fin</th>
                        <th>Modulo</th>
                        <th>Horario</th>
                        <th>Estado contrato</th> 
                        <th>Estado academico</th> 
                        <th> </th> 
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Estudiante</th>
                        <th>Cuenta</th>
                        <th>Contrato</th>  
                        <th>Fin</th>
                        <th>Modulo</th>
                        <th>Horario</th>
                        <th>Estado contrato</th> 
                        <th>Estado academico</th> 
                        <th> </th> 
                    </tr>
                </tfoot>
                <tbody>
                      <?php
                      foreach($admestudiante->mostrarTodo("idsede=".$idsede." and estado in(1,2)") as $f)
                      {
                        $idest=ecUrl($f['idestudiante']);
                      
                       switch ($f['nestadocontrato']) {
                        case 'VIGENTE':
                            $style="background-color:#e0f2f1;";
                             
                          break;
                        case 'NO VIGENTE':
                           $style="background-color:#F2E0E1;";
                             
                          break;
                           case 'ABANDONO':
                           $style="background-color:#FFE897;";
                             
                          break;
                        
                      } 
                       switch ($f['estadoacademico']) {
                        case '148':
                            $style1="color: #27a02a";
                             
                          break;
                        case '149':
                           $style1="color: #E82C0C";
                             
                          break;
                          case '153':
                           $style1="color: #E82C0C";
                             
                          break;
                        
                      }
                      ?>
                      <tr style="<?php echo $style.$style1 ?>" >
                        <td><?php echo $f['nombre']." ".$f['paterno']." ".$f['materno'] ?></td> 
                        <td><?php echo $f['cuenta'] ?></td>
                        <td><?php echo $f['nrocontrato'] ?></td>  
                        <td><?php echo $f['fechafin'] ?></td> 
                        <td><?php echo $f['modulo'] ?></td>

                        <td><?php echo $f['inicio'] ?></td>
                        <td><?php echo $f['nestadocontrato'] ?></td>

                        <td  ><?php echo $f['nestadoacademico'] ?></td> 
                        <td>
                           <!-- <a href="modificar.php?idecod=<?php echo $idest ?>" class="btn-jh waves-effect waves-light blue"><i class="mdi-content-create"></i> Editar</a>-->
                            <a href="kardex.php?idecod=<?php echo $idest ?>" class="btn-jh waves-effect waves-light green tooltipped" target="_blank" data-position="bottom" data-delay="50" data-tooltip="VER KARDEX">VER KARDEX<i class="mdi-action-assignment-turned-in"></i>  </a>
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
            include_once("../../../footer.php");
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



      $(document).ready(function() {
        $('#example').DataTable({
          "bFilter": true,
          "bInfo": false,
          "bAutoWidth": false,
          responsive: true,
          dom: 'Bfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ]
        });
      });

 
     
     $("#btnSsaveV2").click(function(){
             
        iddocente=$("#idest").val();
        window.open("vistapordocente/?iddocente="+$("#iddocente").val(),"_blank");
         
      });
        
   

  
      $("#btnSave").click(function(){        
        if (validar()) 
        {        
          $('#btnSave').attr("disabled",true);
          var str = $( "#idform" ).serialize();
          //alert(str);
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
     function guardarObs()
    {
       if (validar()) 
        {        
          //$('#btnSave').attr("disabled",true);
          var str = $( "#idform2" ).serialize();
         //alert(str);
          $.ajax({
            url: "guardarObs.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
        }else{
          Materialize.toast('<span>Ingrese una observación porfavor</span>', 1500);
          
        }
    } 
    function cargar(ide)
     {
        $('#idestudianteSel').val(ide);
        $.ajax({
            async: true,
            url: "cargarestudiante.php?ide="+ide,
            type: "get",
            dataType: "html",
            success: function(data){
              //console.log(data);
              var json = eval("("+data+")");
                $("#idestudiantenombre").text(json.estudiante);
                $("#idcarnet").text(json.carnet);
                
                $("#idest").text(json.idperson);
               
            }
          });
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
    </script>
</body>

</html>