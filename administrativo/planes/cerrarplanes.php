<?php 
  $ruta="../../";
  include_once($ruta."class/admplanes.php");
  $admplanes=new admplanes;
  include_once($ruta."funciones/funciones.php");

  extract($_POST);
  session_start();
  $valor=dcUrl($id);
  $valores=array(
       "estado"=>"'2'"
  );  
  if($admplanes->actualizar($valores,$valor))
  {
    ?>
      <script  type="text/javascript">
        swal({
                  title: "Exito !!!",
                  text: "Planes Cerradas Correctamente",
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