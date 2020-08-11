<?php
	$ruta="../../../";
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	include_once($ruta."class/admcontratodelle.php");
	$admcontratodelle=new admcontratodelle;
	include_once($ruta."class/admsemana.php");
	$admsemana=new admsemana;
	session_start();
	extract($_POST);
	$dsemana=$admsemana->mostrarUltimo("estado=1");
	$idsemana=$dsemana['idadmsemana'];
    $numero=$_POST["numero"];
    $count = count($numero);
    for ($i = 0; $i < $count; $i++) {
	    /*********** actualiza contrato  ***********/
	    $fecha=date("Y-m-d");
		$hora=date("H:i:s");
	    $valores=array(
		     "idadmejecutivo"=>"'$idejecutivo'",
		     "estado"=>"'61'",
		     "fechaestado"=>"'$fecha'"
		);
		$admcontrato->actualizar($valores,$numero[$i]);
		/*******************************************/
		/******** inserta contrato detalle *********/
		$valores2=array(
		     "idcontrato"=>$numero[$i],
		     "idejecutivo"=>"'$idejecutivo'",
		     "fecha"=>"'$fecha'",
		     "hora"=>"'$hora'",
		     "idsemana"=>"'$idsemana'",
		     "detalle"=>"'$iddesc'",
		     "estado"=>"'61'",
		     "codigo"=>"'3111'"
		);	
		$admcontratodelle->insertar($valores2);
		/*******************************************/
    }
    ?>
		<script  type="text/javascript">
			swal({
	              title: "Exito !!!",
	              text: "Contratos Asignados Correctamente",
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