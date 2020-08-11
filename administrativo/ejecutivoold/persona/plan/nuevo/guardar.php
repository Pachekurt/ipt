<?php
$ruta="../../../../../../";
include_once($ruta."class/personaplan.php");
$personaplan=new personaplan;
include_once($ruta."class/admplan.php");
$admplan=new admplan;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."funciones/funciones.php");
extract($_POST);
session_start();

if (!isset($idmaterial)) $idmaterial=0; else $idmaterial=1;
$nuevafecha = strtotime ('+10 month', strtotime ( $fechainicio ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
$valores=array(
	"idpersona"=>"'$idpersona'",
	"idadmplan"=>"'$idplan'",
	"idcontrato"=>"'$lblcontrato'",
	"numcuenta"=>"'$idcuenta'",
	"material"=>"'$idmaterial'",
	"fechainicio"=>"'$idfechaInicio'",
	"fechafin"=>"'$nuevafecha'",
	"descripcion"=>"''",
	"observacion"=>"'$idobs'",
	"estado"=>"'1'"
 );	
if($personaplan->insertar($valores))
{
	$datospp=$personaplan->mostrarTodo("idcontrato = $lblcontrato");
	$datospp=array_shift($datospp);
  $dplan=$admplan->mostrarUltimo("idadmplan=$idplan");

  $valores=array(
    "abono"=>$dplan['pagoinicial']
  );
  $admcontrato->actualizar($valores,$lblcontrato);
	$perplan= $datospp['idpersonaplan'];
	?>
    <script type="text/javascript">
    swal({
              title: "Exito !!!",
              text: "Datos Registrado Correctamente",
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