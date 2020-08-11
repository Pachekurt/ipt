<?php
session_start();
include_once("../../class/pregunta.php");
$pregunta=new pregunta;
extract($_POST);
 $iddetalle=addslashes($iddetalle);
         $valores=array("idmodulo"=>"'$idmodulo'",
                        "idasignatura"=>"'$idasignatura'",
                        "idtipo"=>"'$idtipo'",
                        "detalle"=>"'$iddetalle'",
                        //"a"=>"''",
                        //"b"=>"''",
                        //"c"=>"''",
                        "respuesta"=>"'0'"
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