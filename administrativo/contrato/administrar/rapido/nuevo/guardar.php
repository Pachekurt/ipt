<?php
session_start();
$ruta="../../../../../";
include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."class/titular.php");
$titular=new titular;
include_once($ruta."class/admcontrato.php");
$admcontrato=new admcontrato;
include_once($ruta."class/admorgani.php");
$admorgani=new admorgani;
include_once($ruta."class/admejecutivo.php");
$admejecutivo=new admejecutivo;
include_once($ruta."class/admsemana.php");
$admsemana=new admsemana;
include_once($ruta."class/admcontratodelle.php");
$admcontratodelle=new admcontratodelle;
include_once($ruta."funciones/funciones.php");
extract($_POST);
$idcontrato=$lblcode;
// obtenemos el organigrama activo de la organizacion*************************************************/
$dcontrato=$admcontrato->muestra($idcontrato);
$dejec=$admejecutivo->muestra($dcontrato['idadmejecutivo']);
$dorgani=$admorgani->mostrarUltimo("idadmorganizacion=".$dejec['idorganizacion']." and estado=1");
$idorganigrama=$dorgani['idadmorgani'];
$dsemana=$admsemana->mostrarUltimo("estado=1");
$idsemana=$dsemana['idadmsemana'];
/******************************************************************************************************/
$personaB=$persona->mostrarTodo("carnet=".$idcarnet);
$idnombre=strtoupper($idnombre);
$idpaterno=strtoupper($idpaterno);
$idmaterno=strtoupper($idmaterno);
$idocupacion=strtoupper($idocupacion);
if (count($personaB)==0) {
	$valores=array(
		"carnet"=>"'$idcarnet'",
		"expedido"=>"'$idexp'",
		"nombre"=>"'$idnombre'",
		"paterno"=>"'$idpaterno'",
		"materno"=>"'$idmaterno'",
		"nacimiento"=>"'$idnacimiento'",
		"email"=>"'$idemail'",
		"celular"=>"'$idcelular'",
		"idsexo"=>"'$idsexo'",
		"ocupacion"=>"'$idocupacion'",
		"tipopersona"=>"'TITULAR'"
	 );	
	if($persona->insertar($valores))
	{
		$dpersona=$persona->mostrarUltimo("carnet=".$idcarnet);
		$idper=$dpersona['idpersona']; //aumentado
        $valores=array("idpersona"=>"'$idper'",
        				"razon"=>"'$idrazon'",
        				"nit"=>"'$idnit'"
        ); 
		if($titular->insertar($valores))
		{
			$fecha=date("Y-m-d");
			$hora=date("H:i:s");
			$dtitular=$titular->mostrarUltimo("idpersona=".$idper);
			$valores=array(
				"idorganigrama"=>"'$idorganigrama'",
				"idadmsemana"=>"'$idsemana'",
			    "estado"=>"'68'",
			    "fechaestado"=>"'$fecha'",
			    "idtitular"=>$dtitular['idtitular']
			);
			if ($admcontrato->actualizar($valores,$idcontrato)) {
				$lblcode=ecUrl($idcontrato);
				/******** inserta contrato detalle *********/
					$valores2=array(
						"idcontrato"=>$idcontrato,
						"idtitular"=>$dtitular['idtitular'],
						"idsemana"=>"'$idsemana'",
						"fecha"=>"'$fecha'",
						"hora"=>"'$hora'",
						"idsemana"=>"'$idsemana'",
						"detalle"=>"'ASIGNACION DE TITULAR'",
						"estado"=>"'68'",
						"codigo"=>"'3112'"
					);	
					$admcontratodelle->insertar($valores2);
				/*******************************************/
			  	?>
					<script type="text/javascript">
					swal({
			              title: "Exito !!!",
			              text: "Titular Registrado Correctamente",
			              type: "success",
			              showCancelButton: false,
			              confirmButtonColor: "#28e29e",
			              confirmButtonText: "OK",
			              closeOnConfirm: false
			          }, function () {
						location.href="../plan/?lblcode=<?php echo $lblcode; ?>";
			          });
					</script>
				<?php
			}
			else{
				?>
					<script type="text/javascript">
						setTimeout(function() {
				            Materialize.toast('<span>0 No se pudo realizar la Operacion. Consulte con su proveedor</span>', 1500);
				        }, 1500);
					</script>
				<?php
			}

		}
		else{
			?>
				<script type="text/javascript">
					setTimeout(function() {
			            Materialize.toast('<span>1 No se pudo realizar la Operacion. Consulte con su proveedor</span>', 1500);
			        }, 1500);
				</script>
			<?php
		}
	}
	else{
		?>
			<script type="text/javascript">
				setTimeout(function() {
		            Materialize.toast('<span>2 No se pudo realizar la Operacion. Consulte con su proveedor</span>', 1500);
		        }, 1500);
			</script>
		<?php
	 }
 }
 else{
	?>
		<script type="text/javascript">
			setTimeout(function() {
	            Materialize.toast('<span>3 No se pudo realizar la Operacion. Consulte con su proveedor</span>', 1500);
	        }, 1500);
		</script>
	<?php
}
?>