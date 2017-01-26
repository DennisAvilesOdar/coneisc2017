<?php

require_once '../negocio/DetalleDocumentoPago.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objDetalleDocumentoPago = new DetalleDocumentoPago();
    $resultado=$objDetalleDocumentoPago->listar();
    
    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Detalle de documentos de pago registrados", $resultado);
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


