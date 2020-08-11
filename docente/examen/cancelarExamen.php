<?php 
	$ruta="../../";
	include_once($ruta."class/estudiantereserva.php");
	$estudiantereserva=new estudiantereserva;
	include_once($ruta."class/examen.php");
	$examen=new examen;
	extract($_POST);
	session_start();

    $ex=$examen->mostrarTodo("idestudiantereserva=".$idestudiantereserva);
	if (count($ex)>0) 
	{
		echo '3';
	}else{
			$valores=array("evaluado"=>"'3'",
					   
			);	
			if($estudiantereserva->actualizar($valores,$idestudiantereserva))
			{
			 echo '1';
			}else{
			 echo '2';
			}
	}

   	
	
?>