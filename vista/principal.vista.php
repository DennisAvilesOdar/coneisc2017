<?php
//    if (isset($_COOKIE["loginusuario"])){
//        $loginUsuario = $_COOKIE["loginusuario"];
//    }else{
//        $loginUsuario = "";
//    }

//require_once 'https://coneii-2017.herokuapp.com/webservice/sesion.validar.vista.php';
require_once '../util/funciones/definiciones.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo C_NOMBRE_SOFTWARE_GESTION ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php include 'estilos.vista.php'; ?>
    </head>
    <body class="skin-green layout-top-nav">
        <div class="wrapper">
            <?php include 'menu.vista.php'; ?>

            <div class="content-wrapper">
                <section class="content">
                    <p>
                        Te damos la bienvenida al nuevo sistema desarrollado especialmente para el coneii 2017.<br>
                        Esperamos que sea de mucha utilidad y creemos profundamente que el evento será todo un exito.
                    </p>
                </section>
            </div>
        </div>

        <?php
        include 'scripts.vista.php';
        ?>
    </body>
</html>
