<?php

require_once '../datos/Conexion.clase.php';

class DetalleDocumentoPago extends Conexion {

    private $codigo_pago;
    private $codigo_documento;

    function getCodigo_pago() {
        return $this->codigo_pago;
    }

    function getCodigo_documento() {
        return $this->codigo_documento;
    }

    function setCodigo_pago($codigo_pago) {
        $this->codigo_pago = $codigo_pago;
    }

    function setCodigo_documento($codigo_documento) {
        $this->codigo_documento = $codigo_documento;
    }

    public function cargarDatos() { //lista o carga todos los usuarios
        try {
            $sql = "select * from detalle_documento_pago order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function listar($fecha1, $fecha2, $codigo_usuario, $estado) { //listar por fecha, por usuario y estado de pago.
        try {
            $sql = "select * from f_listar_detalle_documento_pago(:p_fecha1,:p_fecha2, :p_codigo_usuario, :p_estado)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_fecha1", $fecha1);
            $sentencia->bindParam(":p_fecha2", $fecha2);
            $sentencia->bindParam(":p_codigo_usuario", $codigo_usuario);
            $sentencia->bindParam(":p_estado", $estado);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    private function validarDocumento($codDoc) {
        $sql = "select estado from documento where codigo_documento = p_codigo_documento ";
        $sentencia = $this->dblink->prepare($sql);
        $sentencia->bindParam(":p_codigo_documento", $codDoc);
        $sentencia->execute();
        $resultado = $sentencia->fetch();
        if ($sentencia->rowCount()) {
            $estado = $resultado["estado"];
            if (strcasecmp($estado, 'E') == 0) {//si el estado es Emitido
                return 1;
            } else {
                throw new Exception("No se puede agregar un documento que está anulado");
            }
        } else {
            throw new Exception("No existe el documento con código " . $codDoc . " registrado");
        }
    }

    private function validarPago() {
        $sql = "select estado from pagos where codigo_pago = :p_codigo_pago ";
        $sentencia = $this->dblink->prepare($sql);
        $sentencia->bindParam(":p_codigo_pago", $this->getCodigo_pago());
        $sentencia->execute();
        $resultado = $sentencia->fetch();
        if ($sentencia->rowCount()) {
            $estado = $resultado["estado"];
            if (strcasecmp($estado, '3') != 0) {//si el estado es diferente a anulado
                return 1;
            } else {
                throw new Exception("No se puede agregar un pago que está anulado");
            }
        } else {
            throw new Exception("No existe el pago con código " . $this->getCodigo_pago() . " registrado");
        }
    }

    public function agregar() {
        $this->dblink->beginTransaction();
        try {

            if ($this->validarPago() == 1) {
                $relacionArray = json_decode($this->getCodigo_documento());
                foreach ($relacionArray as $key => $value) {
                    $cod_doc = $value->coddoc;
                    $sql = "INSERT INTO detalle_documento_pago(codigo_documento, codigo_pago) VALUES (:p_codigo_documento, :p_codigo_pago);";
                    $sentencia = $this->dblink->prepare($sql);

                    $sentencia->bindParam(":p_codigo_pago", $this->getCodigo_pago());
                    $sentencia->bindParam(":p_codigo_documento", $cod_doc);

                    $sentencia->execute();
                }

                $this->dblink->commit();
                return true;
            } else {
                throw new Exception("El numero de pago no existe.");
            }
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        return false;
    }

    public function eliminar($p_codigo_pago, $p_codigo_documento) {
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from detalle_documento_pago where codigo_pago = :p_codigo_pago and codigo_documento = p_codigo_documento ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_pago", $p_codigo_pago);
            $sentencia->bindParam(":p_codigo_documento", $p_codigo_documento);
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
