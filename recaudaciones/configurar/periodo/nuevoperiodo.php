<?php
  $ruta="../../../";
  include_once($ruta."class/vcartera.php");
  $vcartera=new vcartera;
  include_once($ruta."class/cobresumen.php");
  $cobresumen=new cobresumen;
  include_once($ruta."funciones/funciones.php");
  extract($_POST);
  $fecha=date('Y-m-d');
  $mes=obtenerMes($fecha);
  $consulta="SELECT idejecutivo, count(*) as cuentas, sum(saldo) as saldo,sum(mensualidad) as mensualidad FROM duartema_nacional.vcartera group by idejecutivo";
  $i=0;
  foreach($vcartera->sql($consulta) as $f)
  {
    $i++;
    $idejecutivo=$f['idejecutivo'];
    $cantidad=$f['cuentas'];
    $cobroproy=number_format($f['mensualidad'], 2, '.', '');
    $saldo=number_format($f['saldo'], 2, '.', '');
    $val2=array(
      "fecha"=>"'$fecha'",
      "mes"=>"'$mes'",
      "idejecutivo"=>"'$idejecutivo'",
      "cantidad"=>"'$cantidad'",
      "cuotagral"=>"'$cobroproy'",
      "saldogral"=>"'$saldo'",
      "estado"=>"'1'"
    );
    $cobresumen->insertar($val2);
  }
  ?>
    <script  type="text/javascript">
      swal({
        title: "Exito !!!",
        text: "Cuentas Asignadas Correctamente",
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
?>