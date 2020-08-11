<?php
session_start();
$ruta="../../";
include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."class/domicilio.php");
$domicilio=new domicilio;
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo;
include_once($ruta."funciones/funciones.php");
extract($_POST);
$idnombre=strtoupper($idnombre);
$idpaterno=strtoupper($idpaterno);
$idmaterno=strtoupper($idmaterno);
$idocupacion=strtoupper($idocupacion);
$valores=array( 
	"nombre"=>"'$idnombre'",
	"paterno"=>"'$idpaterno'",
	"materno"=>"'$idmaterno'",
	"nacimiento"=>"'$idnacimiento'",
	"email"=>"'$idemail'",
	"celular"=>"'$idcelular'",
	"idsexo"=>"'$idsexo'",
	"ocupacion"=>"'$idocupacion'",
);	

$idzona=strtoupper($idzona);
$iddireccion=strtoupper($iddireccion); 
$valoresd=array(
	"idbarrio"=>"'$idzona'",
	"nombre"=>"'$iddireccion'",
	"telefono"=>"'$idfono'" 
);	
$valoresd2=array(
	"idpersona"=>"'$idper'",
	"idbarrio"=>"'$idzona'",
	"nombre"=>"'$iddireccion'",
	"telefono"=>"'$idfono'" 
);	

$lblcode= ecUrl($idper);

if($persona->actualizar($valores,$idper))
{


				if($domicilio->actualizar($valoresd,$iddom))
				{

				}
				else
				{
					$domicilio->insertar($valoresd2);
				}



$ejecutivos =$vejecutivo->mostrarFull("idpersona=$idper");
$ejecutivos= array_shift($ejecutivos);



			if(count($ejecutivos)>0){

				?> 
						<script type="text/javascript">
							sweetAlert("Exito!", "Se realizaron los cambios", "success");
							///location.href="../../editar/ver.php?lblcode=<?php echo $lblcode; ?>";
						</script> 
				<?php

				}
				else
				{
						?> 
						<script type="text/javascript">
							sweetAlert("Exito!", "Se realizaron los cambios", "success");
							//location.href="../../nuevo/?lblcode=<?php echo $lblcode; ?>";
						</script> 
	<?php

				}
	
}
else{
	?>
		<script type="text/javascript">
			sweetAlert("Oops...", "No se pudo realizar la operacion", "error");
		</script>
	<?php
}
?>