<?php
	$ruta="../../../";
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	include_once($ruta."class/admcontratodelle.php");
	$admcontratodelle=new admcontratodelle;
	include_once($ruta."class/vejecutivo.php");
	$vejecutivo=new vejecutivo;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
    $dcont=$admcontrato->mostrarUltimo("nrocontrato=$nrocontrato");
  	$idcontrato=$dcont['idadmcontrato'];
  	$estado=$dcont['estado'];
  	$idejeAnt=$dcont['idadmejecutivo'];
  	$dejeAnt=$vejecutivo->muestra($idejeAnt);
  	$dejeAct=$vejecutivo->muestra($idejecutivo);
	$fecha=date("Y-m-d");
	$hora=date("H:i:s");
    $valores=array(
	     "idadmejecutivo"=>"'$idejecutivo'",
	     "fechaestado"=>"'$fecha'"
	);
	if ($admcontrato->actualizar($valores,$idcontrato)) {
		$codigo=3124;
		$detalle="Cambio de ejecutivo de ".$dejeAnt['nombre']." ".$dejeAnt['paterno']." ".$dejeAnt['materno']." a ".$dejeAct['nombre']." ".$dejeAct['paterno']." ".$dejeAct['materno'].". MOTIVO: ".$iddesc;
		$valores2=array(
		     "idcontrato"=>$idcontrato,
		     "fecha"=>"'$fecha'",
		     "hora"=>"'$hora'",
		     "detalle"=>"'$detalle'",
		     "estado"=>"'$estado'",
		     "codigo"=>"'$codigo'"
		);	
		$admcontratodelle->insertar($valores2);
		/******************************************************/
		/******** Se debera insertar contrato detalle *********/
		?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Ejecutivo Cambiado Correctamente",
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
	}else{
		?>
		<script type="text/javascript">
			Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
		</script>
		<?php		
	}
    
?>