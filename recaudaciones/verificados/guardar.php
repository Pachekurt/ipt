<?php
	$ruta="../../";
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	include_once($ruta."class/admcontratodelle.php");
	$admcontratodelle=new admcontratodelle;
	include_once($ruta."class/vcontratoplan.php");
	$vcontratoplan=new vcontratoplan;
	include_once($ruta."class/cobcartera.php");
	$cobcartera=new cobcartera;
	include_once($ruta."class/admsemana.php");
	$admsemana=new admsemana;
	session_start();
    $numero=$_POST["numero"];
	extract($_POST);
	$dsemana=$admsemana->mostrarUltimo("estado=1");
	$idsemana=$dsemana['idadmsemana'];
    $count = count($numero);
    for ($i = 0; $i < $count; $i++) {
	    /*********** actualiza contrato ************/
	    $valores=array(
	    	"cartera"=>"'1'"
		);
		$admcontrato->actualizar($valores,$numero[$i]);
		/*******************************************/
		/******** inserta contrato detalle *********/
		$dcont=$admcontrato->muestra($numero[$i]);
		$dcp=$vcontratoplan->muestra($dcont['idadmcontrato']);
		$saldo=$dcp['inversion']-$dcont['pagado'];
		$valores2=array( 
	     	"idejecutivo"=>"'$idejecutivo'",
	     	"idcontrato"=>$numero[$i],
	     	"idsede"=>"'".$dcont['idsede']."'",
			"fechainicio"=>"'".$dcont['fechainicio']."'",
			"fechavence"=>"'".$dcont['fechainicio']."'",
			"fechaultpago"=>"'".$dcont['fechainicio']."'",
			"fechaproxve"=>"'".$dcont['fechainicio']."'",
			"monto"=>"'".$dcp['inversion']."'",
			"pagadoprod"=>"'".$dcont['pagado']."'",
			"saldo"=>"'$saldo'",
			"cuotas"=>"'".$dcp['cuotas']."'",
			"diasmora"=>"'0'",
			"estado"=>"'131'"
		);	
		$cobcartera->insertar($valores2);
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