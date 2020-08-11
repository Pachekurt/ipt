<?php
session_start();
include_once("../../class/referencia.php");
$referencia=new referencia;
extract($_POST);
 $idnombre=addslashes($idnombre);
 $iddetalle=addslashes($iddetalle);

$existe=$referencia->mostrarTodo("nombre ='$idnombre' and tipo=1");
if (count($existe)>0) 
{
  echo '2';
}else{
  $valores=array("nombre"=>"'$idnombre'",
                        "descripcion"=>"'$iddetalle'",
                        "tipo"=>"'1'",
                        "idmodulo"=>"'$idmodulo'" 
          );              

      if($referencia->insertar($valores))
      {

            $dato=$referencia->mostrarTodo("nombre ='$idnombre' and tipo=1");
            $dato=array_shift($dato);
                 echo $dato['idreferencia']; 
                 $idrcod=ecUrl($dato['idreferencia']);  
                 ?>
                    <script type="text/javascript">
                    location.href="listarL.php?idmcod=<?php echo $idmcod;?>&idacod=<?php echo $idacod;?>&idrcod=<?php echo $idrcod;?>"
                     </script>        
            <?php               
                         
      }else{
        
      echo '0';
      }
}
         


?>