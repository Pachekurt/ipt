<?php 
$ruta="../../";
include_once($ruta."class/actividadreserva.php");
$actividadreserva=new actividadreserva;
include_once($ruta."class/vestudiantecurso.php");
$vestudiantecurso=new vestudiantecurso;
include_once($ruta."class/asistenciaact.php");
$asistenciaact=new asistenciaact;
    include_once($ruta."class/admestudiante.php");
	$admestudiante=new admestudiante;
extract($_POST);
session_start();


    $nros=$admestudiante->mostrarTodo("idestudiante=".$estudianteid);
    $nros=count($nros);


$datoestudiante = $admestudiante->muestra($estudianteid);
$dato=$datoestudiante['estadoacademico'];

if($dato=='153'){
     ?>
                <script  type="text/javascript">
                swal("Error!", "El Estudiante no puede reservar debe pasar por administracion", "error")
                </script>

                <?php
}
else
{
						if($nros>0)
						{


						$ah=$actividadreserva->mostrarTodo("idestudiante=".$estudianteid." and idactividadhabil=".$actividadid);
						if(count($ah)>0)
						{
							?>
							<script  type="text/javascript">
								swal("Error!", "alumno ya se encuantra reservado en la actividad", "error")
								</script>
							<?php	
						}else{
							$valores=array(
								     "idestudiante"=>"'$estudianteid'",
								     "idactividadhabil"=>"'$actividadid'",
								     "estado"=>"'1'"
									);	
									if($actividadreserva->insertar($valores))
									{
						                
						                
						                $aa=$actividadreserva->mostrarUltimo("idestudiante=".$estudianteid." and idactividadhabil=".$actividadid);
						               
						                $id=$aa["idactividadreserva"];
						                
						                $valoress=array(
						                          "idactividadreserva"=>"'$id'",
								                  "asis"=>"'0'"
									             );	
						                
						                
						                if($asistenciaact->insertar($valoress))
									     {
										?>
						            
											<script  type="text/javascript">
												swal({
										              title: "Exito !!!",
										              text: "Se reservo correctamente",
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
						                        }else{
										        ?>
										        <script type="text/javascript">
						                                Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
										        </script>
										        <?php
									             }
									}else{
										?>
										<script type="text/javascript">
											Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
										</script>
										<?php
									}
						}

						}
						else
						{
						   ?>
							
						<script  type="text/javascript">
								swal("Error!", "El numero de Carnet no existe", "error")
								</script>

						       
								<?php 
						    
						}

}




?>