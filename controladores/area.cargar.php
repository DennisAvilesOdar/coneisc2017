<?php

require_once '../negocio/Area.clase.php';
require_once '../util/funciones/Funciones.clase.php';




try {
    $objArea = new Area();
    $resultado=$objArea->cargarArea();
    
    if ($resultado == true) {
        Funciones::imprimeJSON(200, "Areas registrados", $resultado);
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


