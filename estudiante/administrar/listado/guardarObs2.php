<?php 
	$ruta="../../../";
	include_once($ruta."class/observacion.php");
	$observacion=new observacion;
	include_once($ruta."class/estudiante.php");
	$estudiante=new estudiante;
	include_once($ruta."class/vestudiantefull.php");
	$vestudiantefull=new vestudiantefull;

	include_once($ruta."class/cobcartera.php");
	$cobcartera=new cobcartera;
	extract($_POST);
	session_start();

		

		$valoresestudiante=array(
	     "estadoacademico"=>"'153'" ,
	     "estadocontrato"=>"'144'" 
		);	
if ($estudiante->actualizar($valoresestudiante,$idestudianteSel)) {


			
	    
			 
			$datovest=$vestudiantefull->muestra($idestudianteSel);
		 $datopp=$datovest['idpersonaplan'];

		
			 	foreach($vestudiantefull->mostrarTodo("idpersonaplan=".$datopp ) as $f)
				{
					$valores3=array(
			     	"estadoacademico"=>"'153'",
			     	"estadocontrato"=>"'144'"
					);	

				

					$estudiante->actualizar($valores3,$f['idestudiante']);
					$id=$f['idestudiante'];
					$consulta="update estudiantecurso set estado =0 where idestudiante =$id";

					$resultado=$estudiante->sql($consulta);
					$resultado=array_shift($resultado);

					$valores=array(
					     "idestudiante"=>"'$id'",
					     "detalle"=>"'$iddescripcion1'",
					     "idejecutivoDetalla"=>"'$idejecutivo'",
					     "tipo"=>"'academico'",
					     "estado"=>"'144'"
					);	 
				 
					$valoresY=array(
					     "idestudiante"=>"'$id'",
					     "detalle"=>"'CAMBIO DE ESTADO ACADEMICO A INACTIVO'",
					     "idejecutivoDetalla"=>"'$idejecutivo'",
					     "tipo"=>"'academico'",
					     "estado"=>"'153'"
					);	 
					$observacion->insertar($valores); 
					$observacion->insertar($valoresY);
				}


		 	 
							?>
								<script  type="text/javascript">
								$('#btnSave').attr("disabled",true);
									swal({
							              title: "Exito !!!",
							              text: "Se registro la observación correctamente",
							              type: "success",
							              //showCancelButton: false,
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
			Materialize.toast('<span>No se pudo cambiar el estado</span>', 1500);
		</script>
		<?php
}

	
?>