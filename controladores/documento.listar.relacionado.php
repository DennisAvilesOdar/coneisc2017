<?php
header('Access-Control-Allow-Origin: *');
require_once '../negocio/Documento.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (!isset($_POST["p_fecha1"]) && !isset($_POST["p_fecha2"]) && !isset($_POST["p_td"])) {
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {   
    $objDocumento = new Documento();
    
    $fecha1 = $_POST["p_fecha1"];
    $fecha2 = $_POST["p_fecha2"];
    $codigoTipoDocumento = $_POST["p_td"];
    
    $resultado = $objDocumento->listarRel($fecha1, $fecha2, $codigoTipoDocumento);
    
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


