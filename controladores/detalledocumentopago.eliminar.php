<?php

require_once '../negocio/DetalleDocumentoPago.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objDetalleDocumentoPago = new DetalleDocumentoPago();
    $resultado=$objDetalleDocumentoPago->eliminar($_POST["p_codigo_pago"],$_POST["p_codigo_documento"]);
    
    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Datos eliminados correctamente", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


