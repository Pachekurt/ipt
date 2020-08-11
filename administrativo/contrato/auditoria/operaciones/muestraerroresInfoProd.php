<?php 
	$ruta="../../../../";
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	include_once($ruta."class/vtitular.php");
	$vtitular=new vtitular;
	include_once($ruta."class/domicilio.php");
	$domicilio=new domicilio;
	include_once($ruta."class/laboral.php");
	$laboral=new laboral;
	include_once($ruta."class/admplan.php");
	$admplan=new admplan;
	include_once($ruta."class/personaplan.php");
	$personaplan=new personaplan;
	include_once($ruta."class/vvinculado.php");
	$vvinculado=new vvinculado;

	extract($_GET);
	$arrayName = array();
	$dcontrato=$admcontrato->muestra($idcontrato);
	$dtit=$vtitular->muestra($dcontrato['idtitular']);
	$idpersona=$dtit['idpersona'];
  	$ddom=$domicilio->mostrarUltimo("idpersona=".$idpersona." and (indicador>0 or tipoDomicilio='PRINCIPAL')");
  	$dlab=$laboral->mostrarUltimo("idpersona=".$idpersona." and (indicador>0 or tipolaboral='PRINCIPAL')");

  	$contador=0;
	//DATOS DE CPERSONA REGISTRAR TITULAR
		if ($dtit['paterno']=="") {
			//Apellido Paterno
			$contador++;
			$val4=array(
				"idtabla"=>$dtit['idvtitular'],
				"tabla"=>"Persona",
				"nro"=>$contador,
				"dato"=>"Persona ",
				"detalle"=>"No se se registró Apellido Paterno"
			);
		    array_push($arrayName,$val4);
		}
		//Apellido Materno
		if ($dtit['materno']=="") {
			//Apellido Paterno
			$contador++;
			$val4=array(
				"idtabla"=>$dtit['idvtitular'],
				"tabla"=>"Persona",
				"nro"=>$contador,
				"dato"=>"Persona ",
				"detalle"=>"No se se registró Apellido Materno"
			);
		    array_push($arrayName,$val4);
		}
		//Fecha Nacimiento
		//Email
		if ($dtit['email']=="") {
			//Apellido Paterno
			$contador++;
			$val4=array(
				"idtabla"=>$dtit['idvtitular'],
				"tabla"=>"Persona",
				"nro"=>$contador,
				"dato"=>"Persona ",
				"detalle"=>"No se se registró Email"
			);
		    array_push($arrayName,$val4);
		}
		//Celular
		if ($dtit['celular']=="") {
			//Apellido Paterno
			$contador++;
			$val4=array(
				"idtabla"=>$dtit['idvtitular'],
				"tabla"=>"Persona",
				"nro"=>$contador,
				"dato"=>"Persona ",
				"detalle"=>"No se se registró Celular"
			);
		    array_push($arrayName,$val4);
		}
		//Razon Social
		if ($dtit['razon']=="") {
			//Apellido Paterno
			$contador++;
			$val4=array(
				"idtabla"=>$dtit['idvtitular'],
				"tabla"=>"Persona",
				"nro"=>$contador,
				"dato"=>"Persona ",
				"detalle"=>"No se se registró Razon Social"
			);
		    array_push($arrayName,$val4);
		}
		//Nit
		if ($dtit['nit']=="") {
			//Apellido Paterno
			$contador++;
			$val4=array(
				"idtabla"=>$dtit['idvtitular'],
				"tabla"=>"Persona",
				"nro"=>$contador,
				"dato"=>"Persona ",
				"detalle"=>"No se se registró Nit"
			);
		    array_push($arrayName,$val4);
		}
	//DATOS DMOCILIO
		if (count($ddom)>0) {
			if ($ddom['idbarrio']=="") {
				$contador++;
				$val4=array(
					"idtabla"=>$ddom['iddomicilio'],
					"tabla"=>"domicilio",
					"nro"=>$contador,
					"dato"=>"Domicilio",
					"detalle"=>"No se registró Zona"
				);
			    array_push($arrayName,$val4);
			}
			if ($ddom['nombre']=="") {
				$contador++;
				$val4=array(
					"idtabla"=>$ddom['iddomicilio'],
					"tabla"=>"domicilio",
					"nro"=>$contador,
					"dato"=>"Domicilio",
					"detalle"=>"No se registró Direccion"
				);
			    array_push($arrayName,$val4);
			}
			if ($ddom['telefono']=="") {
				$contador++;
				$val4=array(
					"idtabla"=>$ddom['iddomicilio'],
					"tabla"=>"domicilio",
					"nro"=>$contador,
					"dato"=>"Domicilio",
					"detalle"=>"No se registró Telefono"
				);
			    array_push($arrayName,$val4);
			}

		}else{
			$contador++;
			$val4=array(
				"idtabla"=>0,
				"tabla"=>"domicilio",
				"nro"=>$contador,
				"dato"=>"Domicilio",
				"detalle"=>"NO SE REGISTRO UN DOMICILIO PRINCIPAL"
			);
		    array_push($arrayName,$val4);
		}
	//DATOS LABORALES
		if (count($dlab)>0) {
			if ($dlab['idbarrio']=="") {
				$contador++;
				$val4=array(
					"idtabla"=>$dlab['idlaboral'],
					"tabla"=>"laboral",
					"nro"=>$contador,
					"dato"=>"Laboral",
					"detalle"=>"No se registró Zona"
				);
			    array_push($arrayName,$val4);
			}
			if ($dlab['nombre']=="") {
				$contador++;
				$val4=array(
					"idtabla"=>$dlab['idlaboral'],
					"tabla"=>"laboral",
					"nro"=>$contador,
					"dato"=>"Laboral",
					"detalle"=>"No se registró Direccion"
				);
			    array_push($arrayName,$val4);
			}
			if ($dlab['telefono']=="") {
				$contador++;
				$val4=array(
					"idtabla"=>$dlab['idlaboral'],
					"tabla"=>"laboral",
					"nro"=>$contador,
					"dato"=>"Laboral",
					"detalle"=>"No se registró Telefono"
				);
			    array_push($arrayName,$val4);
			}

		}else{
			$contador++;
			$val4=array(
				"idtabla"=>0,
				"tabla"=>"laboral",
				"nro"=>$contador,
				"dato"=>"Laboral",
				"detalle"=>"NO SE REGISTRO EL LUGAR DE TRABAJO PRINCIPAL"
			);
		    array_push($arrayName,$val4);
		}
	//PLAN
		$perPlan=$personaplan->mostrarUltimo("idcontrato=$idcontrato");
		if (count($perPlan)>0){
			$cont=0;
			foreach($vvinculado->mostrarTodo("idpersonaplan=".$perPlan['idpersonaplan']) as $f){
				$cont++;
				if ($f['paterno']=="") {
					//Apellido Paterno
					$contador++;
					$val4=array(
						"idtabla"=>$f['idvvinculado'],
						"tabla"=>"beneficiario",
						"nro"=>$contador,
						"dato"=>"Beneficiario",
						"detalle"=>"No se se registró Apellido Paterno"
					);
				    array_push($arrayName,$val4);
				}
				//Apellido Materno
				if ($f['materno']=="") {
					$contador++;
					//Apellido Paterno
					$val4=array(
						"idtabla"=>$f['idvvinculado'],
						"tabla"=>"beneficiario",
						"nro"=>$contador,
						"dato"=>"Beneficiario",
						"detalle"=>"No se se registró Apellido Materno"
					);
				    array_push($arrayName,$val4);
				}
			}
			$dplan=$admplan->muestra($perPlan['idadmplan']);
			if ($cont<$dplan['personas']) {
				$contador++;
				# code...
				$val4=array(
					"idtabla"=>$perPlan['idpersonaplan'],
					"tabla"=>"plan",
					"nro"=>$contador,
					"dato"=>"Plan",
					"detalle"=>"No se registró a ".($dplan['personas']-$cont)." Beneficiario(s)"
				);
			    array_push($arrayName,$val4);
			}
		}else{
			$contador++;
			$val4=array(
				"idtabla"=>0,
				"tabla"=>"plan",
				"nro"=>$contador,
				"dato"=>"PLAN",
				"detalle"=>"NO SE ASIGNO UN PLAN AL TITULAR"
			);
		    array_push($arrayName,$val4);
		}
	$arreglo['data']=$arrayName;
	echo json_encode($arreglo);
	

?>