<?php
$ruta="../../../../";
include_once($ruta."class/personaplan.php");
$personaplan=new personaplan;
include_once($ruta."class/admplan.php");
$admplan=new admplan;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."class/admcontratodelle.php");
$admcontratodelle=new admcontratodelle;
include_once($ruta."funciones/funciones.php");
extract($_POST);
session_start();
$lblcode=ecUrl($idcontrato);
/*************** ACTUALIZAR CONTRATOS ***************************/
$fechaActual=date("Y-m-d");
$valores=array(
  "estado"=>"'69'",
  "fechaestado"=>"'$fechaActual'"
); 
$admcontrato->actualizar($valores,$idcontrato);
//generar historial de verificacion
  $fecha=date("Y-m-d");
  $hora=date("H:i:s");
  $valores2=array(
    "idcontrato"=>$idcontrato,
    "fecha"=>"'$fecha'",
    "hora"=>"'$hora'",
    "detalle"=>"'$idobs'",
    "estado"=>"'69'",
    "codigo"=>"'3123'"
  );  
if($admcontratodelle->insertar($valores2))
{
	?>
    <script type="text/javascript">
    swal({
      title: "Exito !!!",
      text: "Contrato Rechazado Correctamente",
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