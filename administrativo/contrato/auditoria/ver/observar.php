<?php
$ruta="../../../../";
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."class/admcontratodelle.php");
$admcontratodelle=new admcontratodelle;
include_once($ruta."funciones/funciones.php");
extract($_POST);
session_start();
/*************** ACTUALIZAR CONTRATOS ***************************/
$valores=array(
  "estado"=>"'66'"
); 
if ($admcontrato->actualizar($valores,$idcontrato)) {
//generar historial de verificacion
  $fecha=date("Y-m-d");
  $hora=date("H:i:s");
  $valores2=array(
    "idcontrato"=>$idcontrato,
    "fecha"=>"'$fecha'",
    "hora"=>"'$hora'",
    "detalle"=>"'$idobs'",
    "estado"=>"'66'",
    "codigo"=>"'3117'"
  );  
  $admcontratodelle->insertar($valores2);
	?>
    <script type="text/javascript">
      swal({
        title: "Exito !!!",
        text: "Registrado Correctamente",
        type: "success",
        showCancelButton: false,
        confirmButtonColor: "#28e29e",
        confirmButtonText: "OK",
        closeOnConfirm: false
      }, function () {
        location.href="../";
      });
    </script>
  <?php
}
else{
	?>
    <script type="text/javascript">
      setTimeout(function() {
        Materialize.toast('<span>No se pudo realizar el registro</span>', 1500);
      }, 10);
    </script>
  <?php
}
?>