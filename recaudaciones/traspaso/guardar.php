<?php
	$ruta="../../";
	include_once($ruta."class/admcontrato.php");
	$admcontrato=new admcontrato;
	include_once($ruta."class/admcontratodelle.php");
	$admcontratodelle=new admcontratodelle;
	include_once($ruta."class/vcontratoplan.php");
	$vcontratoplan=new vcontratoplan;
	include_once($ruta."class/cobcartera.php");
	$cobcartera=new cobcartera;
	include_once($ruta."class/admsemana.php");
	$admsemana=new admsemana;


	include_once($ruta."class/vcartera.php");
	$vcartera=new vcartera;
	include_once($ruta."class/observacion.php");
	$observacion=new observacion;

	include_once($ruta."class/vestudiante.php");
	$vestudiante=new vestudiante;
	include_once($ruta."class/estudiante.php");
	$estudiante=new estudiante;
	include_once($ruta."class/estudiantecurso.php");
	$estudiantecurso=new estudiantecurso;
	session_start();
    $numero=$_POST["numero"];
	extract($_POST);
    $count = count($numero);
    for ($i = 0; $i < $count; $i++) {
	    /*********** actualiza cartera asignando a un nuevo ejecutivo ************/

switch ($idejecutivo) {
	case '6':
			$fechaHoy=date("Y-m-d");
	    	$valores2=array(
		     	"idejecutivo"=>"'$idejecutivo'",
		     	"fechaabandono"=>"'$fechaHoy'"
			);	
							/*para deshabilitar alumno*/
	    					$datocartera = $cobcartera->muestra($numero[$i]);

							$dato2 = $vcartera->mostrarTodo("idcontrato=".$datocartera['idcontrato']);
							$dato2 =array_shift($dato2);

								foreach($vestudiante->mostrarTodo("idpersonaplan=".$dato2['idpersonaplan']) as $f)
								{
									$ide=$f['idvestudiante'];
									$valores3=array(
							     	"estadoacademico"=>"'153'",
							     	"estadocontrato"=>"'144'",
							     	"estado"=>"'2'"
									);	
									$valores4=array(
							     	"estado"=>"'0'"
									);	

									$valoresx=array(
								     "idestudiante"=>"'$ide'",
								     "detalle"=>"'CAMBIO DE ESTADO CONTRATO A ABANDONO'",
								     "idejecutivoDetalla"=>"'$idejecutivo'",
								     "tipo"=>"'academico'",
								     "estado"=>"'144'"
											);	 
								 
									$valoresY=array(
									     "idestudiante"=>"'$ide'",
									     "detalle"=>"'CAMBIO DE ESTADO ACADEMICO A INACTIVO'",
									     "idejecutivoDetalla"=>"'$idejecutivo'",
									     "tipo"=>"'academico'",
									     "estado"=>"'153'"
									);	 
									$observacion->insertar($valoresx); 
									$observacion->insertar($valoresY);


									$estudiante->actualizar($valores3,$f['idvestudiante']);

										 foreach($estudiantecurso->mostrarTodo("idestudiante=".$f['idvestudiante']) as $g)
											{
												$estudiantecurso->actualizar($valores4,$g['idestudiantecurso']);

											}
								}
		break;
		case '7':
					$valores2=array(
				     	"idejecutivo"=>"'$idejecutivo'",
				     	"fechabaja"=>"'$fechaHoy'"
					);	
		/*para  habilitar alumno*/
					$datocartera = $cobcartera->muestra($numero[$i]);

					$dato2 = $vcartera->mostrarTodo("idcontrato=".$datocartera['idcontrato']);
					$dato2 =array_shift($dato2);
					foreach($vestudiante->mostrarTodo("idpersonaplan=".$dato2['idpersonaplan']) as $f)
								{
									$ide=$f['idvestudiante'];
									$valores3=array(
							     	"estadoacademico"=>"'153'",
							     	"estadocontrato"=>"'147'",
							     	"estado"=>"'2'"
									);	
									$valores4=array(
							     	"estado"=>"'0'"
									);	

									$valoresx=array(
								     "idestudiante"=>"'$ide'",
								     "detalle"=>"'CAMBIO DE ESTADO CONTRATO A BAJA'",
								     "idejecutivoDetalla"=>"'$idejecutivo'",
								     "tipo"=>"'contrato'",
								     "estado"=>"'147'"
											);	 
								 
									$valoresY=array(
									     "idestudiante"=>"'$ide'",
									     "detalle"=>"'CAMBIO DE ESTADO ACADEMICO A INACTIVO'",
									     "idejecutivoDetalla"=>"'$idejecutivo'",
									     "tipo"=>"'academico'",
									     "estado"=>"'153'"
									);	 
									$observacion->insertar($valoresx); 
									$observacion->insertar($valoresY);


									$estudiante->actualizar($valores3,$f['idvestudiante']);

										 foreach($estudiantecurso->mostrarTodo("idestudiante=".$f['idvestudiante']) as $g)
											{
												$estudiantecurso->actualizar($valores4,$g['idestudiantecurso']);

											}
								}
		break;
	default:
					$valores2=array(
				     	"idejecutivo"=>"'$idejecutivo'"
					);	
		/*para  habilitar alumno*/
					$datocartera = $cobcartera->muestra($numero[$i]);

					$dato2 = $vcartera->mostrarTodo("idcontrato=".$datocartera['idcontrato']);
					$dato2 =array_shift($dato2);
		break;
}
 
 $cobcartera->actualizar($valores2,$numero[$i]);
 
		/*******************************************/
 
    }
    ?>
		<script  type="text/javascript">
			swal({
	              title: "Exito !!!",
	              text: "Matriculas Asignadas Correctamente",
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
?>