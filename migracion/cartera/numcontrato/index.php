<?php
	$ruta="../../../";
	include_once($ruta."class/migcartera.php");
	$migcartera=new migcartera;
    include_once($ruta."class/cobcartera.php");
    $cobcartera=new cobcartera;
    include_once($ruta."class/cobcarteradet.php");
    $cobcarteradet=new cobcarteradet;
    include_once($ruta."class/admcontrato.php");
    $admcontrato=new admcontrato;
    include_once($ruta."class/personaplan.php");
    $personaplan=new personaplan;

    include_once($ruta."class/admplan.php");
    $admplan=new admplan;


	include_once($ruta."funciones/funciones.php");
	session_start();
    //fase 1 crear admcontrato
    //fase 2 crear admcontrato detalle
    //fase 3 insertar a cartera
    //fase 4 insertar a cartera detalle



    //FASE 1*************************************************
    $i=0;
    foreach($migcartera->mostrarTodo("migrado=0") as $f){
        //fase1 crear admcontrato
        $i++;
        $dpp=$personaplan->mostrarUltimo("numcuenta=".$f['cuenta']);
        $numcontrato=$f['matricula'];
        echo $numcontrato."-- \n";
        $val2=array(
            "numcontrato"=>"'$numcontrato'",
        );
        //$personaplan->actualizar($val2,$dpp['idpersonaplan']);
    }
    echo "MIGRADO ".$i;;
?>