<?php
$ruta="../";
extract($_POST);
include_once($ruta."class/usuario.php");$usuario=new usuario;
include_once($ruta."class/rol.php");$rol=new rol;
include_once($ruta."class/dominio.php");$dominio=new dominio;
include_once($ruta."funciones/funciones.php");
$contrasenia=md5(e($contrasenia));
$usuarios ="$usuarios";$contrasenia ="$contrasenia";
$datosUsuario=$usuario->mostrarTodo("usuario='".$usuarios."' and pass='".$contrasenia."'");
if (count($datosUsuario)>0){
$datosUsuario=array_shift($datosUsuario);session_start();

$_SESSION["estadoSesion"] = 'Jhulios20005';
$_SESSION["rolusuario"] = $datosUsuario['idrol'];
$_SESSION["usuario"]=$datosUsuario['usuario'];
$_SESSION["codusuario"]=$datosUsuario['idusuario'];
$_SESSION["idsede"]=$datosUsuario['idsede'];

$datosRol=$rol->mostrar($datosUsuario['idrol']);
$datosRol=array_shift($datosRol);
 ?><script>location.href = "inicio/";</script><?php
}else{
session_start();
if (!isset($_SESSION["faltaSistema"]))
{$_SESSION['faltaSistema']="0";}
$_SESSION['faltaSistema']=$_SESSION['faltaSistema']+1;
$intentosFaltantes=3-$_SESSION['faltaSistema'];
if ($_SESSION["faltaSistema"]>=3) { ?><script>location.href = "penalizado.php";</script> <?php }
else { ?>
<div id="card-alert" class="card red lighten-5">
  <div class="card-content red-text">
    <p>FALTA AL SISTEMA : El Usuario o Contraseña no Coinciden. Intentelo Nuevamente. Intentos restantes <?php echo $intentosFaltantes;?></p>
  </div>
  <button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
</div>
<?php }}?>
