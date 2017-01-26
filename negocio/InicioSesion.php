<?php

require_once '../datos/Conexion.clase.php';

class InicioSesion extends Conexion{
    private $correo;
    private $contrasena;
    
    function getCorreo() {
        return $this->correo;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function getContrasena() {
        return $this->contrasena;
    }

    function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    
    
    public function validarSesion(){
        try {
            $sql = "
                select 
                    *
                from 
                    usuario
                where
                    correo = :p_correo;
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_correo", $this->getCorreo());
            $sentencia->execute();
            
            if ($sentencia->rowCount()){
                $resultado = $sentencia->fetch();
                if ($resultado["contrasena"] == md5($this->getContrasena())){
                        session_name("sisconeii2017");
                        session_start();
                        
                        $_SESSION["s_nombres"] = $resultado["nombre"];
                        $_SESSION["s_codigo_usuario"] = $resultado["codigo_usuario"];
                        $_SESSION["s_correo"] = $this->getCorreo();
//                        $fotoUsuario = "../imagenes/" . $_SESSION["s_codigo_usuario"] . ".png";
//                        
//                        if (file_exists($fotoUsuario)){
//                            $_SESSION["s_foto_usuario"] = $fotoUsuario;
//                            
//                        }else{
//                            $fotoUsuario = "../imagenes/sin-foto.png";
//                            $_SESSION["s_foto_usuario"] = $fotoUsuario;
//                        }
                        
                        return 1; //El usuario puede ingresal al sistema
                }else{
                    return 2; //La clave no es igual a la que esta en la BD
                }
            }else{
                return 3; //El usuario no existe
            }
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
}
