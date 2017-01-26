<?php

require_once '../negocio/Usuario.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objUsuario = new Usuario();
    $objUsuario->setNombre($_POST["p_nombre"]);
    $objUsuario->setCorreo($_POST["p_correo"]);
    $objUsuario->setContrasena($_POST["p_contrasena"]);
    $objUsuario->setCodigo_area($_POST["p_codigo_area"]);
    $resultado=$objUsuario->agregar();
    
    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Datos grabados correctamente", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


