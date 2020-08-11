<?php 
	$ruta="../../";
	include_once($ruta."class/estudiantecurso.php");
	$estudiantecurso=new estudiantecurso;
	include_once($ruta."class/asistencia.php");
	$asistencia=new asistencia;
    include_once($ruta."class/vestudiantecurso.php");
	$vestudiantecurso=new vestudiantecurso;
    include_once($ruta."class/admestudiante.php");
	$admestudiante=new admestudiante;

extract($_POST);
	session_start();

	$valores=array(
	    "idestudiante"=>"'$estudianteid'",
	    "idcurso"=>"'$cursoid'", 
        "estado"=>"'2'",
        "estadoexamen"=>"'0'"   
	);	


    $nros=$admestudiante->mostrarTodo("idestudiante=".$estudianteid);
    $nros=count($nros);


$datoestudiante = $admestudiante->muestra($estudianteid);
$dato=$datoestudiante['estadoacademico'];

if($dato=='153'){
     ?>
                <script  type="text/javascript">
                swal("Error!", "El Estudiante no puede reservar debe pasar por administracion", "error")
                </script>

                <?php
}
else
{
        if($nros>0)
{
    
            $nro=$vestudiantecurso->mostrarTodo("idcurso=".$cursoid." and idestudiante=".$estudianteid);
            $nro=count($nro);
            if($nro==0)
            {
            if($estudiantecurso->insertar($valores))
            {
                
            $numero = $estudiantecurso->mostrarUltimo("idestudiante=$estudianteid and idcurso=$cursoid");
            //$numero=array_shift($numero);
            $dato=$numero['idestudiantecurso'];
                
                
            $fechaasis=date('Y-m-d');
            $valores2=array( 
                "idestudiantecurso"=>"'$dato'",
                "fechaasistencia"=>"'$fechaasis'",
                "asis"=>"'1'"
            );    
                    if($asistencia->insertar($valores2)){
                                ?>
                                 <script  type="text/javascript">
                                     $('#btnSave').attr("disabled",true);
                                        swal({
                                            title: "Exito !!!",
                                            text: "Se registro la observación correctamente",
                                            type: "success",
                                            //showCancelButton: false,
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

            }else{
                ?>
                <script type="text/javascript">
                    Materialize.toast('<span>No se pudo guardar el registro</span>', 1500);
                </script>
                <?php
            }
            }else{
            ?>
                <script  type="text/javascript">
                swal("Error!", "El alumno ya se encuentra registrado en este curso", "error")
                </script>

                <?php
            
            }
        }
        else
        {
           ?>
            
        <script  type="text/javascript">
                swal("Error!", "El numero de Carnet no existe", "error")
                </script>

               
                <?php 
            
        }


}


?>