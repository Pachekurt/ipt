<?php
session_start();
$ruta="../../";
	include_once($ruta."class/estudiantereserva.php");
	$estudiantereserva=new estudiantereserva;
	include_once($ruta."class/estudiante.php");
	$estudiante=new estudiante;
	include_once($ruta."class/examenfinal.php");
	$examenfinal=new examenfinal;
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
  

    $flag=true;
    $idestudiante=$idestudianteSel3;
   // if ($dGramar['valor']>$gr)$flag=false;
    //if ($dListening['valor']>$li)$flag=false;
   // if ($dSpeaking['valor']>$sp)$flag=false;
   // if ($dReading['valor']>$re)$flag=false;
   // if ($dWriting['valor']>$wr)$flag=false;


   // $promedio=(floatval($gr)+floatval($li)+floatval($sp)+floatval($re)+floatval($wr))/5;
    //$requerido=50;

	if ($minimo['valor']>$idnota3)$flag=false;

    if ($flag) {
    	$aprobo = 1;
    }
    else{
    	$aprobo = 0;
    }
	
	if ($aprobo==1) 
	{
		$valoresexamen=array(

			"idestudiante"=>"'$idestudiante'",
			 
			"idleccion"=>"'4'",
			"idmodulo"=>"'10'",
			"asignatura"=>"'finalspeech'",
			"promedio"=>"'$idnota3'",
			"aprobo"=>"'$aprobo'"
		);
		if ($examenfinal->insertar($valoresexamen))
		{
			 
					 
				       $valores=array(
							//"estadoacademico"=>"'150'",
							"examenfinal"=>"'5'" //ejercicio Corregido
						);
						if ($estudiante->actualizar($valores,$idestudiante))
						{
							
							echo '1';
						}else{
							echo '2';
						}
						
						
					}
		 
	} 
		  
?>