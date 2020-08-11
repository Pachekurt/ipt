<?php 
	$ruta="../../../../../";
	include_once($ruta."class/admlibrocontrato.php");
	$admlibrocontrato=new admlibrocontrato;

	include_once($ruta."funciones/funciones.php");

	session_start();
    $numero=$_POST["numero"];
	extract($_POST);

	//$rolmenu->eliminarTodo("idrol=".$idrol);
    $count = count($numero);
    for ($i = 0; $i < $count; $i++) {
		$valores2=array(
	     	"idcontrato"=>"'$idcontrato'",
	     	"idlibro"=>$numero[$i]
		);	
		$admlibrocontrato->insertar($valores2);
		/*******************************************/
    }
    ?>
		<script  type="text/javascript">
			swal({
				title: "Exito !!!",
				text: "Cuentas Asignadas Correctamente",
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
?>