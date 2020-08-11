<?php
	$ruta="../../../";
	include_once($ruta."class/invcategoria.php");
	$invcategoria=new invcategoria;

	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
    /*********** actualiza contrato  ***********/
    $valores=array(
	     "idcategoria"=>"'$idcategoria'",
	     "nombre"=>"'$idnombre'",
	     "descripcion"=>"'$iddesc'"
	);
	if ($invcategoria->actualizar($valores,$iditem)) {
		?>
			<script  type="text/javascript">
				swal("EXITO","Datos guardados correctamente","success");
			</script>
		<?php
	}else{
		?>
		<script type="text/javascript">
			swal("ERROR","No se pudo guardar","error");
		</script>
		<?php		
	}
    
?>