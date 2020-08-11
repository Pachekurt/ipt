<?php
session_start();
include_once("../../class/pregunta.php");
$pregunta=new pregunta;
extract($_POST);
 $iddetalle=addslashes($iddetalle);
 $idopa=addslashes($idopa);
 $idopb=addslashes($idopb);
 $idopc=addslashes($idopc);

         $valores=array("idmodulo"=>"'$idmodulo'",
                        "idasignatura"=>"'$idasignatura'",
                        "idtipo"=>"'$idtipo'",
                        "detalle"=>"'$iddetalle'",
                        "referencia"=>"'ninguna'",
                        "a"=>"'$idopa'",
                        "b"=>"'$idopb'",
                        "c"=>"'$idopc'",
                        "respuesta"=>"'$idrespuesta'"
          );              

      if($pregunta->insertar($valores))
      {
          ?>
         <script  type="text/javascript">
         $('#btnSave').attr("disabled",true);
            swal({
                    title: "Exito !!!",
                    text: "Datos Registrados Correctamente",
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
      echo '0';
      }
?>