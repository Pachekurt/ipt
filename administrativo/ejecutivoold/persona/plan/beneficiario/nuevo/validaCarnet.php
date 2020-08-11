<?php
$ruta="../../../../../../../";
include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."funciones/funciones.php");
extract($_POST);
$personas=$persona->mostrarTodo(" carnet=".$carnet);
$personas=array_shift($personas);
$idpersonaV=$personas['idpersona'];
//$lblcode=ecUrl($IDpersona);
if(count($personas)>0){
	$titulaper= $personas['nombre']." ".$personas['paterno']." ".$personas['materno'];
//Titular existente
	?>
		<div id='card-alert' class=' red'><div class=' white-text'><p><i class='mdi-navigation-check'></i> Titular Registrado</p></div> </div>
	    <script type="text/javascript">
	    swal({
		  title: "Agregar a Beneficiario",
		  text: "Agregar a <?php echo $titulaper ?> como beneficiario ?",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#16c103",
		  confirmButtonText: "Si, Agregar",
		  cancelButtonText: "No",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
		  	str="lblcode=<?php echo $lblcode ?>&idpersona=<?php echo $idpersona ?>&idpersonaV=<?php echo $idpersonaV ?>&lblperplan=<?php echo $lblperplan ?>";
		    $.ajax({
				url: "agregarbeneficiario.php",
				type: "POST",
				data: str,
				success: function(resp){
					console.log();
					$("#idresultado").html(resp)
				}
            });
		  } else {
		    location.href="../?lblcode=<?php echo $lblcode ?>&lblperplan=<?php echo $lblperplan ?>";
		  }
		});
	    </script>		
	<?php
 }
else{
//Registrar nuevo titular
	?>
		<div id='card-alert' class=' green'><div class=' white-text'><p><i class='mdi-navigation-check'></i>Registraras nuevo Beneficiario</p></div> </div>
        <script type="text/javascript">
	    $('#btnSave').attr("disabled",false);
	    </script>
	<?php
 }
?>
