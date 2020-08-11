<?php
$ruta="../../";

session_start();
include_once($ruta."class/examen.php");
$examen=new examen;
include_once($ruta."class/pregunta.php");
$pregunta=new pregunta;
include_once($ruta."class/examendetalle.php");
$examendetalle=new examendetalle;
include_once($ruta."class/referencia.php");
$referencia=new referencia;
include_once($ruta."class/configuracion.php");
$configuracion=new configuracion;

extract($_POST);

$con=$configuracion->mostrarTodo("short='LS'");
$con=array_shift($con);
$cantidadLS=intval($con['cantpregunta']);

$ex=$examen->mostrar($idexamen);
$ex=array_shift($ex);
$idmodulo=$ex['idmodulo'];

$horaActual=date("H:i:s");
//implementar con la tabla

$cantidad=$examendetalle->mostrarTodo("idexamen=".$idexamen." and asignatura='listening'");

if(count($cantidad)>0)
{
//ya se genero el examen del alumno
	$valor=array("horalistening"=>"'$horaActual'",
				         "estadolistening"=>'0'
			);

	if($examen->actualizar($valor,$idexamen) )
	{
		echo '1';
	}
	else{
		
		echo '2';
	}
}else{
       $consulta="SELECT * FROM referencia where idmodulo=$idmodulo and tipo=1 ORDER BY RAND() LIMIT 1"; //$idmodulo
        foreach($referencia->sql($consulta) as $ref)
        { 
           $IDref=$ref['idreferencia'];
        } 
               $valores2=array("horalistening"=>"'$horaActual'"
              );              

              if($examen->actualizar($valores2,$idexamen))
              {
                //echo '2';
              }

       //foreach($pregunta->mostrarTodo("referencia=".$IDref) as $pre) //idreferencia por defecto
         $consulta2="SELECT * FROM pregunta where referencia=$IDref ORDER BY RAND() LIMIT $cantidadLS"; 
        foreach($pregunta->sql($consulta2) as $pre)
        { 
               $idpregunta=$pre['idpregunta'];
            
           
               $valores1=array("idexamen"=>"'$idexamen'",
                               "idpregunta"=>"'$idpregunta'",
                               "tipo"=>"'1'",
                               "asignatura"=>"'listening'",
                               "referencia"=>"'$IDref'"
              );              

              if($examendetalle->insertar($valores1))
              {
                //echo '2';
              }

             
        }

        $valor=array("horalistening"=>"'$horaActual'",
				         "estadolistening"=>'0'
			);

	if($examen->actualizar($valor,$idexamen) )
	{
		
		$cantidad2=$examendetalle->mostrarTodo("idexamen=".$idexamen." and asignatura='listening'");
		if(count($cantidad2)>0)
		{
			echo '1';
		}else{
			echo '3';
		}
	}
	else{
		
		echo '2';
	}
}
       

			


?>