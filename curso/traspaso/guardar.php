<?php 
	$ruta="../../";
	include_once($ruta."class/estudiantecurso.php");
	$estudiantecurso=new estudiantecurso;
	extract($_POST);
	session_start();
   $EC=$estudiantecurso->mostrar($idestudiantecurso);
   $EC=array_shift($EC);
   if ($EC['idcurso']==$idcursoSel) 
   {
       ?>
		<script type="text/javascript">
			Materialize.toast('<span>No se puede realizar traspaso al mismo curso</span>', 1500);
		</script>
		<?php
   }else{
   			$valores=array(
	     					"estado"=>"'0'"
				);	
				if($estudiantecurso->actualizar($valores,$idestudiantecurso))
				{
						$valores=array(
								     "idestudiante"=>"'$idestudiante'",
								     "idcurso"=>"'$idcursoSel'",
								     "estado"=>"'1'"
						);	
								if($estudiantecurso->insertar($valores))
								{
									?>
										<script  type="text/javascript">
											swal({
									              title: "Exito !!!",
									              text: "Se asigno correctamente",
									              type: "success",
									              showCancelButton: false,
									              confirmButtonColor: "#28e29e",
									              confirmButtonText: "OK",
									              closeOnConfirm: false,
               									  showLoaderOnConfirm: true,
									          }, function () {      
									             location.href="index.php";
									          });				
										</script>
									<?php
								}
								else
								{
									//por el error revertemos el guardado
									$valores=array(
										     "estado"=>"'1'"
										);	
										if($estudiantecurso->actualizar($valores,$idestudiantecurso))
										{}
									?>
									<script type="text/javascript">
										Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
									</script>
									<?php
								}
				}
				else
				{
					?>
					<script type="text/javascript">
						Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
					</script>
					<?php
				}


   }

    




	

?>