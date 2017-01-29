<?php

header('Access-Control-Allow-Origin: *');
require_once '../negocio/Documento.clase.php';
require_once '../util/funciones/Funciones.clase.php';
if (!isset($_POST["p_datosFormulario"])) {
    Funciones::imprimeJSON(500, "Faltan parametros.", "");
    exit();
}
$datosFormulario = $_POST["p_datosFormulario"];
parse_str($datosFormulario, $datosFormularioArray);
try {
    
    $nombre_img = $_FILES['imagen']['name'];
    $tipo_img = $_FILES['imagen']['type'];
    $tamano = $_FILES['imagen']['size'];
    
    $objDocumento = new Documento();
    
    $objDocumento->setNumero_documento($datosFormularioArray["txtnumerodocumento"]);
    $objDocumento->setDescripcion($datosFormularioArray["txtdescripcion"]);
    $objDocumento->setMonto($datosFormularioArray["txtmonto"]);
    $objDocumento->setCodigo_usuario($datosFormularioArray["txtusuario"]);
    $objDocumento->setCodigo_tipo_documento($datosFormularioArray["cbotipodocumentomodal"]);
    
    if(($nombre_img == !NULL) && ($tamano <= 200000)){
        if (($tipo_img == "image/gif") || ($tipo_img == "image/jpeg") || ($tipo_img == "image/jpg") || ($tipo_img == "image/png")){
            $directorio = '../fotos_documentos/';
            move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio.$nombre_img);
            $objDocumento->setFoto($directorio.$nombre_img);
        }else{
            echo "Formato incorrecto";
        }
    } else {
        if($nombre_img == !NULL){
            echo "Imagen muy grande";
        }
    }
    
    
    if ($datosFormularioArray["txttipooperacion"] == "agregar") {
        $resultado = $objDocumento->agregar();
        if ($resultado == true) {
            Funciones::imprimeJSON(200, "Grabado con exito.", "");
        }
    } else {
        $objDocumento->setCodigo_documento($datosFormularioArray["txtcodigo"]);
        $resultado = $objDocumento->editar();
        if ($resultado == true) {
            Funciones::imprimeJSON(200, "Grabado con exito.", "");
        }
    }           
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
exit();

