<?php
	$ruta="../../../";
	include_once($ruta."class/invcategoria.php");
	$invcategoria=new invcategoria;

	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
	$fecha=date("Y-m-d");
	$hora=date("H:i:s");
    $valores=array(
	     "idcategoria"=>"'$idcategoria'",
	     "nombre"=>"'$idnombre'",
	     "descripcion"=>"'$iddesc'"
	);
	if ($invcategoria->insertar($valores)) {
		/******** Se debera insertar contrato detalle *********/
		$ditem=$invcategoria->mostrarUltimo("nombre='$idnombre'");
		$iditem=$ditem['idinvcategoria'];
		$lblcode=ecUrl($iditem);
		?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Datos guardados correctamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#28e29e",
					confirmButtonText: "OK",
					closeOnConfirm: false
		        }, function () {  
		            location.href="../editar/?lblcode=<?php echo $lblcode ?>";
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