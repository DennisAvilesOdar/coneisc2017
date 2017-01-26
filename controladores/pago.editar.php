<?php

require_once '../negocio/Pago.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objPago = new Pago();
    $objPago->setCodigo_pago($_POST["p_codigo_pago"]);
    $objPago->setDescripcion($_POST["p_descripcion"]);
    $objPago->setFecha_a_pagar($_POST["p_fecha_a_pagar"]);
    $objPago->setMonto($_POST["p_monto"]);
    $objPago->setCodigo_usuario($_POST["p_codigo_usuario"]);
    $objPago->setEstado($_POST["p_estado"]);
    $resultado=$objPago->editar();
    
    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Datos editados correctamente", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


