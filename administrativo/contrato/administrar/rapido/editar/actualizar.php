<?php
session_start();
$ruta="../../../../../";
include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."class/titular.php");
$titular=new titular;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."funciones/funciones.php");
extract($_POST);
$idnombre=strtoupper($idnombre);
$idpaterno=strtoupper($idpaterno);
$idmaterno=strtoupper($idmaterno);
$idocupacion=strtoupper($idocupacion);
$valores=array(
	"carnet"=>"'$idcarnet'",
	"expedido"=>"'$idexp'",
	"nombre"=>"'$idnombre'",
	"paterno"=>"'$idpaterno'",
	"materno"=>"'$idmaterno'",
	"nacimiento"=>"'$idnacimiento'",
	"email"=>"'$idemail'",
	"celular"=>"'$idcelular'",
	"idsexo"=>"'$idsexo'",
	"ocupacion"=>"'$idocupacion'",
);	
if($persona->actualizar($valores,dcUrl($idpersona)))
{
	$valores=array( "razon"=>"'$idrazon'",
    				"nit"=>"'$idnit'"
        ); 
		if($titular->actualizar($valores,dcUrl($idtitular))) {	
			?>
				<script type="text/javascript">
					sweetAlert("Exito!", "Se realizaron los cambios", "success");
				</script>
			<?php
		}
		else{
			?>
				<script type="text/javascript">
					setTimeout(function() {
			            Materialize.toast('<span>0 No se pudo realizar la Operacion. Si la el error persiste, Consulte con su proveedor</span>', 1500);
			        }, 1500);
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