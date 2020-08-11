<?php
	$ruta="../../../";
	include_once($ruta."class/ctbferiado.php");
	$ctbferiado=new ctbferiado;
	include_once($ruta."class/admgestion.php");
	$admgestion=new admgestion;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
    $dgestion=$admgestion->muestra("estado=1");
    $idgestion=$dgestion['idadmgestion'];
    $fechaActual=date("Y-m-d");
    $valores=array(
		"idgestion"=>$idgestion,
		"fecha"=>"'$idfecha'",
		"detalle"=>"'$idobs'",
		"estado"=>"'1'"
	);
	if ($ctbferiado->insertar($valores)) {
		/******************************************************/
		/******** Se debera insertar contrato detalle *********/
		?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Feriado Agregado Correctemnte",
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