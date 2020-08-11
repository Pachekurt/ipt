<?php
  session_start();  
  $ruta="../../../../";
  include_once($ruta."class/admorganidet.php");
  $admorganidet=new admorganidet;
  include_once($ruta."class/admorgani.php");
  $admorgani=new admorgani;
  include_once($ruta."class/admorganizacion.php");
  $admorganizacion=new admorganizacion;
  include_once($ruta."class/vorganigrama.php");
  $vorganigrama=new vorganigrama;
  include_once($ruta."class/vsemana.php");
  $vsemana=new vsemana;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
  $idOrg=dcUrl($lblcode);
  $dorgDet=$admorganidet->mostrarPrimero("padre=0 and idadmorgani=".$idOrg);
  $idorgdeta=$dorgDet['idadmorganidet'];
  //echo $idorgdeta;
  $dorg=$admorgani->muestra($dorgDet['idadmorgani']);
  $dsemana=$vsemana->muestra($dorg['idadmsemana']);
  $dorgz=$admorganizacion->muestra($dorg['idadmorganizacion']);
  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Organigrama <?php echo $dorgz['nombre'] ?></title>
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <style type="text/css">
    @media print {
      @page { margin: 0; }
      body { margin: 2cm; }
    }
  </style>
</head>
<body>
  <h1 style="text-align: center; font-family: arial"> ORGANIGRAMA <?php echo $dorgz['nombre']; ?></h1>
  <h4 style="border: 1px solid #ddd; border-radius: 4px; text-align: center; font-family: arial"> VALIDO PARA LA <?php echo $dsemana['glosa']; ?></h4>
  <div style="width: 100%;" class="organigrama">
    <center>
      <?php
        $idinicio=$idorgdeta;
        $f=$vorganigrama->mostrarPrimero("idvorganigrama =".$idinicio);
        echo '<ul><li ><a class="ornombre">'.$f["nombre"].'<br>'.$f["paterno"].' '.$f["materno"].'</a><br><span class="orcargo">'.$f['ncargo'].'</span>';
        $dato=$vorganigrama->mostrarTodo("padre=".$idinicio);
        if (count($dato)>0)$vorganigrama->bucleOrg($idinicio);
        echo '</li></ul>';
      ?>
    </center>
  </div>
</body>
</html>
