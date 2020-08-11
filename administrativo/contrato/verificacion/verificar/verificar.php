<?php
$ruta="../../../../";
include_once($ruta."class/personaplan.php");
$personaplan=new personaplan;
include_once($ruta."class/admplan.php");
$admplan=new admplan;
include_once($ruta."class/estudiante.php");
$estudiante=new estudiante;

include_once($ruta."class/vestudiante.php");
$vestudiante=new vestudiante;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."class/admcontratodelle.php");
$admcontratodelle=new admcontratodelle;
include_once($ruta."funciones/funciones.php");
extract($_POST);
session_start();
$lblcode=ecUrl($idcontrato);
$dpp=$personaplan->muestra($idpersonaplan);
$dpl=$admplan->muestra($dpp['idadmplan']);
$meses=$dpl['meses']; 

if (!isset($idmaterial)) $idmaterial=0; else $idmaterial=1;
$nuevafecha = strtotime ('+'.$meses.' month', strtotime ( $idfechaInicio ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
echo $nuevafecha;
/*************** ACTUALIZAR CONTRATOS ***************************/
//ojo se debera validar que los dias de la fecha actual no exeda los 45 dias
//actualizar contratos para  cuenta el id de organigrama , id semana,
$fechaActual=date("Y-m-d");
$valores=array(
  "cuenta"=>"'$idcuenta'",
  "idpersonaplan"=>"'$idpersonaplan'",
  "fechainicio"=>"'$idfechaprimero'",
  "idpersonaplan"=>"'$idpersonaplan'",
  "fechainvigencia"=>"'$idfechaInicio'",
  "fechafinvigencia"=>"'$nuevafecha'",
  "vigente"=>"'1'",
  "fechaestado"=>"'$fechaActual'",
  "estado"=>"'65'"
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
    "estado"=>"'65'",
    "codigo"=>"'3116'"
  );  
  $admcontratodelle->insertar($valores2);
/****************************************************************/

$valores=array(
	"numcuenta"=>"'$idcuenta'",
	"material"=>"'$idmaterial'",
	"fechainicio"=>"'$idfechaInicio'",
	"fechafin"=>"'$nuevafecha'",
	"observacion"=>"'$idobs'",
  "estado"=>"'1'",
);

if($personaplan->actualizar($valores,$idpersonaplan))
{

$datoE=$vestudiante->mostrarTodo("idpersonaplan= ".$idpersonaplan);
$datoE=array_shift($datoE);

$ru=$datoE['ru'];
$pass=$datoE['pass'];

  $valorEstudiante=array( 
    "ru"=>"'$ru'",
    "pass"=>"'$pass'",
    "estadoacademico"=>"'155'",
    "estadocontrato"=>"'142'",
    "estado"=>"'1'"
  );
  foreach ($estudiante->mostrarTodo("idpersonaplan= ".$idpersonaplan) as $f) {
    $idper = $f['idestudiante'];
    $estudiante->actualizar($valorEstudiante,$idper);
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
      location.href="../material/entrega/?lblcode=<?php echo $lblcode ?>";
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