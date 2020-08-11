<?php 
$ruta="../../";
include_once($ruta."class/vestudiantecurso.php");
$vestudiantecurso=new vestudiantecurso;
include_once($ruta."class/asistencia.php");
$asistencia=new asistencia;
include_once($ruta."class/usuario.php");
$usuario=new usuario;

extract($_POST);
session_start();
$idusuario=$_SESSION["codusuario"];
$us=$usuario->mostrar($idusuario);
$us=array_shift($us);
$idsede=$us['idsede'];
$fechaasis=date('Y-m-d');
	$codecurso=ecUrl($idcurso);

 foreach($vestudiantecurso->mostrarTodo("idcurso=".$idcurso." and idsede=".$idsede) as $f)
 {
 	$IDec=$f['idvestudiantecurso'];
 	$contar=0;
 	foreach($asistencia->mostrarTodo("idestudiantecurso=".$f['idvestudiantecurso']." and fechaasistencia='$fechaasis'") as $f)
 	{
 		$contar=$contar+1;
 	}
 	
 	if($contar>0)
	{
	     echo '1';   
	}else{
		$valores=array(
	     "idestudiantecurso"=>"'$IDec'",
	     "asis"=>"'0'",
	     "fechaasistencia"=>"'$fechaasis'"
		);	
		if($asistencia->insertar($valores))
		{}
		
	}
 	    	
 }
 ?>
<script  type="text/javascript">				      
			           location.href = "curso.php?codecurso=<?php echo $codecurso ?>";			          				
				</script>				
			