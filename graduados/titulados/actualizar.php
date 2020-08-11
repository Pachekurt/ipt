<?php
session_start();
$ruta="../../";
include_once($ruta."class/persona.php");
$persona=new persona;
include_once($ruta."class/domicilio.php");
$domicilio=new domicilio;
include_once($ruta."funciones/funciones.php");
extract($_POST);
$idnombre=strtoupper($idnombre);
$idpaterno=strtoupper($idpaterno);
$idmaterno=strtoupper($idmaterno);
$idocupacion=strtoupper($idocupacion);
$valores=array( 
	"nombre"=>"'$idnombre'",
	"paterno"=>"'$idpaterno'",
	"materno"=>"'$idmaterno'",
	"nacimiento"=>"'$idnacimiento'",
	"email"=>"'$idemail'",
	"celular"=>"'$idcelular'",
	"idsexo"=>"'$idsexo'",
	"ocupacion"=>"'$idocupacion'"
);	

$idzona=strtoupper($idzona);
$iddireccion=strtoupper($iddireccion); 
$valores1=array(
	"idbarrio"=>"'$idzona'",
	"nombre"=>"'$iddireccion'",
	"telefono"=>"'$idfono'" 
);	
$valores2=array(
	"idpersona"=>"'$idper'",
	"idbarrio"=>"'$idzona'",
	"nombre"=>"'$iddireccion'",
	"telefono"=>"'$idfono'" 
);	

if($persona->actualizar($valores,$idper))
{
	$existe=$domicilio->mostrarTodo("idpersona=".$idper);	
	if (count($existe)>0) 
    {
    	$ddom = $domicilio->mostrarTodo("idpersona =".$idper); 
        $ddom = array_shift($ddom);
		if($domicilio->actualizar($valores1,$ddom['iddomicilio']))
		{
			?>
				<script type="text/javascript">
				$('#btnSave').attr("disabled",true);
					swal({
			              title: "Exito !!!",
			              text: "Datos Actualizados Correctamente",
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
					sweetAlert("Error", "No se pudo realizar la operacion1", "error");
				</script>
			<?php
		}
	}else{

		if($domicilio->insertar($valores2))
		{
			?>
			<script  type="text/javascript">
			$('#btnSave').attr("disabled",true);
				swal({
		              title: "Exito !!!",
		              text: "Datos actualizados Correctamente",
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
					sweetAlert("Error", "No se pudo realizar la operacion2", "error");
				</script>
			<?php
		}
	}

}
else{
	?>
		<script type="text/javascript">
			sweetAlert("Error...", "No se pudo realizar la operacion3", "error");
		</script>
	<?php
}
?>