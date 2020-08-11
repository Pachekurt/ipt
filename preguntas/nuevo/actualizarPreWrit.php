<?php
session_start();
include_once("../../class/pregunta.php");
$pregunta=new pregunta;
extract($_POST);
 $iddetalle=addslashes($iddetalle);
         $valores=array("idtipo"=>"'$idtipo'",
                        "detalle"=>"'$iddetalle'"
          );              

      if($pregunta->actualizar($valores,$idpregunta))
      {
          ?>
         <script  type="text/javascript">
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
      echo '0';
      }
?>