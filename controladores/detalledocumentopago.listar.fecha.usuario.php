<?php

require_once '../negocio/DetalleDocumentoPago.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objDetalleDocumentoPago = new DetalleDocumentoPago();
    $resultado=$objDetalleDocumentoPago->listar($_POST["p_fecha1"],$_POST["p_fecha2"],$_POST["p_codigo_usuario"]);
    
    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Detalle de documentos de pago registrados", $resultado);
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


