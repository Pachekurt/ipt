<?php
  $ruta="../../";
  include_once($ruta."class/vfactura.php");
  $vfactura=new vfactura;
  include_once($ruta."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."class/admsucursal.php");
  $admsucursal=new admsucursal;
  include_once($ruta."class/admdosificacion.php");
  $admdosificacion=new admdosificacion;
  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $idsede=$_SESSION["idsede"];
  $dse=$sede->muestra($idsede);

  $dsuc=$admsucursal->mostrarUltimo("idsede=".$idsede);
  $idsucursal=$dsuc['idadmsucursal'];
  $ddos=$admdosificacion->mostrarUltimo("idadmsucursal=".$idsucursal." and estado=1");
  $iddos=$ddos['idadmdosificacion'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="Administrar Facturas ".$dse['nombre'];
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_tabla.php");
    include_once($ruta."includes/head_tablax.php");
  ?>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1056;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l12">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="section"> 
               <input id="idsede" style="text-align: center;" name="idsede" type="hidden"  class="validate" value= "<?php echo $idsede ?>">
                <input id="idsucursal" style="text-align: center;" name="idsucursal" type="hidden"  class="validate" value= "<?php echo $idsucursal ?>">
                 <input id="iddosificacion" style="text-align: center;" name="iddosificacion" type="hidden"  class="validate" value= "<?php echo $iddos ?>">
              <div class="col s12 m12 l6">
                 <table id="tablarecord" class="display" cellspacing="0" width="100%"
                      style="font-size: 13px; color:##060606;">
                   
                           <thead>
                          <tr>                                       
                              <th>FECHA</th>
                              <th>NRO</th> 
                              <th>MATRICULA</th> 
                              <th>DESDE</th> 
                              <th>MONTO</th>
                              <th>SEDE</th>
                              <th>ESTADO</th>
                              <th>ACCIONES</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                  </table>
              </div>
            </div>
          </div>
          <?php
            include_once("../footer.php");
          ?>
        </section>
      </div>
    </div> 
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
    $( "#idsede" ).change(function() {
      location.href="?lblcode="+$('select[name=idsede]').val();
    });
    
        $(document).ready(function(){
      idsede=$('#idsede').val();
      idsucursal=$('#idsucursal').val();
      iddosificacion=$('#iddosificacion').val();
       
        $("#tablarecord").dataTable().fnDestroy();
        var str="idsede="+idsede+"&idsucursal="+idsucursal+"&iddos="+iddosificacion;
       // alert(str);
        var table=$("#tablarecord").dataTable({
        "ajax":{
          "method":"POST",
          "url":"mostrarfacturas.php?"+str
        },
        "columns":[
          {"data":"fecha"},
          {"data":"nro"},
          {"data":"matricula"}, 
          {"data":"desde"},
          {"data":"monto"},
          {"data":"sede"},
          {"data":"estado"} ,
            {"defaultContent":"<a class='btn-jh red idprint'><i class='mdi-action-print'></i></a>,<a class='btn-jh blue idmod'><i class='fa fa-edit'></i></a>"}  
         
        ],
           
            "ordering": false,
            "info":     false,
      }); 
     
      
        GetData("#tablarecord tbody",table);
    });
   function GetData(tbody,table){
        $(tbody).on("click","a.idprint",function(){
          var data=table.api().row( $(this).parents("tr") ).data();        
          console.log(data);
          //alert(data);

           window.open("../impresion/computarizada/?lblcode="+data.lbl,"_blank");
          
        });
        $(tbody).on("click","a.idmod",function(){
          var data=table.api().row( $(this).parents("tr") ).data();        
          console.log(data);
          //alert(data);  
          window.open("modificar.php?lblcode="+data.lbl ,"_blank");
          
        });
      }

    </script>
</body>

</html>