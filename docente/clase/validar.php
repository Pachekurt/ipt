<?php
	$ruta="../../";
	include_once($ruta."class/estudiantecurso.php");
	$estudiantecurso=new estudiantecurso;
	include_once($ruta."class/asistencia.php");
	$asistencia=new asistencia;
    include_once($ruta."class/vestudiantecurso.php");
	$vestudiantecurso=new vestudiantecurso;

$nros=$vestudiantecurso->mostrarTodo("idestudiante=".$estudianteid);
$nros=count($nros);

if(nros>0)
{
        
}
else
{
        ?>
		<script type="text/javascript">
			swal({
          title: "El alumno No se encuentra registrado en el Sistema",
          text: "Porfavor seleccione otro alumno",
          type: "warning",
          confirmButtonColor: "#28e29e",
          confirmButtonText: "volver a ingresar",
          closeOnConfirm: false
        }, function () {      
                return.true;
                location.reload();
        }); 
		</script>
		<?php
    
}

?>