<?php
  //link clic logo definir a donde va para cada rol
  $rutaLogo=$ruta."inicio";
  //include_once("class/sede.php");
  //$sede=new sede;
//$idsede=$_SESSION["idsede"]; 
  //$dse=$sede->muestra($idsede);
?>
  <?php
   $sw_h=true;
   if ($sw_h) {
     # code...
   
  ?>
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>
  <?php
  }
  ?>
  <header id="header" class="page-topbar">
    <div class="navbar-fixed">
        <nav class="navbar-color">
            <div class="nav-wrapper">
                <ul class="left">                      
                  <li><h1 class="logo-wrapper"><a href="<?php echo $rutaLogo ?>" class="brand-logo darken-1"><img style="border-radius: 4px;" src="<?php echo $ruta ?>recursos/images/materialize-logo.png" alt="materialize logo"></a> <span class="logo-text">INGLES PARA TODOS</span></h1></li>
                </ul>
                <ul class="right hide-on-med-and-down">
                    <li>Sistema de administracion INGLES PARA TODOS <?php echo $dse['nombre'] ?></li>
                    <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan"></i></a>
                    </li>
                    <!--
                    <li><a href="#" data-activates="chat-out" class="waves-effect waves-block waves-light chat-collapse"><i class="fa fa-sign-out"></i> Comprobantes </a>
                    </li>
                    <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light notification-button" data-activates="notifications-dropdown"><i class="fa fa-sign-out"></i>BALANCE</a>
                    </li>              -->          
                    <li><a href="<?php echo $ruta ?>session/salir.php"><i class="fa fa-sign-out"></i> Cerrar Sesion</a>
                    </li>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp; </li>
                </ul>
                <!-- notifications-dropdown -->
                <ul id="notifications-dropdown" class="dropdown-content">
                  <li>
                    <a href="#!"><i class="fa fa-print"></i> IMPRIMIR</a>
                  </li>
                  <li>
                    <a href="#!"><i class="mdi-action-add-shopping-cart"></i> PROCESAR BALANCE</a>
                  </li>
                </ul>
            </div>
        </nav>
    </div>
  </header>