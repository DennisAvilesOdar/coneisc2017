<?php

require_once '../negocio/Usuario.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objUsuario = new Usuario();
    $resultado=$objUsuario->eliminar($_POST["p_codigo_usuario"]);
    
    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Datos eliminados correctamente", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


