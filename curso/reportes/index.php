<?php
$bandera="";

if($_POST=="")
{
    $bandera="ok";
}
  $ruta="../../";
  include_once($ruta."class/sede.php");
  $sede=new sede;
  include_once($ruta."class/admcontrato.php");
  $admcontrato=new admcontrato;
  include_once($ruta."class/dominio.php");
  $dominio=new dominio;
  include_once($ruta."class/modulo.php");
  $modulo=new modulo;
  include_once($ruta."class/vdocente.php");
  $vdocente=new vdocente;
  include_once($ruta."class/horario.php");
  $horario=new horario;

  include_once($ruta."funciones/funciones.php");
  session_start();
  extract($_GET);
  $idsede=$_SESSION["idsede"];
  $dsede=$sede->muestra($idsede);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
      $hd_titulo="Reporte - ".$dsede['nombre'];
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
          $idmenu=1028;
          include_once($ruta."aside.php");
        ?>
        
        <br><br><br>
   
<section id="content">
    <div class="container-fluid bg-3 text-center">    
            <div class="grid-example col s12 m6 teal lighten-2">
                  <h1 aling="center"><strong>REPORTES DE CLASES</strong></h1>
            </div>
            
        
            <br>
        
            <div class="row">
                    <div class="col s3 offset-s2 grid-example">
                    <h6 font weight="normal">REPORTE POR MODULO</h6>
                    </div>
                    <div class="col s2 m2 l2">
                         
                              <label>Modulo</label>
                              <select id="idmodulo" name="idmodulo">
                                <option value="0">Seleccionar Modulo</option>
                                <?php
                                foreach($modulo->mostrarTodo("") as $f)
                                {
                                  ?>
                                   <option  value="<?php echo $f['idmodulo'];  ?>" ><?php echo $f['nombre']." (".$f['descripcion'].")" ?></option>
                                  <?php
                                }
                                ?>
                              </select>
                            
                    </div>
                    <div class="col s1 m2 l2"> 
                        <button  class="btn btn-success" id="btnSsave1" type="button" data-toggle="dropdown" href="">IMPRIMIR</button>
                    </div>
                    <div class="col s2 m2 l2"> 
                        <button class="btn btn-primary" id="btnSsaveV1" type="button" data-toggle="dropdown" href="">GENERAR REPORTE</button>
                    </div>
              </div>
              <br><br>
              <div class="row">
                    <div class="col s3 offset-s2 grid-example">
                    <h6 font weight="normal">REPORTE POR DOCENTE</h6>
                    </div>
                    <div class="col s2 m2 l2"> 
                              <label>Modulo</label>
                              <select id="iddocente" name="iddocente">
                                <option value="0">Seleccionar Docente</option>
                                <?php
                                foreach($vdocente->mostrarTodo("estado =1") as $f)
                                {
                                  ?>
                                   <option  value="<?php echo $f['idvdocente'];  ?>" ><?php echo $f['nombre']." ".$f['paterno'] ?></option>
                                  <?php
                                }
                                ?>
                              </select> 
                    </div>
                    
                    <div class="col s1 m2 l2"> 
                        <button  class="btn btn-success" id="btnSsave2" type="button" data-toggle="dropdown" href="">IMPRIMIR</button>
                    </div>
                  <div class="col s2 m2 l2"> 
                        <button class="btn btn-primary" id="btnSsaveV2" type="button" data-toggle="dropdown" href="">GENERAR REPORTE</button>
                    </div>
              </div>
              <br><br>
              <div class="row">
                    <div class="col s3 offset-s2 grid-example">
                    <h6 font weight="normal">REPORTE POR HORARIO</h6>
                    </div>
                    <div class="col s2 m2 l2"> 
                              <label>Modulo</label>
                              <select id="idhorario" name="idhorario">
                                <option value="0">Seleccionar Horario</option>
                                <?php
                                foreach($horario->mostrarTodo("") as $f)
                                {
                                  ?>
                                   <option  value="<?php echo $f['idhorario'];  ?>" ><?php echo $f['inicio']." a ".$f['fin']."" ?></option>
                                  <?php
                                }
                                ?>
                              </select> 
                    </div>
                    
                    <div class="col s1 m2 l2"> 
                        <button  class="btn btn-success" id="btnSsave3" type="button" data-toggle="dropdown" href="">IMPRIMIR</button>
                    </div>
                    <div class="col s2 m2 l2"> 
                        <button  class="btn btn-primary" id="btnSsaveV3" type="button" data-toggle="dropdown" href="">GENERAR REPORTE</button>
                    </div>
              </div>
        </div>
</section>
    </div></div>
    <div id="idresultado"></div>
    <!-- end -->
    <!-- jQuery Library -->
    <?php
      include_once($ruta."includes/script_basico.php");
      include_once($ruta."includes/script_tabla.php");
      include_once($ruta."includes/script_tablax.php");
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
      
    });
    $("#btnSsave1").click(function(){
         if (validar()) 
         {        
            idmodulo=$("#idmodulo").val();
            window.open("imprimirpormodulo/?idmodulo="+$("#idmodulo").val(),"_blank");
         }else{
            swal("DATOS FALTANTES SELECCIONE UN MODULO");
         }
      });
    $("#btnSsaveV1").click(function(){
         if (validar()) 
         {        
            idmodulo=$("#idmodulo").val();
        window.open("vistapormodulo/?idmodulo="+$("#idmodulo").val(),"_blank");
         }else{
            swal("DATOS FALTANTES SELECCIONE UN MODULO");
         }
       
      });
        
    $("#btnSsave2").click(function(){
         if (validar1()) 
         {        
           iddocente=$("#iddocente").val();
        window.open("imprimirpordocente/?iddocente="+$("#iddocente").val(),"_blank");
         }else{
            swal("DATOS FALTANTES SELECCIONE UN DOCENTE");
         }
        
      });
    $("#btnSsaveV2").click(function(){
        if (validar1()) 
         {        
           iddocente=$("#iddocente").val();
        window.open("vistapordocente/?iddocente="+$("#iddocente").val(),"_blank");
         }else{
            swal("DATOS FALTANTES SELECCIONE UN DOCENTE");
         }
       
      });
        
    $("#btnSsave3").click(function(){
        if (validar2()) 
         {        
            idhorario=$("#idhorario").val();
        window.open("imprimirporhorario/?idhorario="+$("#idhorario").val(),"_blank");
         }else{
            swal("DATOS FALTANTES SELECCIONE UN HORARIO");
         }
       
       
      });
    $("#btnSsaveV3").click(function(){
          if (validar2()) 
         {        
             idhorario=$("#idhorario").val();
        window.open("vistaporhorario/?idhorario="+$("#idhorario").val(),"_blank");
         }else{
            swal("DATOS FALTANTES SELECCIONE UN HORARIO");
         }
       
       
      });
           
    function validar(){
        retorno=true;
        mod=$('#idmodulo').val();
        if(mod=='0'){
          retorno=false;
        }
        return retorno;
        }
    function validar1(){
        retorno=true;
        doc=$('#iddocente').val();
        if(doc=='0'){
          retorno=false;
        }
        return retorno;
        }
    function validar2(){
        retorno=true;
        hor=$('#idhorario').val();
        if(hor=='0'){
          retorno=false;
        }
        return retorno;
        }
        
    </script>
</body>

</html>

