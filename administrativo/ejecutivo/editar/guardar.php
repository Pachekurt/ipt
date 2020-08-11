<?php
session_start();
$ruta="../../../";
include_once($ruta."class/admejecutivo.php");
$admejecutivo=new admejecutivo;
include_once($ruta."class/admorganizacion.php");
$admorganizacion=new admorganizacion;
include_once($ruta."class/historialejecutivo.php");
$historialejecutivo=new historialejecutivo;
extract($_POST);
$dorg=$admorganizacion->muestra($idorg);
$sedeo=$dorg['idsede'];

include_once($ruta."funciones/funciones.php");

$datos = $admejecutivo->muestra($idadmejecutivo);
$fecha ="'".$datos['fechaingreso']."'";
$obs ="'".$datos['obs']."'";
    $copia=array(
    "idadmejecutivo"=>$datos['idadmejecutivo'],
	"idpersona"=>$datos['idpersona'],
	"idorganizacion"=>$datos['idorganizacion'],
    "idcargo"=>$datos['idcargo'],
    "idarea"=>$datos['idarea'],
	"idtipo"=>$datos['idtipo'],
	"fechaingreso"=>$fecha,
	"idhorario"=>$datos['idhorario'],
    "idsede"=>$datos['idsede'],
    "obs"=>$obs,
	"estado"=>$datos['estado'],
);	
if($historialejecutivo->insertar($copia))
{
$idobs=strtoupper($idobs);
$valores=array(
	"idpersona"=>"'$idpersona'",
	"idarea"=>"'$idarea'",
	"idorganizacion"=>"'$idorg'",
	"idcargo"=>"'$idcargo'",
	"idtipo"=>"'$tipoeje'",
	"fechaingreso"=>"'$idfechaingreso'",
	"idhorario"=>'1',
	"estado"=>'1',
	"idsede"=>"'$sedeo'",
	"obs"=>"'$idobs'"
);	
$lblcode=ecUrl($idpersona);

$dato=$admejecutivo->mostrarUltimo("idpersona=".$idpersona);
 
$ideje= $dato['idadmejecutivo'];

// $admejecutivo->eliminar($ideje);

if($admejecutivo->actualizar($valores,$idadmejecutivo))
{
	$dejecutivo=$admejecutivo->mostrarUltimo("idpersona=".$idpersona);
	$idejecutivo=ecUrl($dejecutivo['idadmejecutivo']);
	 
	?>
		<script  type="text/javascript">
	         	swal({
				  title: "Exito !!!",
				  text: "Ejecutivo Registrado",
				  type: "warning",
				  showCancelButton: false,
				  confirmButtonColor: "#16c103",
				  confirmButtonText: "OK",
				  cancelButtonText: "No. Adm. Ejecutivo",
				  closeOnConfirm: false,
				  closeOnCancel: false
				},
				function(isConfirm){ 
				    location.href="ver.php?lblcode=<?php echo $lblcode; ?>" ;  
				});		
		</script>

	<?php
}
else
{
	?>
	<script type="text/javascript">
		Materialize.toast('<span>No se pudo modificar el registro</span>', 1500);
	</script>
	<?php
}
}
else
{
	?>
	<script type="text/javascript">
		Materialize.toast('<span>No se pudo guardar la copia</span>', 1500);
	</script>
	<?php
}
    
?>
    


    