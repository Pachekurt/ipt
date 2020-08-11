<?php 
  $ruta="../../";
  include_once($ruta."class/admplanes.php");
  $admplanes=new admplanes;
  extract($_POST);
  session_start();
  $valores=array(
       "estado"=>"'1'"
  );  
  if($admplanes->actualizar($valores,$id))
  {
    ?>
      <script  type="text/javascript">
        swal({
          title: "Exito !!!",
          text: "Planes Activadas Correctamente",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "OK",
          closeOnConfirm: false
        }, function () {      
          location.reload();
        });       
      </script>
    <?php
  }
  else
  {
    ?>
      <script type="text/javascript">
        Materialize.toast('<span>No se pudo generar el registro</span>', 1500);
      </script>
    <?php
  }
?>