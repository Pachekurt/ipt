<?php
	$ruta="../../";
	include_once($ruta."class/cobcartera.php");
	$cobcartera=new cobcartera;
	include_once($ruta."funciones/funciones.php");
	session_start();
    $fecha=date("Y-m-d");
    $i=0;
    foreach($cobcartera->mostrarTodo("saldo>0") as $f)
    {
		$dias= diferenciaDias($f['fechaproxve'], $fecha);
		if ($dias>0) {
			$estado=133;
			$diasmora=$dias;
		}
		else{
			$estado=131;
			$diasmora=0;
		}
		$valores=array(
			"diasmora"=>"'$diasmora'",
		  	"estado"=>"'$estado'"
		);
		if($cobcartera->actualizar($valores,$f['idcobcartera'])){
			$i++;
		}
	}
    ?>
		<script  type="text/javascript">
			cantidad="<?php echo $i ?>";
			swal({
	              title: "Exito !!!",
	              text: cantidad+" Cuentras reclasificadas",
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