<?php
	$ruta="../../../";
	include_once($ruta."class/admplan.php");
	$admplan=new admplan;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
	session_start();
	$idplanes=dcUrl($lblcode);
    /*********** actualiza contrato  ***********/
    $valores=array(
    	 "idadmplanes"=>"'$idplanes'",
	     "nombre"=>"'$idnombre'",
	     "inversion"=>"'$idtotal'",
	     "pagoinicial"=>"'$idinicial'",
	     "mensualidad"=>"'$idmensual'",
	     "cuotas"=>"'$idcuotas'",
	     "personas"=>"'$idpersonas'",
	     "estado"=>"'1'"
	);
	if ($admplan->insertar($valores)) {
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