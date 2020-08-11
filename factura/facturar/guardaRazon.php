<?php
	$ruta="../../";
	include_once($ruta."class/factcliente.php");
	$factcliente=new factcliente;
	include_once($ruta."funciones/funciones.php");
	extract($_GET);
	if ($idcliente==0) {
		$valores=array(
			"nit"=>"'$idnit'",
			"razon"=>"'$idrazon'"
		);
		if ($factcliente->insertar($valores)) {
			$dcli=$factcliente->mostrarUltimo("nit='$idnit'");
			$idcli=$dcli['idfactcliente'];
		/*******************************************/
			$arrayJSON['flag']=1;
			$arrayJSON['idcliente']=$idcli;
			$arrayJSON['msg']="Cliente Registrado Correctamente";
			echo json_encode($arrayJSON); 
		}else{
			$arrayJSON['flag']=0;
			$arrayJSON['msg']="No se pudo registrar el Cliente";
			$arrayJSON['idcliente']=0;
			echo json_encode($arrayJSON); 	
		}
	}
    
    
?>