<?php

require_once '../datos/Conexion.clase.php';

class Area extends Conexion {
    

    public function cargarArea(){
        try {
            $sql = "select * from area order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    
}
