<?php
$ruta="../../../../../../";
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

$fecha=date("Y-m-d");
$hora=date("H:i:s");
// CAMBIAMOS EL PLAN
$valores=array(
	"idadmplan"=>"'$idplan'",
	"observacion"=>"'$idobs'"
 );	
if($personaplan->actualizar($valores,$idpp))
{
  $dplan=$admplan->mostrarUltimo("idadmplan=$idplan");
  $dcont=$admcontrato->muestra($lblcontrato);
  //CALCULAMOS NUEVO ABONO A APAGAR EN EL MAESTRO
  $valores=array(
    "abono"=>$dplan['pagoinicial']-$dcont['pagado']
  );
  $admcontrato->actualizar($valores,$lblcontrato);
  $dcontNew=$admcontrato->muestra($lblcontrato);
  
  $detalle="CAMBIO DE PLAN AL ".$dplan['personas']." ".$dplan['nombre']." ".$dplan['inversion']." Bs."." ".$dplan['cuotas']." Meses";
  $valores2=array(
    "idcontrato"=>$lblcontrato,
    "fecha"=>"'$fecha'",
    "hora"=>"'$hora'",
    "detalle"=>"'$detalle'",
    "estado"=>$dcontNew['estado'],
    "codigo"=>"'3122'"
  );
  $admcontratodelle->insertar($valores2);
  if ($dcontNew['estado']==63 && $dcontNew['abono']>0) {
    $valores=array(
      "estado"=>62
    );
    $admcontrato->actualizar($valores,$lblcontrato);
  }else{
    $valores=array(
      "estado"=>63
    );
    $admcontrato->actualizar($valores,$lblcontrato);
  }
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