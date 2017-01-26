<?php
header('Access-Control-Allow-Origin: *');
require_once '../negocio/Usuario.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objUsuario = new Usuario();
    $resultado=$objUsuario->listar();
    
    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Usuarios registrados", $resultado);
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


