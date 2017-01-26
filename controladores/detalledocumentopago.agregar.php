<?php

header('Access-Control-Allow-Origin: *');
require_once '../negocio/DetalleDocumentoPago.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (!isset($_POST["p_codigo_pago"]) || !isset($_POST["p_codigo_documento"])) {
    Funciones::imprimeJSON(500, "Faltan parametros.", "");
    exit();
}

try {

    $objDetalleDocumentoPago = new DetalleDocumentoPago();
    $objDetalleDocumentoPago->setCodigo_pago($_POST["p_codigo_pago"]);
    $objDetalleDocumentoPago->setCodigo_documento($_POST["p_codigo_documento"]);
    $resultado = $objDetalleDocumentoPago->agregar();

    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Datos grabados correctamente", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


