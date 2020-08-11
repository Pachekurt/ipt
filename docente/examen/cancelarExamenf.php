<?php 
	$ruta="../../";
	include_once($ruta."class/estudiantereserva.php");
	$estudiantereserva=new estudiantereserva;
	include_once($ruta."class/examenfinal.php");
	$examenfinal=new examenfinal;
	include_once($ruta."class/estudiante.php");
	$estudiante=new estudiante;
	extract($_POST);
	session_start();

$ider=$estudiantereserva->mostrarTodo("idestudiante= ".$idest." and evaluado = 0");
$ider= array_shift($ider);

$variable =$ider['idestudiantereserva'];

    $ex=$examenfinal->mostrarTodo("idestudiantereserva=".$variable);
	if (count($ex)>0) 
	{
		echo '3';
	}else{
			$valores=array("evaluado"=>"'3'",
					   
			);	
			if($estudiantereserva->actualizar($valores,$variable))
			{

   				 
						 			$valor=array(//"idestudiantecurso"=>"''",
								   "asistio"=>"'0'", //examen
								  	);	
							if($estudiante->actualizar($valor,$idest))
								{
									echo '1';
							}
			}else{
			 echo $variable;
			}
	}

   	
	
?>