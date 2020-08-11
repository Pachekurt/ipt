<?php 
	 
		extract($_POST);
		$ruta="../../"; 
		include_once($ruta."class/curso.php");
		$curso=new curso;
		include_once($ruta."class/estudiantecurso.php");
		$estudiantecurso=new estudiantecurso;



	//	${$nombre}->eliminar($id);
 


$inscritos=$estudiantecurso->mostrarTodo("idcurso=".$id." and estado =1");

if (count($inscritos)==0){
	//no hay inscritos

	$hoy=date('Y-m-d',strtotime('-1 day')); 
			$valores=array(
						"estadocurso"=>"'2'",
						"activo"=>"'0'",
						"fechafin"=>"'$hoy'"						
					 );	

				if($curso->actualizar($valores,$id))
					{

						?>
							<script type="text/javascript">
							swal({
								title: "Exito !!!",
								text: "Se finalizo el curso correctamente",
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
							swal({
								title: "ERROR !!!",
								text: "No se pudo finalizar, intente nuevamente",
								type: "warning",
								showCancelButton: false,
								confirmButtonColor: "#e22856",
								confirmButtonText: "OK",
								closeOnConfirm: false
					          }, function () {
								location.reload();
					          });
								</script>
							<?php
 

					}

							
}
else
{
		?>
							<script type="text/javascript">
							swal({
								title: "ERROR !!!",
								text: "No se puede finalizar el curso aun hay estudiantes inscritos",
								type: "warning",
								showCancelButton: false,
								confirmButtonColor: "#e22856",
								confirmButtonText: "OK",
								closeOnConfirm: false
					          }, function () {
								location.reload();
					          });
								</script>
							<?php
}


			?>
			
		 