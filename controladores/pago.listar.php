<?php

header('Access-Control-Allow-Origin: *');
require_once '../negocio/Pago.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (!isset($_POST["p_fecha1"]) && !isset($_POST["p_fecha2"]) && !isset($_POST["p_usuario"]) && !isset($_POST["p_estado"]) && !isset($_POST["p_tipo"])) {
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objPago = new Pago();

    $fecha1 = $_POST["p_fecha1"];
    $fecha2 = $_POST["p_fecha2"];
    $codigoUsuario = $_POST["p_usuario"];
    $estado = $_POST["p_estado"];
    $tipo = $_POST["p_tipo"];

    $resultado = $objPago->listar($fecha1, $fecha2, $codigoUsuario, $estado, $tipo);
    Funciones::imprimeJSON(200, "Pagos registrados", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
