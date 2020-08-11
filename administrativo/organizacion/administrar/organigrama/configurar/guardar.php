<?php
	session_start();  
	extract($_POST);
	$ruta="../../../../../";
  	include_once($ruta."class/admorganidet.php");
  	$admorganidet=new admorganidet;
  	include_once($ruta."class/admejecutivo.php");
  	$admejecutivo=new admejecutivo;
  	include_once($ruta."class/admjerarquia.php");
  	$admjerarquia=new admjerarquia;
	include_once($ruta."funciones/funciones.php");
	//guardar el cargo en la tabla detalle
		$dejec=$admejecutivo->muestra($idejecuti);
		$idcargo=$dejec['idcargo'];
	//validar que el ejecutivo no se el padre. En caso de que si, se tendra que dar un cargo inferior.
		$dorgD=$admorganidet->muestra($idpadre);
		if ($idejecuti==$dorgD['idadmejecutivo']) {
			$dorD=$admorganidet->muestra($idpadre);//obtiene el cargo del organigrama detalle. Para asignarle un cargo
			$dcargo=$admjerarquia->muestra($dorD['idcargo']);//hacemos la consulta para obtener el hijo
			$dcargoH=$admjerarquia->muestra($dcargo['hijo']);//obteniendo el hijo, hacemos la consulta para obtener el id cargo
			$idcargo=$dcargoH['idadmjerarquia'];//asignamos el id cargo obtenido
			//echo "Tiene que tener un cargo inferior.";
		}
	/*********************************************/
	$data=array(
		"padre"=>"'$idpadre'",
		"idadmorgani"=>"'$idorganigrama'",
		"idadmejecutivo"=>"'$idejecuti'",
		"idcargo"=>"'$idcargo'",
		"tipoente"=>"'$idtipoeje'",
		"estado"=>"'1'"
	);
	if($admorganidet->insertar($data)){
		?>
			<script  type="text/javascript">
				swal({
		              title: "Exito !!!",
		              text: "Ejecutivo Agregado correctamente",
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
	else{
		?>
		<script type="text/javascript">
			Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
		</script>
		<?php
	}
?>
