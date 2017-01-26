<?php
//INVESTIGAR:
//Esta linea no se que permite pero debo usarla por la web service... copio el error que da cuando no se usa...
//XMLHttpRequest cannot load [URL del web service]. Origin http://localhost is not allowed by Access-Control-Allow-Origin
header('Access-Control-Allow-Origin: *');

require_once '../negocio/TipoDocumento.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objTipoDocumento = new TipoDocumento();
    $resultado=$objTipoDocumento->cargarTipoDocumento();
    
    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Tipo de documentos registrados", $resultado);
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


