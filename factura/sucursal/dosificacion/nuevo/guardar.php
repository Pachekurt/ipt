<?php 
	$ruta="../../../../";
	include_once($ruta."class/admdosificacion.php");
	$admdosificacion=new admdosificacion;
	extract($_POST);
	session_start();
	$valores1=array(
	     "estado"=>"0"
	);	
	$admdosificacion->actualizarFila($valores1,"idadmsucursal=$lblcode");
	$valores=array(
		 "idadmsucursal"=>"'$lblcode'",
	     "autorizacion"=>"'$idnumaut'",
	     "llave"=>"'$idllave'",
	     "fechalimite"=>"'$idfecha'",
	     "inicial"=>"'$idInicial'",
	     "nro"=>"'$idInicial'",
	     "tramite"=>"'$idtramite'",
	     "leyenda"=>"'$idleyenda'",
	     "estado"=>"'1'"
	);
	if($admdosificacion->insertar($valores))
	{
		?>
			<script  type="text/javascript">
				swal({
		              title: "Exito !!!",
		              text: "Dosificacion Creada Correctamente",
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

?>