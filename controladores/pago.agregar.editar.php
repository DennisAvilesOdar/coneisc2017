<?php

header('Access-Control-Allow-Origin: *');
require_once '../negocio/Pago.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (!isset($_POST["p_datosFormulario"])) {
    Funciones::imprimeJSON(500, "Faltan parametros.", "");
    exit();
}

$datosFormulario = $_POST["p_datosFormulario"];
parse_str($datosFormulario, $datosFormularioArray);

//print_r($datosFormularioArray); // convertir todos los datos que llegan concatenados a un array

try {
    $objPago = new Pago();
    
    $objPago->setDescripcion($datosFormularioArray["txtdescripcion"]);
    $objPago->setFecha_a_pagar($datosFormularioArray["txtfechapago"]);
    $objPago->setMonto($datosFormularioArray["txtmonto"]);
    $objPago->setCodigo_usuario($datosFormularioArray["txtusuario"]);
    $objPago->setEstado($datosFormularioArray["cboestadomodal"]);
 
    if ($datosFormularioArray["txttipooperacion"] == "agregar") {
        $resultado = $objPago->agregar();
        if ($resultado == true) {
            Funciones::imprimeJSON(200, "Grabado con exito.", "");
        }
    } else {
        $objPago->setCodigo_pago($datosFormularioArray["txtcodigo"]);
        $resultado = $objPago->editar();
        if ($resultado == true) {
            Funciones::imprimeJSON(200, "Grabado con exito.", "");
        }
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
exit();
