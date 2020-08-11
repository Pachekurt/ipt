<?php
  $ruta="../../../";
  session_start();
  include_once($ruta."class/vejecutivo.php");
  $vejecutivo=new vejecutivo;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/vtitular.php");
  $vtitular=new vtitular; 
  include_once($ruta."class/persona.php");
  $persona=new persona;
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/cobcartera.php");
  $cobcartera=new cobcartera;
  include_once($ruta."class/admcontratodelle.php");
  $admcontratodelle=new admcontratodelle;
  include_once($ruta."class/vcontratoplan.php");
  $vcontratoplan=new vcontratoplan;
  include_once($ruta."class/usuario.php");
  $usuario=new usuario;
  include_once($ruta."funciones/funciones.php");
  extract($_GET);
  $idsede=$_SESSION["idsede"];
  $dse=$sede->muestra($idsede);
/************************************************/
// condicionamos la fecha inicio
/*************************************/
  $fechain=date("Y-m")."-01";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php
    $hd_titulo="REIMPRIMIR " ;
    include_once($ruta."includes/head_basico.php");
    include_once($ruta."includes/head_tabla.php");
  ?>
  <style type="text/css">
    .estIn input{
      border:solid 1px #4286f4;
      width: 110px;
    }
  </style>
</head>
<body>
    <?php
      include_once($ruta."head.php");
    ?>
    <div id="main">
      <div class="wrapper">
        <?php
          $idmenu=1031;
          include_once($ruta."aside.php");
        ?>
        <section id="content">
          <div id="breadcrumbs-wrapper">
            <div class="container">
              <div class="row">
                <div class="col s12 m12 l5">
                  <h5 class="breadcrumbs-title"><i class="fa fa-tag"></i> <?php echo $hd_titulo; ?></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="formcontent">
                <div class="col s12 m4 l3">
                  <h4 class="titulo">Reimpresion Record Produccion</h4>
                  <p style="text-align: justify;">
                     
                  </p>
                </div>
                <div class="col s12 m8 l9">
                  <form class="col s12" id="idform" action="return false" onsubmit="return false" method="POST">
                    <input type="hidden" name="idcontrato" id="idcontrato" value="<?php echo $idcontrato; ?>">
                    <div class="row">
                    
                      <div class="input-field col s12 m6 l2">
                        <input id="nrocontrato" style="text-align: center;" name="nrocontrato" type="number"  class="validate">
                        <label for="nrocontrato">NRO CONTRATO</label>
                      </div>
                      <div class="input-field col s12 m6 l4">
                        <a style="width: 100%" id="btnSsave" class="btn waves-effect waves-light darken-3 purple"><i class="fa fa-eye"></i> Buscar</a><br><br><br>
                      </div>
                    </div>
                  </form>
                </div>&nbsp;
                <div class="col s12 m12 l12">
                  <div class="divider"></div>
                </div>
                <div class="col s12 m12 l12">
                  <div class="divider"></div>
                  

                <table id="tablarecord" class="display" cellspacing="0" width="100%"
                      style="font-size: 13px; color:##060606;">
                   
                           <thead>
                          <tr>                                       
                              <th>ID</th>
                              <th>NRO RECORD</th>
                              <th>CONTRATO</th>  
                              <th>MONTO</th> 
                              <th>DETALLE</th>
                              <th>IMPRIMIR</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                  </table>


                </div>&nbsp;<br><br><br><br><br><br>
              </div>
            </div>
          </div>
          <?php
            include_once("../../footer.php");
          ?>
        </section>
      </div>
    </div>
    <div id="idresultado"></div>
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
    ?>
    <script type="text/javascript">
   

       $("#btnprint").click(function(){
          
           nrorecord=$("#nrocontrato").val();
           //alert(nrorecord);
            $.ajax({
              url: "imprimir.php",
              type: "POST",
              data: "nrorecord="+nrorecord,
              success: function(resp){ 
              // alert(resp);
               window.open("../administrar/record/imprimir/?lblcode="+resp,"_blank");
              }
            }); 
      });


       $("#btnSsave").click(function(){
      nrocontrato=$('#nrocontrato').val();
       
        $("#tablarecord").dataTable().fnDestroy();
        var str="id="+nrocontrato;
       // alert(str);
        var table=$("#tablarecord").dataTable({
        "ajax":{
          "method":"POST",
          "url":"mostrarRecords.php?"+str
        },
        "columns":[
          {"data":"id"},
          {"data":"numero"},
          {"data":"contrato"},
          {"data":"monto"},
          {"data":"detalle"} ,
            {"defaultContent":"<a class='btn-jh red idprint'><i class='mdi-navigation-check'></i></a>"}
         
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

           window.open("../administrar/record/imprimir/?lblcode="+data.codigo,"_blank");
          
        });
      }
    </script>
</body>
</html>