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
$fecha=date("Y-m-d");
$hora=date("H:i:s");
$valores=array(
  "estado"=>"'65'",
  "fechaestado"=>"'$fecha'"
); 
if ($admcontrato->actualizar($valores,$idcontrato)) {
//generar historial de verificacion
  $valores2=array(
    "idcontrato"=>$idcontrato,
    "fecha"=>"'$fecha'",
    "hora"=>"'$hora'",
    "detalle"=>"'$idobs'",
    "estado"=>"'65'",
    "codigo"=>"'3116'"
  );  
  $admcontratodelle->insertar($valores2);
	?>
    <script type="text/javascript">
      swal({
        title: "Exito !!!",
        text: "El registro se envio a auditoria",
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