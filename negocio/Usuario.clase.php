<?php

require_once '../datos/Conexion.clase.php';
class Usuario extends Conexion{
    private $codigo_usuario;
    private $nombre;
    private $correo;
    private $contrasena;
    private $codigo_area;
    
    
    function getCodigo_usuario() {
        return $this->codigo_usuario;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getContrasena() {
        return $this->contrasena;
    }

    function getCodigo_area() {
        return $this->codigo_area;
    }

    function setCodigo_usuario($codigo_usuario) {
        $this->codigo_usuario = $codigo_usuario;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    function setCodigo_area($codigo_area) {
        $this->codigo_area = $codigo_area;
    }

    public function listar() { //lista o carga todos los usuarios
        try {
            $sql = "select * from usuario order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    public function listarUsuarioArea( $p_codigo_area) { //filtra con áreas
        try {
            $sql = "select * from f_lista_usuario(:p_codigo_area );";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_area", $p_codigo_area);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
   
    public function eliminar( $p_codigo_usuario){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from usuario where codigo_usuario = :p_codigo_usuario";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_usuario", $p_codigo_usuario);
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return false;
    }
    
    public function leerDatos($p_codigo_usuario) {
        try {
            $sql = "
                    select
                            u.*,
                            a.descripcion
                    from
                            usuario u 
                            inner join area a on ( u.codigo_area = a.codigo)
                    where
                            u.codigo_usuario = :p_codigo_usuario
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_usuario", $p_codigo_usuario);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    
    
    
}
