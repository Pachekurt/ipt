<?php
session_start();
extract($_POST);
$ruta="../../../../../../../";
include_once($ruta."class/persona.php");
$persona=new persona;

include_once($ruta."class/vinculado.php");
$vinculado=new vinculado;

include_once($ruta."class/personaplan.php");
$personaplan=new personaplan;

include_once($ruta."class/admplan.php");
$admplan=new admplan;

include_once($ruta."class/dominio.php");
$dominio=new dominio;

include_once($ruta."funciones/funciones.php");
$idcontrato=dcUrl($lblcode);
$descVinculado='NUEVO VINCULADO';
//nuevo registro
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
	$idpersonaVinc=$dpersona['idpersona'];
	$tipoVinculado="11";
	// verificamos si tiene asignado un plan
	$perplan=$personaplan->mostrarUltimo("idpersonaplan=".$lblperplan);
	//verificamos si tiene cupo para el beneficiario
	$dplan=$admplan->mostrarTodo("idadmplan=".$perplan['idadmplan']);
	$dplan=array_shift($dplan);

	$idperplan=$perplan['idpersonaplan'];
	$vincPermitidos=$dplan['personas'];
	//verificamos la cantidad de personas cinculadas al plan de la persona
	$dvinculado=$vinculado->mostrarTodo("idpersonaplan=".$lblperplan);
	$dvinreg=count($dvinculado);
	if ($dvinreg<$vincPermitidos) {
		//hay cantidad para vincular
		$valoresVinc=array(
			"idpersona"=>"'$idpersona'",
			"idpersonaplan"=>"'$idperplan'",
			"idpersonaVinc"=>"'$idpersonaVinc'",
			"idadmcontrato"=>"'$idcontrato'",
			"idtipoVinculado"=>"'$tipoVinculado'",
			"idparentesco"=>"'$idparentesco'",
			"descripcion"=>"'$descVinculado'"
		);	
		if($vinculado->insertar($valoresVinc)){
			//registrado correctamente
			?>
			    <script type="text/javascript">
			    	swal({
						title: "Exito !!!",
						text: "Beneficiario Agregado correctamente",
						type: "success",
						showCancelButton: false,
						confirmButtonColor: "#28e29e",
						confirmButtonText: "OK",
						closeOnConfirm: false
					}, function () {
						location.href="../?lblcode=<?php echo $lblcode ?>&lblperplan=<?php echo $lblperplan ?>";
					});
			    </script>
			<?php
		}
		else{
			//no se pudo registrar
			?>
			    <script type="text/javascript">
			      setTimeout(function() {
			              Materialize.toast('<span>No se pudo registrar</span>', 1500);
			          }, 10);
			    </script>
			<?php
		}
	}
	else{
		//cupo de personas cumplidas
		?>
		    <script type="text/javascript">
		         sweetAlert("Oops...", "La cantidad de personas ya esta ocupada!", "error");
		    </script>
		<?php
	}
}
else{
	//no se pudo registrar la persona
	?>
	    <script type="text/javascript">
	      setTimeout(function() {
	              Materialize.toast('<span>No se pudo registrar la persona</span>', 1500);
	          }, 10);
	    </script>
	<?php
}



?>