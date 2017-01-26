<?php

require_once '../datos/Conexion.clase.php';

class TipoDocumento extends Conexion {
    

    public function cargarTipoDocumento(){
        try {
            $sql = "select * from tipo_documento order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    
}
