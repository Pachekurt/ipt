<?php
$ruta="../../../";
include_once($ruta."class/usuario.php");
$usuario=new usuario;
include_once($ruta."funciones/funciones.php");
extract($_POST);

$idusante=md5(e($idusante));
$dus=$usuario->mostrarUltimo("pass='".$idusante."' and usuario='".$idusmod."'");
if(count($dus)==0){
	?>
	    <script type="text/javascript">
		    Materialize.toast('<span>Error, La contraseña no coicide con el usuario.</span>',1500);
		    $("#idusante").val("");
		    $("#idusante").focus();
	    </script>
	<?php
}
?>
