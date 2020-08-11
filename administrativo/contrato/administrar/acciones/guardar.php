<?php
	$ruta="../../../../";
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	include_once($ruta."class/admcontratodelle.php");
	$admcontratodelle=new admcontratodelle;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
	$fecha=date("Y-m-d");
	$hora=date("H:i:s");
    $valores=array(
	     "idadmejecutivo"=>"'0'",
	     "idtitular"=>"'0'",
	     "estado"=>"'$idaccion'",
	     "fechaestado"=>"'$fecha'"
	);
	if ($admcontrato->actualizar($valores,$idcontrato)) {
		$codigo=0;
		if ($idaccion==60) {
			$codigo=3114;//contratos reutilizables
		}
		elseif ($idaccion==64) {
			$codigo=3115;//contratos anulados
		}
		$valores2=array(
		     "idcontrato"=>$idcontrato,
		     "fecha"=>"'$fecha'",
		     "hora"=>"'$hora'",
		     "detalle"=>"'$idestado'",
		     "estado"=>"'$idaccion'",
		     "codigo"=>"'$codigo'"
		);	
		$admcontratodelle->insertar($valores2);
		/******************************************************/
		/******** Se debera insertar contrato detalle *********/
		?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Record Registrado Correctamente",
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
	}else{
		?>
		<script type="text/javascript">
			Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
		</script>
		<?php		
	}
    
?>