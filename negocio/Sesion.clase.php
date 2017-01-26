<?php
require_once '../datos/Conexion.clase.php';
class Sesion extends Conexion{
    private $correo;
    private $clave;
    
    function getCorreo() {
        return $this->correo;
    }

    function getClave() {
        return $this->clave;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }


    public function validarSesion() {
        try {
            $sql = "select * from f_validar_sesion(:p_email, :p_correo);";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_correo", $this->getCorreo());
            $sentencia->bindParam(":p_clave", $this->getClave());
            $sentencia->execute();
            return $sentencia->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            throw $exc->getTraceAsString();
        }
    }
}
