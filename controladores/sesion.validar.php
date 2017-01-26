<?php

require_once '../negocio/InicioSesion.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["txtusuario"]) || ! isset($_POST["txtclave"]) || ! isset($_POST["dirURL"])){
    Funciones::imprimeJSON(500, "Falta completar los datos requeridos", "");
    exit();
}


$correo = $_POST["txtusuario"];
$contrasena = $_POST["txtclave"];
$URL = $_POST["dirURL"];
try {
    $objSesion = new InicioSesion();
    $objSesion->setCorreo($correo);
    $objSesion->setContrasena($contrasena);
    $resultado = $objSesion->validarSesion();
    
    print_r($resultado);
    
    switch ($resultado){
        case 1:  // Clave correcta
//            Funciones::imprimeJSON(200, "Inicio de sesión satisfactorio", "");
            header("location:".$URL."principal.vista.php");
//            http://localhost/Coneii/vista/index.php/../
            break;
        
        case 2:  // Clave incorrecta
            Funciones::imprimeJSON(500, "Clave incorrecta", "");
            break;
        
        case 3: // Usuario NO Existe
            Funciones::imprimeJSON(500, "El usuario no existe", "");
            break;
        
        default:
            Funciones::imprimeJSON(500, "Error", "");
            break;
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, "Este es un error del web ervice...  ".$exc->getMessage(), "");
}