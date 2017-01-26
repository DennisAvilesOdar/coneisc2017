<?php

require_once '../negocio/Documento.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objDocumento = new Documento();
    $resultado=$objDocumento->listarDocumentoArea($_POST["p_codigo_usuario"],$_POST["p_codigo_td"]);
    
    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Documentos registrados", $resultado);
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


