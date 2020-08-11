<?php
  $ruta="../../../";
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/modulo.php");
  $modulo=new modulo;
  include_once($ruta."class/sede.php");
  $sede=new sede;
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
      $hd_titulo="kardex estudiante";
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
          $idmenu=1030;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
    
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="formcontent">
                  <div class="col s12 m12 l12">
                    <div class="col s12 m12 l12">
                      <a href="../" class="btn blue darken-3"><i class="fa fa-reply"></i> volver</a href="../">
                      <ul id="dropdown2" class="dropdown-content">
                       
                        <li><a href="../../impresion/asistencia.php?idecod=<?php echo $idecod ?>" class="badge" target="_blank"  >Ver asistencias<span class="badge"><i class="mdi-image-remove-red-eyek"></i></span></a></li> </a></li>   <li><a class="modal-trigger badge" href="#modal5">Cambiar Modulo<span class="badge"><i class="mdi-action-clip"></i></span></a></li>
                         <li><a class="modal-trigger badge" href="#modal1">Quitar servicio<span class="badge"><i class="mdi-notification-do-not-disturb"></i></span></a></li>
                         <li><a class="modal-trigger badge" href="#modal2">Quitar servicio y abandono<span class="badge"><i class="mdi-action-lock"></i></span></a></li>
                         <li><a class="modal-trigger badge" href="#modal4">Dar Baja<span class="badge"><i class="mdi-action-lock"></i></span></a></li>

<?php if ($datoestudiante['estadoacademico']==153){  
                
           if ($datoestudiante['estadocontrato'] == 142 or $datoestudiante['estadocontrato'] == 144 ){  
            ?>
                <li><a class="modal-trigger badge" href="#modal3">Devolver servicio <span class="badge"><i class="mdi-action-swap-vert"></i></span></a></li>
            <?php
           }  
 } ?>
                          


                      </ul>
                      <a class="btn dropdown-button"  data-activates="dropdown2">ACCIONES DE ESTUDIANTE <i class="mdi-navigation-arrow-drop-down right"></i></a>
                    </div>
                  </div>
                     <div id="modal1" class="modal">
                  <div class="modal-content">
                     <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                      <h1>QUITAR SERVICIO</h1>
                    <p>Al inactivar al estudiante el sistema cambiara el estado academico a INACTIVO, ya no tendra servicio en el sistema, por favor agrege el motivo para su inactivacion</p>
                     <div   class="row">
                             <div class="input-field col s12 m3">
                               <strong>Observación:</strong>
                            </div>
                        <div class="input-field col s9">
                          <input type="hidden" name="idestudianteSel" value="<?php echo $datoestudiante['idestudiante'] ?>">
                          <input id="idejecutivo" name="idejecutivo" type="hidden" value="<?php echo $us['idadmejecutivo'] ?>">
                          <textarea id="iddescripcion" name="iddescripcion" class="materialize-textarea"></textarea>
                          <label for="iddescripcion">Detalle</label>
                        </div>
                        </div>

                    </form>
                  </div>
                    <div class="modal-footer">
                  <button id="btnSave" class="btn waves-effect light-green darken-4 indigo" onclick="guardarObs();"><i class="fa fa-save"></i> GUARDAR</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
                  </div>
                </div>
                 <div id="modal2" class="modal">
                  <div class="modal-content">
                     <form class="col s12" id="idform2" action="return false" onsubmit="return false" method="POST">

                      <h1>QUITAR SERVICIO Y ABANDONO CONTRATO</h1>
                    <p>Al inactivar al estudiante el sistema cambiara el estado academico a INACTIVO, ya no tendra servicio en el sistema, ademas  el contrato entrara a un estado de ABANDONO por favor agrege el motivo para su inactivacion</p>
                     <div   class="row">
                             <div class="input-field col s12 m3">
                               <strong>Observación:</strong>
                            </div>
                        <div class="input-field col s9">
                          <input type="hidden" name="idestudianteSel" value="<?php echo $datoestudiante['idestudiante'] ?>">
                          <input id="idejecutivo" name="idejecutivo" type="hidden" value="<?php echo $us['idadmejecutivo'] ?>">
                          <textarea id="iddescripcion1" name="iddescripcion1" class="materialize-textarea"></textarea>
                          <label for="iddescripcion1">Detalle</label>
                        </div>
                        </div>

                    </form>
                  </div>
                    <div class="modal-footer">
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardarObs2();"><i class="fa fa-save"></i> GUARDAR</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
                  </div>
                </div>
                 <div id="modal3" class="modal">
                  <div class="modal-content">
                     <form class="col s12" id="idform3" action="return false" onsubmit="return false" method="POST">

                      <h1>DEVOLVER SERVICIO</h1>
                    <p>sE DEVOLVERA EL SERVICIO AL ESTUDIANTE, SE LE DEBE ASIGNAR CURSO MANUALMENTE</p>
                     <div   class="row">
                             <div class="input-field col s12 m3">
                               <strong>Observación:</strong>
                            </div>
                        <div class="input-field col s9">
                          <input type="hidden" name="idestudianteSel" value="<?php echo $datoestudiante['idestudiante'] ?>">
                          <input id="idejecutivo" name="idejecutivo" type="hidden" value="<?php echo $us['idadmejecutivo'] ?>">
                          <textarea id="iddescripcion2" name="iddescripcion2" class="materialize-textarea"></textarea>
                          <label for="iddescripcion2">Detalle</label>
                        </div>
                        </div>

                    </form>
                  </div>
                    <div class="modal-footer">
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardarObs3();"><i class="fa fa-save"></i> GUARDAR</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
                  </div>
                </div>

   <div id="modal4" class="modal">
                  <div class="modal-content">
                     <form class="col s12" id="idform3" action="return false" onsubmit="return false" method="POST">

                      <h1>DAR DE BAJA</h1>
                    <p>BAJA DEFINITIVA DEL CONTRATO</p>
                     <div   class="row">
                             <div class="input-field col s12 m3">
                               <strong>Observación:</strong>
                            </div>
                        <div class="input-field col s9">
                          <input type="hidden" name="idestudianteSel" value="<?php echo $datoestudiante['idestudiante'] ?>">
                          <input id="idejecutivo" name="idejecutivo" type="hidden" value="<?php echo $us['idadmejecutivo'] ?>">
                          <textarea id="iddescripcion4" name="iddescripcion4" class="materialize-textarea"></textarea>
                          <label for="iddescripcion4">Detalle de baja</label>
                        </div>
                        </div>

                    </form>
                  </div>
                    <div class="modal-footer">
                  <button id="btnSave" class="btn waves-effect light-blue darken-4 indigo" onclick="guardarObs4();"><i class="fa fa-save"></i> GUARDAR BAJA</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
                  </div>
                </div>
                 <div id="modal5" class="modal">
                  <div class="modal-content">
                     <form class="col s12" id="idformM" action="return false" onsubmit="return false" method="POST">
                      <h1>CAMBIAR DE MODULO</h1>
                    <p>Se cambiara de modulo al estudiante, una vez realizado es necesario hacer el traspaso o asignacion de curso segun corresponda</p>
                     <div   class="row">
                             <div class="input-field col s12 m3">
                               <strong>Modulo:</strong>
                            </div>
                        <div class="input-field col s9">
                          <input type="hidden" name="idestudianteSel" value="<?php echo $datoestudiante['idestudiante'] ?>">
                          <input id="idejecutivo" name="idejecutivo" type="hidden" value="<?php echo $us['idadmejecutivo'] ?>">
                           
                            <label>Modulo</label>
                              <select id="idmodulo" name="idmodulo">
                                <option value="0">Seleccionar Modulo...</option>
                                <?php
                                foreach($modulo->mostrarTodo("") as $f)
                                {
                                  ?>
                                   <option id="nombremodulo" name= "nombremodulo"  value="<?php echo $f['idmodulo'];  ?>" ><?php echo $f['nombre']." (".$f['descripcion'].")" ?></option>
                                  <?php
                                }
                                ?>
                              </select>



                        </div>
                        </div>

                    </form>
                  </div>
                    <div class="modal-footer">
                  <button id="btnSavem" class="btn waves-effect light-green darken-4 indigo" onclick="guardarModulo();"><i class="fa fa-save"></i> GUARDAR</button>
                  <button class="btn waves-effect waves-light red darken-4 modal-action modal-close"><i class="fa fa-times"></i> CANCELAR</button>                  
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
                                  <td class="sub"  >Modulo</td>
                                  <td><?php echo $datoestudiante['modulo'] ?></td>
                                  <td class="sub">Docente</td>
                                  <td><?php echo $datoestudiante['docente'] ?></td>
                                </tr>
                            <tr>
                              <tr>
                                  <td class="sub"  >Contacto</td>
                                  <td><?php echo $datoestudiante['celular']  ?></td>
                                  
                                    <td class="sub">Estado Contrato</td>
                             
                              <td><?php echo $datoestudiante['nestadocontrato'] ?></td>
                         
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
                              <td><?php echo $dplan['personas']." ".$dplan['nombre']."   para sistema ".$dcontrato['idpersonaplan'] ?></td>
                         
                                 </tr>
                           
                            <tr> 
                              <td class="sub">Total Pagado</td>
                              <td>
                              <?php 
                                echo $dcontrato['pagado']." Bs.-";
                              ?>
                              </td>
                              <td class="sub"  ">Titular</td>
                              <td  ><?php echo $dper['nombre']." ".$dper['paterno']." ".$dper['materno'] ?></td> 
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
         <legend><div class="titulo"><strong>OBSERVACIONES</strong> </div></legend>
                <div class="row">
                  <table id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                          <th style="width: 900px;">Detalle</th>
                          <th>Por</th>
                          <th>Fecha</th>  
                          <th>Hora</th> 
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                          <th>Detalle</th>
                          <th>Por</th>
                          <th>Fecha</th>  
                          <th>Hora</th> 
                      </tr>
                  </tfoot>
                  <tbody>
                        <?php
                        foreach($vobservacion->mostrarTodo("idestudiante=".$datoestudiante['idestudiante'] ) as $f)
                        {
                           
                        ?>
                        <tr   >
                          <td><?php echo $f['detalle'] ?></td>
                          <td><?php echo $f['nombreo']." ".$f['paternoo']  ?></td> 
                            <td><?php echo $f['fechacreacion'] ?></td>  
                          <td><?php echo $f['horacreacion'] ?></td> 

                        
                          
                        </tr>
                        <?php
                          }
                        ?>
                      </tbody>
                </table>
                </div>
              </div>   
                  </div>&nbsp;
                </div>
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
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">
      
     function guardarObs()
    {
       if (validar()) 
        {        
          //$('#btnSave').attr("disabled",true);Fnro
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
    function guardarModulo()
    {
               
          //$('#btnSave').attr("disabled",true);
          var str = $( "#idformM" ).serialize();
     // alert(str);
          $.ajax({
            url: "guardarModulo.php",
            type: "POST",
            data: str,
            success: function(resp){
              console.log(resp);
              $('#idresultado').html(resp);
            }
          });
         
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

    </script>
</body>
</html>