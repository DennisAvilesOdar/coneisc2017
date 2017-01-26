<?php
header('Access-Control-Allow-Origin: *');
require_once '../negocio/Pago.clase.php';
require_once '../util/funciones/Funciones.clase.php';
if (!isset($_POST["p_codigo_pago"])) {
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}
try {
    $objPago = new Pago();
    $resultado=$objPago->anular($_POST["p_codigo_pago"]);
    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Se ha eliminado satisfactoriamente!", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


