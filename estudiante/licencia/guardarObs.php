<?php 
	$ruta="../../";
	include_once($ruta."class/licencia.php");
	$licencia=new licencia;
	include_once($ruta."class/configuracion.php");
	$configuracion=new configuracion;
	include_once($ruta."class/vlicencia.php");
	$vlicencia=new vlicencia;
	extract($_POST);
	session_start();

	$valores=array(
	     "idestudiante"=>"'$idest'",
	     "idestudiantecurso"=>"'$idestcurso'",
	     "fecha"=>"'$fecha'",
	     "motivo"=>"'$motivo'",
	     "dias"=>"'$diassolicitud'"
	);	


$limite = $configuracion->mostrarTodo("tipo=1");
$limite = array_shift($limite);


$datodias=0;

foreach( $vlicencia->mostrarTodo("idestudiante=$ide") as $lic)
  {
    $datodias=$datodias+$lic['dias']; 
  }

 if($datodias<$limite['valor'])
{
    $dias=$limite['valor']-$datodias;
   
}
else
{    
    $dias=$limite['valor'];
   
}

 if ($dias>$diassolicitud) {
 	 		if($licencia->insertar($valores))
						{
							?>
								<script  type="text/javascript">
								$('#btnSave').attr("disabled",true);
									swal({
							              title: "Exito !!!",
							              text: "Se registro la licencia correctamente",
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
						}else{
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
			 swal("LIMITE DE DIAS ALCANZADO");
		</script>
		<?php

}
 




?>