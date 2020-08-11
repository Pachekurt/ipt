<?php
$ruta="../../../../../";
include_once($ruta."class/domicilio.php");
$domicilio=new domicilio;
include_once($ruta."class/laboral.php");
$laboral=new laboral;
include_once($ruta."funciones/funciones.php");
extract($_POST);
session_start();
//$idpersona=dcUrl($lblcode);
if (!isset($dom)) 
{
   $dom=0;
}
if (!isset($lab)) 
{
   $lab=0;
}
if ($dom+$lab>0) {
  # code...
  
  if ($dom==1) 
  {
    echo "DOMICILIO";
    // REGISTRA DOMICILIO
    $valoresANTES=array(
        "tipoDomicilio"=>"'SECUNDARIO'",
        "indicador"=>"'0'"
    ); 
    $domicilio->actualizarFila($valoresANTES,"idpersona=".$idpersona);
    $valores=array(
      "idpersona"=>"'$idpersona'",
      "idbarrio"=>"'$idzona'",
      "nombre"=>"'$iddireccion'",
      "telefono"=>"'$idfono'",
      "descripcion"=>"'$iddesc'",
      "tipoDomicilio"=>"'PRINCIPAL'",
      "geox"=>"'$geox'",
      "geoy"=>"'$geoy'",
      "indicador"=>"'1'"
    ); 
    if($domicilio->insertar($valores)) {
      ?>
      <script type="text/javascript">
        setTimeout(function() {
                Materialize.toast('<span>Domicilio registrado Correctamente</span>', 1500);
            }, 10);
      </script>
    <?php
    }
  }
  if ($lab==1) {
    echo "LANORAL";
     // REGISTRA LABORAL
    $valoresANTES=array(
      "tipolaboral"=>"'SECUNDARIO'",
      "indicador"=>"'0'"
     ); 
    $laboral->actualizarFila($valoresANTES,"idpersona=".$idpersona);
    $valores=array(
      "idpersona"=>"'$idpersona'",
      "idbarrio"=>"'$idzonal'",
      "nombre"=>"'$iddireccionl'",
      "telefono"=>"'$idfonol'",
      "descripcion"=>"'$iddescl'",

      "empresa"=>"'$idempresa'",
      "cargo"=>"'$idcargo'",
      "antiguedad"=>"'$idantiguedad'",
      "ingresos"=>"'$idmensual'",

      "tipolaboral"=>"'PRINCIPAL'",
      "indicador"=>"'1'"
     ); 
    if($laboral->insertar($valores)){
      ?>
      <script type="text/javascript">
        setTimeout(function() {
                Materialize.toast('<span>Datos laborales registrados correctamente</span>', 1500);
            }, 10);
      </script>
    <?php
    }
  }
  ?>
    <script type="text/javascript">
      swal({
        title: "Exito !!!",
        text: "Datos Registrado Correctamente",
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
}
else{
   ?>
    <script type="text/javascript">
      setTimeout(function() {
              Materialize.toast('<span>Debe Ingresar Datos</span>', 1500);
          }, 1500);
    </script>
  <?php
}
?>