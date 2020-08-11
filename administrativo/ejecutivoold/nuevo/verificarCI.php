<?php
$ruta="../../../";
include_once($ruta."class/persona.php");
$persona=new persona; 
include_once($ruta."class/vejecutivo.php");
$vejecutivo=new vejecutivo; 
include_once($ruta."funciones/funciones.php");
extract($_POST);
$personas=$persona->mostrarUltimo("carnet=".$carnet);
$IDpersona=$personas['idpersona'];

$ejecutivos =$vejecutivo->mostrarFull("idpersona=$IDpersona");
$ejecutivos= array_shift($ejecutivos);

$lblcode=ecUrl($IDpersona);
// Revisar si la persona es ejecutivo  -> manda a editar ejecutivo
// Revisar si la persona existe en la base de datos -> Pregunta si quiere crear registro de ejecutivo. Crear registro de ejecutivo
// No es persona ni ejecutivo -> pregunta si quiere registrar persona. Si.-manda a registrar persona. No.- cierra alerta
if(count($personas)>0){
	$nombre= $personas['nombre']." ".$personas['paterno']." ".$personas['materno'];
	 
		// es persona  
		//preguntamos si es ejecutivo
			if(count($ejecutivos)>0){
				//es persona y ejecutivo
				?>
						<div id='card-alert' class=' red'><div class=' white-text'><p><i class='mdi-navigation-check'></i>Persona Existente</p></div> </div>
					    <script type="text/javascript">
						    swal({
							  title: "PERSONAL YA REGISTRADO",
							  text: "<?php echo $nombre ?> Ya es personal de la empresa",
							  type: "info",
							  showCancelButton: true,
							  confirmButtonColor: "#43D1DB",
							  confirmButtonText: "Ver Registro",
							  cancelButtonText: "Buscar de nuevo",
							  closeOnConfirm: false,
							  closeOnCancel: false
							},
							function(isConfirm){
							  if (isConfirm) {
							  	location.href="../editar/ver.php?lblcode=<?php echo $lblcode; ?>";
							  } else {
							    location.reload();
							  }
							});
					    </script>
					<?php
			}
			else
			{
				//es persona pero no ejecutivo
					?>
					<div id='card-alert' class=' red'><div class=' white-text'><p><i class='mdi-navigation-check'></i>Persona Existente</p></div> </div>
				    <script type="text/javascript">
					    swal({
						  title: "PERSONA ENCONTRADA",
						  text: "<?php echo $nombre ?> Esta registrado en la base de datos de INGLES PARA TODOS.",
						  type: "warning",
						  showCancelButton: true,
						  confirmButtonColor: "#16c103",
						  confirmButtonText: "OK. Seguir Adelante",
						  cancelButtonText: "Buscar de nuevo",
						  closeOnConfirm: false,
						  closeOnCancel: false
						},
						function(isConfirm){
						  if (isConfirm) {
						  	location.href="../../../persona/editar/ver.php?lblcode=<?php echo $lblcode; ?>";
						  } else {
						    location.reload();
						  }
						});
				    </script>
				<?php
			}

 
	 }
	else{
		//es persona pero no ejecutivo
		//se debera registrar como ejecutivo en caso de que el usuario se leccione ejecutivo
		
				$lblcode=ecUrl($carnet);
		?>
					<div id='card-alert' class=' red'><div class=' white-text'><p><i class='mdi-navigation-check'></i>Nuevo Registro</p></div> </div>
				    <script type="text/javascript">
					    swal({
						  title: "PERSONA NO REGISTRADA",
						  text: "El carnet <?php echo $carnet ?>  no esta registrado",
						  type: "warning",
						  showCancelButton: true,
						  confirmButtonColor: "#16c103",
						  confirmButtonText: "Registrar Persona",
						  cancelButtonText: "Buscar de nuevo",
						  closeOnConfirm: false,
						  closeOnCancel: false
						},
						function(isConfirm){
						  if (isConfirm) {
						  	location.href="../../../persona/nuevo/?lblcode=<?php echo $lblcode; ?>";
						  } else {
						    location.reload();
						  }
						});
				    </script>
				<?php
	}
 
?>
