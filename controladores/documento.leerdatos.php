<?php
header('Access-Control-Allow-Origin: *');
require_once '../negocio/Documento.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if(!isset($_POST["p_codigo_documento"])){
    Funciones::imprimeJSON(500, "Faltan parametros.", "");
    exit();
}
try {
    $cod_doc = $_POST["p_codigo_documento"];
    $objDocumento = new Documento();
    $datosDocumento=$objDocumento->leerDatos($cod_doc);
    
    if ($datosDocumento == true) {
        Funciones::imprimeJSON(200, "Datos del documento", $datosDocumento);
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


