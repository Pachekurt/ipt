<?php
	$ruta="../../";
	include_once($ruta."class/ctbdia.php");
	$ctbdia=new ctbdia;
	include_once($ruta."class/admgestion.php");
	$admgestion=new admgestion;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
    $dgestion=$admgestion->muestra("estado=1");
    $idgestion=$dgestion['idadmgestion'];
    $fechaActual=date("Y-m-d");
    $valoresANTES=array(
		"estado"=>"'2'"
	); 
	$ctbdia->actualizarFila($valoresANTES,"idgestion=".$idgestion);
    $valores=array(
		"idgestion"=>$idgestion,
		"fecha"=>"'$fechaActual'",
		"dolar"=>"'$iddolar'",
		"estado"=>"'1'"
	);
	if ($ctbdia->insertar($valores)) {
		/******************************************************/
		/******** Se debera insertar contrato detalle *********/
		?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Dia Iniciado Correctemnte",
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