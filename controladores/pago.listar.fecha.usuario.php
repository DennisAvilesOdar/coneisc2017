<?php

require_once '../negocio/Pago.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objPago = new Pago();
    $resultado=$objPago->listarFechaUsuario($_POST["p_fecha1"],$_POST["p_fecha2"],$_POST["p_codigo_usuario"]);
    
    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Pagos registrados", $resultado);
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


