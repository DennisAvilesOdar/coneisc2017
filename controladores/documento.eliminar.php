<?php
header('Access-Control-Allow-Origin: *');
require_once '../negocio/Documento.clase.php';
require_once '../util/funciones/Funciones.clase.php';
if (!isset($_POST["p_codigo_documento"])) {
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}
try {
    $objDocumento = new Documento();
    $resultado=$objDocumento->anular($_POST["p_codigo_documento"]);
    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Se ha eliminado satisfactoriamente!", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


