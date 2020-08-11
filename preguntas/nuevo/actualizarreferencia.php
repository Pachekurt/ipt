<?php
session_start();
include_once("../../class/referencia.php");
$referencia=new referencia;
extract($_POST);
 $iddetalle2=addslashes($iddetalle2);
 $idnombre2=addslashes($idnombre2);

  $valores=array("nombre"=>"'$idnombre2'",
                "descripcion"=>"'$iddetalle2'"
                //"tipo"=>"'1'"
                        //"idmodulo"=>"''" 
          );              

      if($referencia->actualizar($valores,$idreferenciaSel))
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