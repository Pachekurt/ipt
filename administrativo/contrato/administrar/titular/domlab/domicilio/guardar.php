<?php
$ruta="../../../../../../";
include_once($ruta."class/domicilio.php");
$domicilio=new domicilio;
include_once($ruta."funciones/funciones.php");
extract($_POST);
session_start();
  $valores=array(
    "idbarrio"=>"'$idzona'",
    "nombre"=>"'$iddireccion'",
    "telefono"=>"'$idfono'",
    "descripcion"=>"'$iddesc'",
    "geox"=>"'$geox'",
    "geoy"=>"'$geoy'"
  ); 
  if($domicilio->actualizar($valores,$iddom)) {
    ?>
      <script type="text/javascript">
        swal("Datos actualizados Correctamente")
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