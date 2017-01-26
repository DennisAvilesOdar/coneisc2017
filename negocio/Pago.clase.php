<?php

require_once '../datos/Conexion.clase.php';

class Pago extends Conexion {

    private $codigo_pago;
    private $descripcion;
    private $fecha_a_pagar;
    private $monto;
    private $codigo_usuario;
    private $estado;

    function getCodigo_pago() {
        return $this->codigo_pago;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getFecha_a_pagar() {
        return $this->fecha_a_pagar;
    }

    function getMonto() {
        return $this->monto;
    }

    function getCodigo_usuario() {
        return $this->codigo_usuario;
    }

    function getEstado() {
        return $this->estado;
    }

    function setCodigo_pago($codigo_pago) {
        $this->codigo_pago = $codigo_pago;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setFecha_a_pagar($fecha_a_pagar) {
        $this->fecha_a_pagar = $fecha_a_pagar;
    }

    function setMonto($monto) {
        $this->monto = $monto;
    }

    function setCodigo_usuario($codigo_usuario) {
        $this->codigo_usuario = $codigo_usuario;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function cargarDatos() { //lista o carga todos los usuarios
        try {
            $sql = "select * from pagos order by 1";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function listar($fecha1, $fecha2, $codigo_usuario, $estado, $tipo) { //listar por fecha y por usuario
        try {
            $sql = "select * from f_listar_pago(:p_fecha1,:p_fecha2, :p_codigo_usuario, :p_estado, :p_tipo)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_fecha1", $fecha1);
            $sentencia->bindParam(":p_fecha2", $fecha2);
            $sentencia->bindParam(":p_codigo_usuario", $codigo_usuario);
            $sentencia->bindParam(":p_estado", $estado);
            $sentencia->bindParam(":p_tipo", $tipo);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function agregar() {
        $this->dblink->beginTransaction();

        try {
            $sql = "select * from f_generar_correlativo('pagos') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();

            if ($sentencia->rowCount()) {
                $nuevoCodigoPago = $resultado["nc"];
                $this->setCodigo_pago($nuevoCodigoPago);

                $sql = "INSERT INTO pagos(  codigo_pago, 
                                            descripcion, 
                                            fecha_a_pagar, 
                                            monto, 
                                            codigo_usuario, 
                                            estado)
                                    VALUES (:p_codigo_pago, 
                                            :p_descripcion, 
                                            :p_fecha_a_pagar, 
                                            :p_monto, 
                                            :p_codigo_usuario, 
                                            :p_estado);
                    ";

                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);

                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_pago", $this->getCodigo_pago());
                $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
                $sentencia->bindParam(":p_fecha_a_pagar", $this->getFecha_a_pagar());
                $sentencia->bindParam(":p_monto", $this->getMonto());
                $sentencia->bindParam(":p_codigo_usuario", $this->getCodigo_usuario());
                $sentencia->bindParam(":p_estado", $this->getEstado());
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'pagos'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();

                $this->dblink->commit();

                return true; //significa que todo se ha ejecutado correctamente
            } else {
                throw new Exception("No se ha configurado el correlativo para la tabla pagos");
            }
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        return false;
    }

    public function anular($p_codigo_pago) {
        $this->dblink->beginTransaction();
        try {
            $sql = "update pagos SET estado = 'A' where codigo_pago = :p_codigo_pago";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_pago", $p_codigo_pago);
            $sentencia->execute();

            $this->dblink->commit();

            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }

        return false;
    }

    public function pagoPagado($p_codigo_pago) {
        $this->dblink->beginTransaction();
        try {
            $sql = "update pagos SET estado = '1' where codigo_pago = :p_codigo_pago";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_pago", $p_codigo_pago);
            $sentencia->execute();

            $this->dblink->commit();

            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }

        return false;
    }

    public function pagoPendiente($p_codigo_pago) {
        $this->dblink->beginTransaction();
        try {
            $sql = "update pagos SET estado = '2' where codigo_pago = :p_codigo_pago";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_pago", $p_codigo_pago);
            $sentencia->execute();

            $this->dblink->commit();

            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }

        return false;
    }

    public function leerDatos($p_codigo_pago) {
        try {
            $sql = "
                    select
                            *
                    from
                            pagos
                    where
                            codigo_pago = :p_codigo_pago
                ";

            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_pago", $p_codigo_pago);
            $sentencia->execute();

            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function editar() {
        $this->dblink->beginTransaction();

        try {
            $sql = " 
               UPDATE pagos SET 
                    descripcion=:p_descripcion, 
                    fecha_a_pagar=:p_fecha_a_pagar, 
                    monto=:p_monto, 
                    codigo_usuario=:p_codigo_usuario, 
                    estado=:p_estado
                WHERE 
                    codigo_pago= :p_codigo_pago;
               ";
            //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_codigo_pago", $this->getCodigo_pago());
            $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
            $sentencia->bindParam(":p_fecha_a_pagar", $this->getFecha_a_pagar());
            $sentencia->bindParam(":p_monto", $this->getMonto());
            $sentencia->bindParam(":p_codigo_usuario", $this->getCodigo_usuario());
            $sentencia->bindParam(":p_estado", $this->getEstado());
            //Ejecutar la sentencia preparada
            $sentencia->execute();
            $this->dblink->commit();
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        return false;
    }

}
