<?php 
$ruta="../../";
include_once($ruta."class/vactividadreserva.php");
$vactividadreserva=new vactividadreserva;
include_once($ruta."class/asistenciaact.php");
$asistenciaact=new asistenciaact;
include_once($ruta."class/usuario.php");
$usuario=new usuario;

extract($_POST);
session_start();
$idusuario=$_SESSION["codusuario"];
$us=$usuario->mostrar($idusuario);
$us=array_shift($us);
$idsede=$us['idsede'];
$fechaasis=date('Y-m-d');
$codeidah=ecUrl($idah);

 foreach($vactividadreserva->mostrarTodo("idactividadhabil=".$idah." and idsede=".$idsede) as $f)
 {
 	$IDar=$f['idvactividadreserva'];
 	$contar=0;
 	foreach($asistenciaact->mostrarTodo("idactividadreserva=".$f['idvactividadreserva']) as $f)
 	{
 		$contar=$contar+1;
 	}
 	
 	if($contar>0)
	{
	     echo '1';   
	}else{
		$valores=array(
	     "idactividadreserva"=>"'$IDar'",
	     "asis"=>"'0'",
	     "fechaasistencia"=>"'$fechaasis'"
		);	
		if($asistenciaact->insertar($valores))
		{}
		
	}
 	    	
 }
 ?>
<script  type="text/javascript">				      
			           location.href = "cursoactividad.php?codeidah=<?php echo $codeidah ?>";			          				
				</script>				
			