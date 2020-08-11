<?php
	$ruta="../../";
	session_start();
	include_once($ruta."class/admautorizacion.php");
	$admautorizacion=new admautorizacion;
	include_once($ruta."funciones/funciones.php");
	extract($_POST);
    /*********** actualiza contrato  ***********/
    $fecha=date("Y-m-d");
	$hora=date("H:i:s");
	$usuario=$_SESSION["codusuario"];
    $valores=array(
	     "usuarioAut"=>"'$usuario'",
	     "fechaAut"=>"'$fecha'",
	     "horaAut"=>"'$hora'",
	     "comentario"=>"'$iddesc'",
	     "estado"=>"$estado"
	);
	if ($admautorizacion->actualizar($valores,$idautorizacion)) {
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