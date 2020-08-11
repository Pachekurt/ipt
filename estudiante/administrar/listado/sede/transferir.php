<?php
  $ruta="../../../../";
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio; 
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/vobservacion.php");
  $vobservacion=new vobservacion;
  include_once($ruta."class/admorgani.php");
  $admorgani=new admorgani;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/admorganidet.php");
  $admorganidet=new admorganidet;
  include_once($ruta."class/domicilio.php");
  $domicilio=new domicilio;
  include_once($ruta."class/laboral.php");
  $laboral=new laboral;
   include_once($ruta."class/titular.php");
  $titular=new titular;
   include_once($ruta."class/personaplan.php");
  $personaplan=new personaplan;
   include_once($ruta."class/admplan.php");
  $admplan=new admplan;
   include_once($ruta."class/vvinculado.php");
  $vvinculado=new vvinculado;
   include_once($ruta."class/admestudiante.php");
  $admestudiante=new admestudiante;
   include_once($ruta."class/vsemana.php");
  $vsemana=new vsemana;
  include_once($ruta."class/sede.php");
  $sede=new sede;
   include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;

   include_once($ruta."class/usuario.php");
  $usuario=new usuario; 

  include_once($ruta."funciones/funciones.php");
  session_start();  
  extract($_GET);

  $idusuario=$_SESSION["codusuario"];
  $us=$usuario->mostrarTodo("idusuario=".$idusuario);
  $us=array_shift($us);
  $valore=dcUrl($idecod);
$datoestudiante = $admestudiante->mostrarTodo("idestudiante=".$valore);
$datoestudiante=array_shift($datoestudiante);

$valor=$datoestudiante['idadmcontrato'];
  $lblcontrato=$datoestudiante['idadmcontrato'];
  $dcontrato=$admcontrato->muestra($valor);
  $dsemana=$vsemana->muestra($dcontrato['idadmsemana']);

  $dtit=$titular->mostrarUltimo("idtitular=".$dcontrato['idtitular']);
  $idpersona=$dtit['idpersona'];

  $dper=$persona->muestra($dtit['idpersona']);
  $dsede=$sede->muestra($dcontrato['idsede']);
  $destado=$dominio->muestra($dcontrato['estado']);
  $dejec=$vejecutivo->muestra($dcontrato['idadmejecutivo']);

  $titulaper= $dper['nombre']." ".$dper['paterno']." ".$dper['materno'];
  $ejecutivo= $dejec['nombre']." ".$dejec['paterno']." ".$dejec['materno'];

  $idpersona=ecUrl($dper['idpersona']);
  $idtitular=ecUrl($dcontrato['idtitular']);
  /************ nuevas validaciones  **********/
  $dorgz=$admorganizacion->muestra($dejec['idorganizacion']);
  $nOrgz=$dorgz['nombre'];
  // validar que hay un organigrama vigente de su organizacion
  $lblcod=ecUrl($dcontrato['idorganigrama']);

  $dcp=$vcontratoplan->muestra($valor);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="TRANSFERENCIA";
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
          $idmenu=1054;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
    
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="formcontent">
                  <div class="col s12 m12 l12">
                    <div class="col s12 m12 l12">
                      <a onclick="javascript:window.close();" class="btn blue darken-3"><i class="fa fa-reply"></i> cerrar</a href="../">
                    
                    </div>
                  </div>
                   
                 
                
                  <div class="divider"></div>
                 
                       <div class="row">
                 <div class='col s12 m12 l12'>                   
                      <div class="col s12 m12 l12">
                      <fieldset class="buscador">
                        <legend><div class="titulo"><strong>Datos estudiante</strong> </div></legend>
                       <div class="col s12 m8 l12">
                   
                          <table class="cssdato">
                              <tr>
                                  <td class="sub"  >Estudiante</td>
                                  <td><?php echo $datoestudiante['nombre']." ".$datoestudiante['paterno']." ".$datoestudiante['materno'] ?></td>
                                  <td class="sub"  >Sede actual</td>
                                  <td><?php  
                          
                                    echo $dsede['nombre']; ?></td>
                                  <td class="sub">Docente</td>
                                  <td><?php echo $datoestudiante['docente'] ?></td>
                                </tr>
                            <tr>
                              <tr>
                                  <td class="sub"  >Contacto</td>
                                  <td><?php echo $datoestudiante['celular']  ?></td>
                                  <td class="sub"  >Lecciones</td>
                                  <td><?php echo $datoestudiante['mdescripcion'] ?></td>
                                  <td class="sub">Estado Academico</td>
                              <td><?php echo $datoestudiante['nestadoacademico'] ?></td>
                                </tr>
                            <tr>
                              <?php
                            $dperplan=$personaplan->muestra($dcontrato['idpersonaplan']);
                            $dplan=$admplan->muestra($dperplan['idadmplan']);
                          ?>
                              <td class="sub"  >Nro. Contrato</td>
                              <td><?php echo $dcontrato['nrocontrato'] ?></td>
                              <td class="sub"  >Nro. Cuenta</td>
                              <td><?php echo $dcontrato['cuenta'] ?></td>
                               <td class="sub">Estado Contrato</td>
                             
                              <td><?php echo $datoestudiante['nestadocontrato'] ?></td>
                         
                                </tr>
                           
                            <tr>
                              <td class="sub">Fecha Inicio</td>
                              <td><?php echo $dperplan['fechainicio'] ?></td>
                              <td class="sub">Fecha Fin</td>
                              <td><?php echo $dperplan['fechafin'] ?></td>
                               <td class="sub">Plan</td>
                              <td><?php echo $dplan['personas']." ".$dplan['nombre'] ?></td>
                         
                                 </tr>
                           
                            <tr> 
                              <td class="sub">Total Pagado</td>
                              <td>
                              <?php 
                                echo $dcontrato['pagado']." Bs.-";
                              ?>
                              </td>
                              <td class="sub"  ">Titular</td>
                              <td  "><?php echo $dper['nombre']." ".$dper['paterno']." ".$dper['materno'] ?></td> 
                              <td class="sub" style="width: 15%;">Carnet</td>
                              <td style="width: 35%;"><?php echo $dper['carnet']." ".$dper['expedido'] ?></td>
                            </tr>
                        
                          </table>
                        </div>
                       
                      </fieldset> 
                      </div> 
                    
                  </div> 
                  </div>
 
                <div id="table-datatables">
         <legend><div class="titulo"><strong>TRANSFERENCIA</strong> </div></legend>
<form id="formtrasfer">
                  <div class="input-field col s6">
                    <input type="hidden" id="idestudiante" name="idestudiante" value="<?php echo $datoestudiante['idestudiante'] ?>">
                    <input type="hidden" id="idsedeanterior" name="idsedeanterior" value="<?php echo $datoestudiante['idsede'] ?>">

                    <input id="idejecutivo" name="idejecutivo" type="hidden" value="<?php echo $us['idadmejecutivo'] ?>">
                    <label>NUEVA SEDE</label>
                    <select id="idsede" name="idsede"  >
                      <option   value="">Seleccionar sede</option>
                      <?php
                        foreach($sede->mostrarTodo("") as $f)
                        {  
                          ?>
                            <option   value="<?php echo $f['idsede']; ?>"><?php echo $f['nombre']; ?></option>
                          <?php
                        }
                      ?>
                    </select>
                  </div>
</form>
                  <div class="input-field col S6 m6 l6" align="left">
                          
                            <a id="btnSavep" onclick="trasferir();" class="btn waves-effect waves-light blue"><i class="fa fa-save"></i> TRASFERIR</a>
                         
                        </div> 
              </div>   
                  </div>&nbsp;
                </div>
              </div>
             
              
            </div>
          </div>
        </div>
        <?php
          include_once("../../../../footer.php");
        ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">
      
    function guardarObs()
    {
       if (validar()) 
        {        
          //$('#btnSave').attr("disabled",true);
          var str = $( "#idform" ).serialize();
     // alert(str);
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
      function guardarObs2()
    {
       if (validar2()) 
        {        
          //$('#btnSave').attr("disabled",true);
          var str = $( "#idform2" ).serialize();
     // alert(str);
          $.ajax({
            url: "guardarObs2.php",
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
    function guardarObs3()
    {
       if (validar3()) 
        {        
          //$('#btnSave').attr("disabled",true);
          var str = $( "#idform3" ).serialize();
    //alert(str);
          $.ajax({
            url: "guardarObs3.php",
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
     function validar(){
        retorno=true;
        detalle=$('#iddescripcion').val();
         
        if(detalle=="" ){
          retorno=false;
        }
        return retorno;
      } 
      function validar2(){
        retorno=true;
        detalle=$('#iddescripcion1').val();
         
        if(detalle=="" ){
          retorno=false;
        }
        return retorno;
      }
 function validar3(){
        retorno=true;
        detalle=$('#iddescripcion2').val();
         
        if(detalle=="" ){
          retorno=false;
        }
        return retorno;
      }

        $(document).ready(function() {
        $('#example').DataTable({
          "bFilter": true,
          "bInfo": false,
          "bAutoWidth": false,
           "order": [[ 2, "desc" ]],
          responsive: true,
          dom: 'Bfrtip',
         
        });
      });
function trasferir()
      {
        $('#btnSavep').attr("disabled",true);
        if (validar()) {          
          
            var str = $( "#formtrasfer" ).serialize();
           // alert (str);
            $.ajax({
              url: "transfer.php",
              type: "POST",
              data: str,
              success: function(resp){
                console.log(resp);
                $("#idresultado").html(resp);
                //alert(resp);
              }
            }); 
        }else{
          Materialize.toast('<span>Datos incorrectos o faltantes</span>', 1500);
        }
      } 

        function validar(){
        retorno=true;
        carnet=$('#idsede').val();
        if(carnet==""){
          retorno=false;
        }
        return retorno;
      }
    </script>
</body>
</html>