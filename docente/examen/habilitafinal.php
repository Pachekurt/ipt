<?php 
	$ruta="../../";
	include_once($ruta."class/estudiantereserva.php");
	$estudiantereserva=new estudiantereserva;
	include_once($ruta."class/vestudiante.php");
	$vestudiante=new vestudiante;
	include_once($ruta."class/estudiante.php");
	$estudiante=new estudiante;
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
					   "idtipoclase"=>"'2'", //examen
					   "idestudiante"=>"'$idestudiante'",
					   "idmodulo"=>"'$idmodulo'",
					   "idleccion"=>"'$tipo'",
					   "evaluado"=>"'0'",
					   "estado"=>"'0'",
		               "obs"=>"'Examen Generado por docente'"
	);	
	if($estudiantereserva->insertar($valores))
	{
				$valor=array(//"idestudiantecurso"=>"''",
					   "asistio"=>"'5'", //examen
					  	);	
				if($estudiante->actualizar($valor,$idestudiante))
					{
						echo '1';
				}
	}else{
		echo '2';
	}
   }
	
?>