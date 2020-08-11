<?php
session_start();
$ruta="../../";
	include_once($ruta."class/estudiantereserva.php");
	$estudiantereserva=new estudiantereserva;
	include_once($ruta."class/estudiante.php");
	$estudiante=new estudiante;
	include_once($ruta."class/examen.php");
	$examen=new examen;
	include_once($ruta."class/configuracion.php");
	$configuracion=new configuracion;
	include_once($ruta."class/estudiantecurso.php");
	$estudiantecurso=new estudiantecurso;


	$dGramar=$configuracion->mostrar(1);
	$dGramar=array_shift($dGramar);

	$dListening=$configuracion->mostrar(2);
	$dListening=array_shift($dListening);

	$dSpeaking=$configuracion->mostrar(3);
	$dSpeaking=array_shift($dSpeaking);

	$dReading=$configuracion->mostrar(4);
	$dReading=array_shift($dReading);

	$dWriting=$configuracion->mostrar(5);
	$dWriting=array_shift($dWriting);


	$minimo=$configuracion->mostrar(7);
	$minimo=array_shift($minimo);

	extract($_POST);

	$er=$estudiantereserva->mostrar($idestudiantereserva);
    $er=array_shift($er);
    $siguienteModulo=intval($er['idmodulo'])+1;

    $flag=true;
    
   // if ($dGramar['valor']>$gr)$flag=false;
    //if ($dListening['valor']>$li)$flag=false;
   // if ($dSpeaking['valor']>$sp)$flag=false;
   // if ($dReading['valor']>$re)$flag=false;
   // if ($dWriting['valor']>$wr)$flag=false;


    $promedio=(floatval($gr)+floatval($li)+floatval($sp)+floatval($re)+floatval($wr))/5;
    //$requerido=50;

	if ($minimo['valor']>$promedio)$flag=false;

    if ($flag) {
    	$aprobo = 1;
    }
    else{
    	$aprobo = 0;
    }
	
	if ($aprobo==1) 
	{
		$valores=array(

			//"gr"=>"'$gr'",
			//"li"=>"'$li'",
			"sp"=>"'$sp'",
			//"re"=>"'$re'",
			"wr"=>"'$wr'",
			"promedio"=>"'$promedio'",
			"aprobo"=>"'$aprobo'"
		);
		if ($examen->actualizar($valores,$idexamen))
		{
			$valores=array("evaluado"=>"'2'" //ejercicio Corregido
					);
					if ($estudiantereserva->actualizar($valores,$idestudiantereserva))
					{
				       $valores=array("idmodulo"=>"'$siguienteModulo'" //ejercicio Corregido
						);
						if ($estudiante->actualizar($valores,$idestudiante))
						{
							foreach($estudiantecurso->mostrarTodo("idestudiante=".$idestudiante." and estado =1") as $ec)
							{
								$valores=array("estadoexamen"=>"'1'"
								               );
								if ($estudiantecurso->actualizar($valores,$ec['idestudiantecurso']))
								{}
							}
							echo '1';
						}else{
							echo '2';
						}
						
						
					}
		}else{
			echo '2';
		}
	}
	if ($aprobo==0) 
	{
		$valores=array(//"gr"=>"'$gr'",
						//"li"=>"'$li'",
						"sp"=>"'$sp'",
						//"re"=>"'$re'",
						"wr"=>"'$wr'",
						"promedio"=>"'$promedio'",
						"aprobo"=>"'$aprobo'"
		);
		if ($examen->actualizar($valores,$idexamen))
		{
		     $valores=array(
							"evaluado"=>"'2'" //ejercicio Corregido
					);
					if ($estudiantereserva->actualizar($valores,$idestudiantereserva))
					{
						echo '1';
					}else{
						echo '2';
					}
		
		}else{
			echo '2';
		}
	}
		  
?>