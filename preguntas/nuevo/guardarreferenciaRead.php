<?php
session_start();
include_once("../../class/referencia.php");
$referencia=new referencia;
extract($_POST);
 $idnombre=addslashes($idnombre);
 $iddetalle=addslashes($iddetalle);

$existe=$referencia->mostrarTodo("nombre ='$idnombre' and tipo=2");
if (count($existe)>0) 
{
  echo '2';
}else{
  $valores=array("nombre"=>"'$idnombre'",
                        "descripcion"=>"'$iddetalle'",
                        "tipo"=>"'2'",
                        "idmodulo"=>"'$idmodulo'" 
          );              

      if($referencia->insertar($valores))
      {

            $dato=$referencia->mostrarTodo("nombre ='$idnombre' and tipo=2");
            $dato=array_shift($dato);
                 echo $dato['idreferencia']; 
                 $idrcod=ecUrl($dato['idreferencia']);  
                 ?>
                    <script type="text/javascript">
                    location.href="listarRead.php?idmcod=<?php echo $idmcod;?>&idacod=<?php echo $idacod;?>&idrcod=<?php echo $idrcod;?>"
                     </script>        
            <?php               
                         
      }else{
        
      echo '0';
      }
}
         


?>