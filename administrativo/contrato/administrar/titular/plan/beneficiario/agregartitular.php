<?php
session_start();
extract($_POST);
$ruta="../../../../../../";
include_once($ruta."class/persona.php");
$persona=new persona;  

include_once($ruta."class/estudiante.php");
$estudiante=new estudiante;

include_once($ruta."class/vinculado.php");
$vinculado=new vinculado;

include_once($ruta."class/personaplan.php");
$personaplan=new personaplan;

include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;

include_once($ruta."class/admplan.php");
$admplan=new admplan;

include_once($ruta."class/dominio.php");
$dominio=new dominio;

include_once($ruta."funciones/funciones.php");
$idcontrato=dcUrl($lblcode);
$descVinculado='NUEVO VINCULADO';
//Se esta vinculando a la misma persona
$idpersonaVinc=$idpersona;
/**********************************/
$tipoVinculado="11";

$perplan=$personaplan->mostrarUltimo("idpersonaplan=".$lblperplan);
//verificamos si tiene cupo para el beneficiario
$dplan=$admplan->mostrarTodo("idadmplan=".$perplan['idadmplan']);
$dplan=array_shift($dplan);


$dcontrato=$admcontrato->mostrarTodo("idadmcontrato=".$perplan['idcontrato']);
$dcontrato=array_shift($dcontrato);

$sede = $dcontrato['idsede'];

$idperplan=$perplan['idpersonaplan'];
$vincPermitidos=$dplan['personas'];
//verificamos la cantidad de personas cinculadas al plan de la persona
$dvinculado=$vinculado->mostrarTodo("idpersonaplan=".$lblperplan);
$dvinreg=count($dvinculado);

 
 $dpersona=$persona->mostrarTodo("idpersona=".$idpersonaVinc);
$dpersona=array_shift($dpersona);


$carnet= $dpersona['carnet'];
//echo $vincPermitidos."->".$dvinreg;
if ($dvinreg<$vincPermitidos) {
	//hay cantidad para vincular
	$valoresVinc=array(
		"idpersona"=>"'$idpersona'",
		"idpersonaplan"=>"'$idperplan'",
		"idpersonaVinc"=>"'$idpersonaVinc'",
		"idadmcontrato"=>"'$idcontrato'",
		"idtipoVinculado"=>"'$tipoVinculado'",
		"idparentesco"=>"'16'",
		"descripcion"=>"'$descVinculado'"
	);	
	if($vinculado->insertar($valoresVinc)){
		//registrado correctamente
							$valorEstudiante=array(
									"idpersona"=>"'$idpersona'",
									"idprograma"=>"'2'",
									"idmodulo"=>"'1'",
									"idsede"=>"'$sede'",
									"idpersonaplan"=>"'$idperplan'", 
									"ru"=>"'0'", 
									"pass"=>"'$carnet'", 
									"idrol"=>"'5'", 
									"estado"=>"'0'"
							);

								if($estudiante->insertar($valorEstudiante)){

											 $destudiante=$estudiante->mostrarTodo("idpersona=".$idpersonaVinc);
													$destudiante=array_shift($destudiante);
													$ru= '20'.$destudiante['idestudiante'];
													$idest=$destudiante['idestudiante'];
													$valornuevo=array(
														 "ru"=>"'$ru'"
													);

													$estudiante->actualizar($valornuevo,$idest);

												?>
												    <script type="text/javascript">
												    swal({
												              title: "Exito !!!",
												              text: "Datos Registrado Correctamente",
												              type: "success",
												              showCancelButton: false,
												              confirmButtonColor: "#28e29e",
												              confirmButtonText: "OK",
												              closeOnConfirm: false
												          }, function () {
												         location.reload();
												          });
												    </script>
												<?php
												
								}
								else
								{
									?>
									    <script type="text/javascript">
									      setTimeout(function() {
									              Materialize.toast('<span>2 No se pudo registrar</span>', 1500);
									          }, 10);
									    </script>
									<?php
								}



	}
	else{
		//no se pudo registrar
		?>
		    <script type="text/javascript">
		      setTimeout(function() {
		              Materialize.toast('<span>2 No se pudo registrar</span>', 1500);
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




?>