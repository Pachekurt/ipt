<?php
$ruta="../../../../";
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
							  cancelButtonText: "No",
							  closeOnConfirm: false,
							  closeOnCancel: false
							},
							function(isConfirm){
							  if (isConfirm) {
							  	location.href="../../editar/ver.php?lblcode=<?php echo $lblcode; ?>";
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
						  title: "La persona ya existe",
						  text: "<?php echo $nombre ?> Ya esta registrado en la base de datos de Golden Bridge.",
						  type: "warning",
						  showCancelButton: true,
						  confirmButtonColor: "#16c103",
						  confirmButtonText: "OK. Seguir Adelante",
						  cancelButtonText: "No",
						  closeOnConfirm: false,
						  closeOnCancel: false
						},
						function(isConfirm){
						  if (isConfirm) {
						  	location.href="../../nuevo/?lblcode=<?php echo $lblcode; ?>";
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
		?>
			<div id='card-alert' class=' green'>
				<div class=' white-text'><p>
					<i class='mdi-navigation-check'></i>Se Registrara una nueva persona en la empresa</p>
				</div> 
			</div>	
			<script type="text/javascript">
				$("#idpersona").val("<?php echo $IDpersona; ?>");
		    </script>
		<?php
	}
 
?>
