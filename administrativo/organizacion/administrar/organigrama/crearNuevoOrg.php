<?php
session_start();
$ruta="../../../../";
include_once($ruta."class/admorgani.php");
$admorgani=new admorgani;
include_once($ruta."class/admsemana.php");
$admsemana=new admsemana;
include_once($ruta."class/admorganidet.php");
$admorganidet=new admorganidet;
include_once($ruta."class/admejecutivo.php");
$admejecutivo=new admejecutivo;

include_once($ruta."funciones/funciones.php");
extract($_POST);
$idorganizacion=dcUrl($idorganizacion);
//registramos un nuevo organigrama
$data=array(
	"idadmorganizacion"=>"'$idorganizacion'",
	"detalle"=>"'$iddesc'",
	"estado"=>"'0'"
);
if($admorgani->insertar($data)){
	$dorg=$admorgani->mostrarUltimo("idadmorganizacion=".$idorganizacion);
	$idOrg=$dorg['idadmorgani'];//id de organigrama a duplicar
	/*****************  REPLICA EL ULTIMO ORGANIGRAMA ACTIVO DE LA ORGANIZACION   ******************************/
		$dorgani=$admorgani->mostrarUltimo("idadmorganizacion=".$idorganizacion." and estado=1");//ultimo organigrama activo
		$idorganigr=$dorgani['idadmorgani'];//se recupera el ultimo org activo
		$dorgdet=$admorganidet->mostrarPrimero("idadmorgani=".$idorganigr." and padre=0");//recup. primer registro de 
		$idinicio=$dorgdet['idadmorganidet'];//id de organigrama
		$idejeUltimo=$dorgdet['idadmejecutivo'];
		/********** INSERTAMOS AL MAXIMO REPRESENTANTE DEL ORGANIGRAMA POR PRIMERA VEZ  *******************/
		$deje=$admejecutivo->muestra($idejecutivo);
		$idcargo=5;//$deje['idcargo'];// cargo por defecto director
		$data=array(
			"padre"=>0,
			"idadmorgani"=>$idOrg,
			"idadmejecutivo"=>$idejeUltimo,
			"idcargo"=>$idcargo
		);
		$admorganidet->insertar($data);
		$dorgDet=$admorganidet->mostrarUltimo("padre=0 and idadmorgani=".$idOrg);
		$idorgdeta=$dorgDet['idadmorganidet'];//obtenemos el ultimo id registrado
		//echo "\n **************** antes de siclar  ************\n";
		//echo "ID INICIO=".$idorgdeta."\n";
	    /*************************** INGRESAMOS AL BUCLE PARA INSERTAR Y DUPLICAR  **********************************/
	    $dato=$admorganidet->mostrarTodo("padre=".$idinicio);
			//(Necesario para ciclar  ,  nuevo id de organizacion, idorganigrama nuevo)
		    if (count($dato)>0)$admorganidet->insertaOrg($idinicio,$idorgdeta,$idOrg);
    	/************************************************************************************************************/
	?>
		<script type="text/javascript">
		swal({
              title: "Exito !!!",
              text: "Ejecutivo Registrado Correctamente",
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
			sweetAlert("Oops...", "No se pudo registrar. Intente de nuevo o consulte con el Dpto. de Sistemas ", "error");
		</script>
	<?php
}

?>