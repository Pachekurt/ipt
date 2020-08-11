<?php
$ruta="../../../";
include_once($ruta."class/usuario.php");
$usuario=new usuario;

include_once($ruta."funciones/funciones.php");
extract($_POST);

$dus=$usuario->mostrarUltimo("usuario='".$idusuario."'");
if(count($dus)>0){
	?>
	    <script type="text/javascript">
		    Materialize.toast('<span>Error, El usuario ya se encuentra registrado.</span>',1500);
		    $("#idusuario").val("");
		    $("#idusuario").focus();
	    </script>
	<?php
}
?>
