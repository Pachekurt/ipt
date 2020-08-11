<?php 
	$ruta="../../";
	include_once($ruta."class/estudiantereserva.php");
	$estudiantereserva=new estudiantereserva;
	include_once($ruta."class/vestudiante.php");
	$vestudiante=new vestudiante;
	extract($_POST);
	session_start();
   $fechaactual=date('Y-m-d');
  $es=$vestudiante->mostrar($idestudiante);
  $es=array_shift($es);
  $idmodulo=$es['idmodulo'];
  $cantidad=$estudiantereserva->mostrarTodo("idestudiante=".$idestudiante." and idtipoclase=1 and evaluado=0");
   if (count($cantidad)>0) 
   {   	
   	echo '3';
   }else{
   		$valores=array(//"idestudiantecurso"=>"''",
					   "idtipoclase"=>"'1'", //examen
					   "idestudiante"=>"'$idestudiante'",
					   "idmodulo"=>"'$idmodulo'",
					   "evaluado"=>"'0'",
					   "estado"=>"'0'",
		               "obs"=>"'Examen Generado por docente'"
	);	
	if($estudiantereserva->insertar($valores))
	{
		echo '1';
	}else{
		echo '2';
	}
   }
	
?>