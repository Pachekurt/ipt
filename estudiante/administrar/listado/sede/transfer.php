<?php 
  $ruta="../../../../";
  include_once($ruta."class/estudiantecurso.php");
  $estudiantecurso=new estudiantecurso;
  include_once($ruta."class/estudiante.php");
  $estudiante=new estudiante;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/observacion.php");
  $observacion=new observacion;
  extract($_POST);
  session_start();


$dsedeant=$sede->muestra($idsedeanterior);
$dsedenueva=$sede->muestra($idsede);
  $valores=array(
       "idsede"=>"'$idsede'" 
  );   


$anterior=$dsedeant['nombre'];
$nueva=$dsedenueva['nombre'];
     $valoresobservacion=array(
       "idestudiante"=>"'$idestudiante'",
       "detalle"=>"'cambio de sede $anterior a sede $nueva'",
       "idejecutivoDetalla"=>"'$idejecutivo'",
       "tipo"=>"'admin'",
       "estado"=>"'0'"
  );  
if ($estudiante->actualizar($valores,$idestudiante)) {


      $consulta="update estudiantecurso set estado =0 where idestudiante =$idestudiante";

      $resultado=$estudiante->sql($consulta);
      $resultado=array_shift($resultado);
          if($observacion->insertar($valoresobservacion))
              {
                ?>
                  <script  type="text/javascript">
                  $('#btnSave').attr("disabled",true);
                    swal({
                              title: "Exito !!!",
                              text: "Se registro el traspaso correctamente",
                              type: "success",
                              //showCancelButton: false,
                              confirmButtonColor: "#28e29e",
                              confirmButtonText: "OK",
                              closeOnConfirm: false
                          }, function () {      
                            location.reload();
                          });       
                  </script>
                <?php
              }else{
                ?>
                <script type="text/javascript">
                  Materialize.toast('<span>No se pudorealizar la observacion</span>', 1500);
                </script>
                <?php
              }
}
else
{

  ?>
    <script type="text/javascript">
      Materialize.toast('<span>No se pudo cambiar el estado</span>', 1500);
    </script>
    <?php
}

  
?>