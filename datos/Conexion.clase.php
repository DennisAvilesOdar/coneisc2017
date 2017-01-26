<?php

require_once 'configuracion.php';

class Conexion {
    
    protected $dblink;
    
    public function __construct() {
        $this->abrirConexion();
    }
    
    public function __destruct() {
        $this->dblink = NULL;
    }

    
    private function abrirConexion() {
        $cadenaConexion = "pgsql:host=".BD_SERVIDOR.";port=".BD_PUERTO.";dbname=".BD_BASE_DATOS;
        $usuario = BD_USUARIO;
        $clave = BD_CLAVE;
        
        try {
            $this->dblink = new PDO($cadenaConexion, $usuario, $clave);
            $this->dblink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
        
        return $this->dblink;
                    
    }
    
    
    
}
