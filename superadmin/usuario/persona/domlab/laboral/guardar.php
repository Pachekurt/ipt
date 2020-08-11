<?php
$ruta="../../../../../";
include_once($ruta."class/laboral.php");
$laboral=new laboral;
extract($_POST);
session_start();

  $valores=array(
    "idbarrio"=>"'$idzonal'",
    "nombre"=>"'$iddireccionl'",
    "telefono"=>"'$idfonol'",
    "descripcion"=>"'$iddescl'",

    "empresa"=>"'$idempresa'",
    "cargo"=>"'$idcargo'",
    "antiguedad"=>"'$idantiguedad'",
    "ingresos"=>"'$idmensual'",
   ); 
  if($laboral->actualizar($valores,$idlab)){
    ?>
    <script type="text/javascript">
      swal("Datos actualizados Correctamente");
    </script>
  <?php
  }
  else{
    ?>
      <script type="text/javascript">
        sweetAlert("Oops...", "No se pudo actualizar el registro!", "error");
      </script>
    <?php
  }

?>