<?php
session_start();
$ruta="../../../../";
include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."class/titular.php");
$titular=new titular;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."funciones/funciones.php");
extract($_POST);
$personaB=$persona->mostrarTodo("carnet=".$idcarnet);
$idnombre=strtoupper($idnombre);
$idpaterno=strtoupper($idpaterno);
$idmaterno=strtoupper($idmaterno);
$idocupacion=strtoupper($idocupacion);
if (count($personaB)==0){
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
		"tipopersona"=>"'TITULAR'"
	 );	
	if($persona->insertar($valores))
	{
		$dpersona=$persona->mostrarUltimo("carnet=".$idcarnet);
		$lblcode=ecUrl($dpersona['idpersona']); //aumentado
		  	?>
				<script type="text/javascript">
				swal({
					title: "Exito !!!",
					text: "Persona Registrado Correctamente",
					type: "success",
					showCancelButton: false,
					confirmButtonColor: "#28e29e",
					confirmButtonText: "OK",
					closeOnConfirm: false
		          }, function () {
					location.href="../domlab/?lblcode=<?php echo $lblcode; ?>";
		          });
				</script>
			<?php
	}
	else{
		?>
			<script type="text/javascript">
				setTimeout(function() {
		            Materialize.toast('<span>2 No se pudo realizar la Operacion. Consulte con su proveedor</span>', 1500);
		        }, 1500);
			</script>
		<?php
	 }
 }
 else{
	?>
		<script type="text/javascript">
			sweetAlert("Oops...", "La persona ya se encuentra registrada!", "error");
		</script>
	<?php
}
?>