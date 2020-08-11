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

$valores=array(
	"idpersona"=>"'$idpersona'",
  "idtitular"=>"'$idtitular'",
	"idadmplan"=>"'$idplan'",
	"idcontrato"=>"'$lblcontrato'",
	"descripcion"=>"''",
	"observacion"=>"'$idobs'",
	"estado"=>"'0'"
 );	
if($personaplan->insertar($valores))
{
	$datospp=$personaplan->mostrarUltimo("idcontrato=$lblcontrato");

  $idpersonaplan=$datospp['idpersonaplan'];
  $dplan=$admplan->mostrarUltimo("idadmplan=$idplan");

  $valores=array(
    "abono"=>$dplan['pagoinicial'],
    "idpersonaplan"=>"'$idpersonaplan'"
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
          location.href="../?lblcode=<?php echo $lblcode ?>";
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