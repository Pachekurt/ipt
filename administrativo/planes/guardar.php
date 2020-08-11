<?php
	$ruta="../../";
	include_once($ruta."class/admplanes.php");
	$admplanes=new admplanes;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
    /*********** actualiza contrato  ***********/
    $valores=array(
	     "nombre"=>"'$idnombre'",
	     "fechainicio"=>"'$idfinicio'",
	     "fechafin"=>"'$idffin'",
	     "observaciones"=>"'$idobs'",
	     "estado"=>"'0'"
	);
	if ($admplanes->insertar($valores)) {
		?>
			<script  type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Registrado Correctamente",
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