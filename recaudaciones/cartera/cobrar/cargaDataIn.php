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
	include_once($ruta."class/ctbdia.php");
	$ctbdia=new ctbdia;
	extract($_GET);
	$dcar=$cobcartera->muestra($idcartera);
  	$idcontrato=$dcar['idcontrato'];
  	$dcp=$vcontratoplan->muestra($idcontrato);
  	// En caso de que el tambien haya monto en dolares
  	if ($dolares>0) {
  		$dct=$ctbdia->mostrarUltimo("estado=1");
  		$tc=number_format($dct['dolar'], 2, '.', '');
  		$dolBol=$dolares*$tc;
  		$bolivianos=$monto;
  		$monto=$dolBol+$monto;
  	}
  	else
  	{
  		$bolivianos=$monto;
  	}
  	//dependiendo ver si el monto es mayor a su cuota mensual
  	$mensualidad=$dcp['mensualidad'];

  	 //adelanto
	$restan=crestantes($dcar['monto']-$dcar['pagadoprod'],$dcar['saldo'],$dcp['cuotas']);
	$totalCuotas=$dcp['cuotas']+1;
	$cuota=$dcp['cuotas']-$restan;
	$pag2=$dcp['mensualidad']*$cuota;
	$pag1=$dcar['monto']-$dcar['pagadoprod']-$dcar['saldo'];
	$adelanto=$pag1-$pag2;
	$adelantoG=$adelanto;

  	if($monto>=$mensualidad-$adelanto) {
  		//Adelantara mas de una cuota
  		if ($monto>$dcar['saldo']) {
  			//echo "Es mayor";
  			// tiene que mandar solo la cuota que le corresponde
  			$montoPagado=$mensualidad;
  			$descontable=$mensualidad;
  			$cuotas=1;
  			// proximo vencimiento ejecutamos el procedimiento. Se debera trabajar con la fecha de inicio para ver que dias de pago selecciono la persona.
			//condicionamos la fecha inicio
			$dia=date("d", strtotime($dcar['fechainicio']));
			$aniomes=date("Y-m", strtotime($dcar['fechaproxve'])); 
			$fechapartida=$aniomes."-".$dia;//fecha condicionada
			$cobcartera->sqlProc("call duartema_nacional.spproxvence('".$fechapartida."', $cuotas, @fechaprox);");
			$dataCall=$cobcartera->sql("select @fechaprox as fecha;");
			$dataCall=array_shift($dataCall);
			$fechaproxven=$dataCall['fecha'];
			/***********************************************************************************************************/
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
			$denlace=$admenlace->mostrarUltimo("codigo=$codigo");
			$txtoperacion=$denlace['detalle'];
			$indicador=1;
		  	$msg="ERROR. El monto no puede ser mayor al saldo.";
  		}
  		else{
			//echo "Adelnato: ".$adelanto."\n";
			
  			$montoPagado=$bolivianos;
	  		$restante=$monto+$adelanto;
	  		$descontable=0;
	  		$cuotas=0;
	  		while ($restante > 0) {
	  			if ($restante-$mensualidad>=0) {
	  				$restante=$restante-$mensualidad;
	  				$descontable=$descontable+$mensualidad;
	  				$cuotas++;
	  			}
	  			else{
	  				$adelanto=$restante+$adelantoG;
	  				$restante=0;
	  			}
	  		}
	  		$descontable=$descontable-$adelantoG;
	  		$adelanto=$adelanto-$adelantoG;

	  		// proximo vencimiento ejecutamos el procedimiento. Se debera trabajar con la fecha de inicio para ver que dias de pago selecciono la persona.
			//condicionamos la fecha inicio
			$dia=date("d", strtotime($dcar['fechainicio']));
			$aniomes=date("Y-m", strtotime($dcar['fechaproxve'])); 
			$fechapartida=$aniomes."-".$dia;//fecha condicionada
			$cobcartera->sqlProc("call duartema_nacional.spproxvence('".$fechapartida."', $cuotas, @fechaprox);");
			$dataCall=$cobcartera->sql("select @fechaprox as fecha;");
			$dataCall=array_shift($dataCall);
			$fechaproxven=$dataCall['fecha'];
			/***********************************************************************************************************/
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
			if ($monto==$dcar['saldo']) {
				$codigo=3217;
			}
			$denlace=$admenlace->mostrarUltimo("codigo=$codigo");
			$txtoperacion=$denlace['detalle'];
			/*
		  		echo "Cuotas: ".$cuotas."\n";
		  		echo "Adelanto: ".$adelanto."\n";
		  		echo "Descontable: ".$descontable."\n";
		  		echo "Prox Vence: ".$fechaproxven."\n";
			*/
		  	$indicador=0;
		  	$msg="Generado correctamente";
	  	}
  	}else{
  		//Solo adelantara para cuota
  		$montoPagado=$bolivianos;
  		$descontable=0;
  		$adelanto=$monto;
  		$indicador=1;
  		$cuotas=0;
		$msg="ADELATO. Solo se adelantara el monto ingresado";
		switch ($dcar['estado']) {
			case 131:// vigente
				$codigo=3214;
				break;
			case 133://vencido
				$codigo=3215;
				break;
			case 134://perjuridica
				$codigo=3216;
				break;
		}
		$denlace=$admenlace->mostrarUltimo("codigo=$codigo");
		$txtoperacion=$denlace['detalle'];
		$fechaproxven=$dcar['fechaproxve'];
  	}

	/******************** DATOS PREPARADOS  ***************************/
	$arrayJSON['ind']=$indicador;
	$arrayJSON['msg']=$msg;
	$arrayJSON['monto']=$montoPagado;
	$arrayJSON['descontable']=$descontable;
	$arrayJSON['adelanto']=$adelanto;
	$arrayJSON['cuotas']=$cuotas;
	$arrayJSON['proxvence']=$fechaproxven;
	$arrayJSON['operacion']=$codigo;
	$arrayJSON['txtoperacion']=$txtoperacion;
	echo json_encode($arrayJSON); 
	/*****************************************************************/

?>