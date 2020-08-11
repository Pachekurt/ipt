<?php 
	$ruta="../../../";
	include_once($ruta."class/admcontratogen.php");
	$admcontratogen=new admcontratogen;
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	extract($_POST);
	session_start();
	$contador=0;
	$literal="Numero de Contratos";
	for ($i=$idInicial; $i <=$idFinal ; $i++) { 
		$dcantidad=$admcontrato->mostrarTodo("nrocontrato=$i and idsede=$idsede");
		if (count($dcantidad)>0) {
			$contador++;
			$literal=$literal.", $i";
		}
	}
	if ($contador>0) {
		?>
			<script type="text/javascript">
				sweetAlert("Oops...", "<?php echo $literal ?> Repetidos. No se puede registrar ", "error");
			</script>
		<?php
	}
	else{
		$valores=array(
		     "inicial"=>"'$idInicial'",
		     "final"=>"'$idFinal'",
		     "idsede"=>"'$idsede'",
		     "obs"=>"'$idobs'"
		);	
		if($admcontratogen->insertar($valores))
		{
			$dcontra=$admcontratogen->mostrarUltimo("inicial=$idInicial");
			for ($i=$idInicial; $i <=$idFinal ; $i++) { 
				$val2=array(
				     "idcontratogen"=>$dcontra['idadmcontratogen'],
				     "nrocontrato"=>"'$i'",
				     "idsede"=>"'$idsede'",
				     "estado"=>"'60'",
				     "eshabil"=>"'1'"
				);
				$admcontrato->insertar($val2);
			}
			?>
				<script  type="text/javascript">
				
					swal({
			              title: "Exito !!!",
			              text: "Datos Registrados Correctamente",
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
		}
		else
		{
			?>
			<script type="text/javascript">
				Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
			</script>
			<?php
		}
	}
?>