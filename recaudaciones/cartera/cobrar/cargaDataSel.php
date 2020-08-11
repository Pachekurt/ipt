<?php 
	$ruta="../../../";
	include_once($ruta."class/admplan.php");
	$admplan=new admplan;
	include_once($ruta."class/cobcartera.php");
	$cobcartera=new cobcartera;
	include_once($ruta."class/vcontratoplan.php");
	$vcontratoplan=new vcontratoplan;
	include_once($ruta."class/admenlace.php");
	$admenlace=new admenlace;
	extract($_GET);
	$dcar=$cobcartera->muestra($idcartera);
  	$idcontrato=$dcar['idcontrato'];
  	$dcp=$vcontratoplan->muestra($idcontrato);

	// monto a pagar es la cantidad de cuotas * el monto mensual
	$monto=$dcp['mensualidad']*$cuotas;
	// monto descontable es monto a pagar
	// adelanto es pero ver si tiene un adelanto anterior mantiene el adelanto anterior
		$restan=crestantes($dcar['monto']-$dcar['pagadoprod'],$dcar['saldo'],$dcp['cuotas']);
		$cuota=$dcp['cuotas']-$restan;
		$pag2=$dcp['mensualidad']*$cuota;
		$pag1=$dcar['monto']-$dcar['pagadoprod']-$dcar['saldo'];
		$adelanto=$pag1-$pag2;
	// cuotas canceladas es la misma cuotas a pagar
	// proximo vencimiento ejecutamos el procedimiento. Se debera trabajar con la fecha de inicio para ver que dias de pago selecciono la persona.
		//condicionamos la fecha inicio
		$dia=date("d", strtotime($dcar['fechainicio']));
		$aniomes=date("Y-m", strtotime($dcar['fechaproxve'])); 
		$fechapartida=$aniomes."-".$dia;//fecha condicionada
		$cobcartera->sqlProc("call duartema_nacional.spproxvence('".$fechapartida."', $cuotas, @fechaprox);");
		$dataCall=$cobcartera->sql("select @fechaprox as fecha;");
		$dataCall=array_shift($dataCall);
		$fechaproxven=$dataCall['fecha'];
	// operacion es el codigo de enlace deacuerdo al estado de la cuenta
		$codigo=0;
		if ($dcar['saldo']-$monto<=0) {
			$codigo=3217;
		}
		else{
			switch ($dcar['estado']) {
				case 131:// vigente
					$codigo=3211;
					break;
				case 133://vencido
					$codigo=3212;
					break;
				case 134://perjuridica
					$codigo=3213;
					break;
			}
		}
	$denlace=$admenlace->mostrarUltimo("codigo=$codigo");
	$arrayJSON['monto']=$monto;
	$arrayJSON['descontable']=$monto;
	$arrayJSON['adelanto']=$adelanto;
	$arrayJSON['cuotas']=$cuotas;
	$arrayJSON['proxvence']=$fechaproxven;
	$arrayJSON['operacion']=$codigo;
	$arrayJSON['txtoperacion']=$denlace['detalle'];
	echo json_encode($arrayJSON); 

?>