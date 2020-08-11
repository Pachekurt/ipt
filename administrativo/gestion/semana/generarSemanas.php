<?php 
	$ruta="../../../";
	include_once($ruta."class/admsemana.php");
	$admsemana=new admsemana;

	include_once($ruta."class/admvigencia.php");
	$admvigencia=new admvigencia;
	extract($_POST);
	session_start();
	$fechaPartida=$idfechain;

	$nrosemana=1;
	foreach($admvigencia->mostrarTodo("") as $f)
    {
    	for ($in=1; $in <=4 ; $in++) { 
			$nuevafecha = strtotime ( '+7 day' , strtotime ( $fechaPartida ) ) ;
			$fechaCierre = date ( 'Y-m-j' , $nuevafecha );
			$valores=array(
		     	"idadmgestion"=>$idgestion,
		     	"semana"=>"'$nrosemana'",
		     	"nro"=>"'$in'",
		     	"idadmvigencia"=>$f['idadmvigencia'],
		     	"fechain"=>"'$fechaPartida'",
		     	"fechafin"=>"'$fechaCierre'",
		     	"estado"=>"'0'"

			);	
			$admsemana->insertar($valores);//insertamos
			$fechaPartida=$fechaCierre;
			$nrosemana++;
    	}
    }
?>
<script  type="text/javascript">
	swal({
          title: "Exito !!!",
          text: "Se creo la gestion correctamente",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#28e29e",
          confirmButtonText: "OK",
          closeOnConfirm: false
    }, function () {      
        location.reload();
    });				
</script>