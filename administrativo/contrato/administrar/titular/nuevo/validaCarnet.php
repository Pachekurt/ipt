<?php
$ruta="../../../../../";
include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."funciones/funciones.php");
extract($_POST);
$personas=$persona->mostrarTodo(" carnet=".$carnet);
 $personas=array_shift($personas);
 $IDpersona=$personas['idpersona'];
 $lblcode=ecUrl($IDpersona);
if(count($personas)>0){
	$titulaper= $personas['nombre']." ".$personas['paterno']." ".$personas['materno'];
	?>
		<div id='card-alert' class=' red'><div class=' white-text'><p><i class='mdi-navigation-check'></i> Titular Registrado</p></div> </div>
	    <script type="text/javascript">
	    swal({
		  title: "Persona Existente",
		  text: "Asignar como titular el contrato a <?php echo $titulaper ?> ?",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#16c103",
		  confirmButtonText: "Si, Asignar",
		  cancelButtonText: "No",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
		  	str="idcontrato=<?php echo $lblcontrato ?>&idpersona=<?php echo $IDpersona ?>";
		    $.ajax({
				url: "asignar.php",
				type: "POST",
				data: str,
				success: function(resp){
					console.log();
					$("#idresultado").html(resp)
				}
            });
		  } else {
		    location.reload();
		  }
		});
	    </script>		
	<?php
 }
else{
//Registrar nuevo titular
	?>
		<div id='card-alert' class=' green'><div class=' white-text'><p><i class='mdi-navigation-check'></i>Registraras nuevo Titular</p></div> </div>
        <script type="text/javascript">
	    $('#btnSave').attr("disabled",false);
	    </script>
	<?php
 }
?>
