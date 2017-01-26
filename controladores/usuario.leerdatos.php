<?php

require_once '../negocio/Usuario.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objUsuario = new Usuario();
    $datosUsuario=$objUsuario->leerDatos($_POST["p_codigo_usuario"]);
    
    if ($datosUsuario == true) {
        Funciones::imprimeJSON(200, "Datos del usuario", $datosUsuario);
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


