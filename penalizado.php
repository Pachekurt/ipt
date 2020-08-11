<?php 

$ruta="";
$folder="";
//echo $_SESSION["faltaSistema"];
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PENALIZADO | NAVLA</title>

    <link href="<?php echo $ruta; ?>recursos/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $ruta; ?>recursos/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo $ruta; ?>recursos/css/animate.css" rel="stylesheet">
    <link href="<?php echo $ruta; ?>recursos/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <img src="<?php echo $ruta; ?>imagenes/logo.png">

            </div>
            <div class="form-group has-feedback"> 
                <div class="alert alert-warning alert-dismissable">
                    <h4><i class="icon fa fa-warning"></i> Su terminal fue Penalizado.</h4>
                        Vuelva a intentarlo mas tarde

                        <a class="btn btn-sm btn-white btn-block" href="despenaliza.php">DESPENALIZAR</a>
                </div>
            </div>
            <p class="m-t"> <small>Admin - derechos reservados navla.com &copy; 2016</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo $ruta; ?>recursos/js/jquery-2.1.1.js"></script>
    <script src="<?php echo $ruta; ?>recursos/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    </script>

</body>

</html>
