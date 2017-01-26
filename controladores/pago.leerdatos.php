<?php
header('Access-Control-Allow-Origin: *');
require_once '../negocio/Pago.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if(!isset($_POST["p_codigo_pago"])){
    Funciones::imprimeJSON(500, "Faltan parametros.", "");
    exit();
}
try {
    $codigoPago = $_POST["p_codigo_pago"];
    $objPago = new Pago();
    $datosPago=$objPago->leerDatos($codigoPago);
    
    if ($datosPago == true) {
        Funciones::imprimeJSON(200, "Datos del pago", $datosPago);
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


