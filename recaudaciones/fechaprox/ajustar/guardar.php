<?php
$ruta="../../../";
include_once($ruta."class/vcontratoplan.php");
$vcontratoplan=new vcontratoplan;
include_once($ruta."class/admplan.php");
$admplan=new admplan;
include_once($ruta."class/cobcarteradet.php");
$cobcarteradet=new cobcarteradet;
include_once($ruta."class/cobcartera.php");
$cobcartera=new cobcartera;
include_once($ruta."class/factura.php");
$factura=new factura;
include_once($ruta."class/facturadet.php");
$facturadet=new facturadet;
include_once($ruta."class/admsucursal.php");
$admsucursal=new admsucursal;
include_once($ruta."class/admdosificacion.php");
$admdosificacion=new admdosificacion;
include_once($ruta."class/sede.php");
$sede=new sede;


require_once($ruta."funciones/codigo.php");
include_once($ruta."funciones/funciones.php");
extract($_POST);
session_start();

$valores=array(
  "fechaproxve"=>"'$idproxvence'",
  "revisado"=>"1",
);
if($cobcartera->actualizar($valores,$idcartera))
{
  ?>
    <script  type="text/javascript">
      swal({
        title: "Exito!!!",
        text: "Cambiado Correctamente",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#16c103",
        confirmButtonText: "OK",
        cancelButtonText: "P.O.S.",
        confirmButtonClass: 'btn green',
        cancelButtonClass: 'btn red',
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm){
        if (isConfirm) {
          location.reload();
        } else {
          location.reload();
        }
      });
    </script>
  <?php
}
else{
  ?>
    <script type="text/javascript">
      setTimeout(function() {
        Materialize.toast('<span>3 Factura No se pudo realizar el registro</span>', 1500);
      }, 10);
    </script>
  <?php
}
?>