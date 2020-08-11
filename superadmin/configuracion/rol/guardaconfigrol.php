<?php 
	$ruta="../../../";
	include_once($ruta."class/rol.php");
	$rol=new rol;
	include_once($ruta."class/menu.php");
	$menu=new menu;
	
	include_once($ruta."class/rolmenu.php");
	$rolmenu=new rolmenu;

	include_once($ruta."funciones/funciones.php");

	extract($_POST);
	session_start();
	$idrol=dcUrl($lblcode);
	$rolmenu->eliminarTodo("idrol=".$idrol);
	$postNameArr = array();
	foreach($menu->mostrarTodo("") as $dmenu)
    {
		array_push($postNameArr, "id-".$dmenu['idmenu']);
    }
    $postIdentifierArr = array();
        
    foreach ($postNameArr as $postName)
    {
        if (array_key_exists($postName, $_POST))
        {
            $idmenus = explode("-", $postName);
            $idmenu=$idmenus[1];
            //echo "EXISTE el id menu  ".$idmenu;
            $valores=array(
			    "idrol"=>"'$idrol'",
			    "idmenu"=>"'$idmenu'"
			);	
			$rolmenu->insertar($valores);
        }
    }
    $valores=array(
	    "idrol"=>"'$idrol'",
	    "idmenu"=>"'1000'"
	);	
	$rolmenu->insertar($valores);
?>
<script  type="text/javascript">
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