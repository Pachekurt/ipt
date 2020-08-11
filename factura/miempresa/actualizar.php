<?php
session_start();
$ruta="../../";
include_once($ruta."class/miempresa.php");
$miempresa=new miempresa;
extract($_POST);
  $valores=array( 
    "nombre"=>"'$idnombre'",
    "nit"=>"'$idnit'"
  ); 
  if($miempresa->actualizar($valores,1)) {  
    ?>
      <script type="text/javascript">
        sweetAlert("Exito!", "Se realizaron los cambios", "success");
      </script>
    <?php
  }
  else{
    ?>
      <script type="text/javascript">
        setTimeout(function() {
                Materialize.toast('<span>0 No se pudo realizar la Operacion. Si la el error persiste, Consulte con su proveedor</span>', 1500);
            }, 1500);
      </script>
    <?php
  }
?>