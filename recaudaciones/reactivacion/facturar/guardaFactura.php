<?php
	$ruta="../../../";
	include_once($ruta."class/titular.php");
	$titular=new titular;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
    $valores=array(
	     "nit"=>"'$idnit'",
	     "razon"=>"'$idrazon'"
	);
	if ($titular->actualizar($valores,$idtitular)) {
		/*******************************************/
		?>
			<script  type="text/javascript">
				swal('EXITO','Datos de facturacion modificado correctamente', 'success');
			</script>
		<?php
	}else{
		?>
		<script type="text/javascript">
			Materialize.toast('<span>3: No se pudo guardar el registro</span>', 1500);
		</script>
		<?php
	}
    
?>