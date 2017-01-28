<?php

require_once '../datos/Conexion.clase.php';

class Documento extends Conexion {

    private $codigo_documento;
    private $numero_documento;
    private $descripcion;
    private $monto;
    private $foto;
    private $codigo_usuario;
    private $codigo_tipo_documento;
    private $estado;

    function getCodigo_tipo_documento() {
        return $this->codigo_tipo_documento;
    }

    function getEstado() {
        return $this->estado;
    }

    function setCodigo_tipo_documento($codigo_tipo_documento) {
        $this->codigo_tipo_documento = $codigo_tipo_documento;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function getCodigo_documento() {
        return $this->codigo_documento;
    }

    function getNumero_documento() {
        return $this->numero_documento;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getMonto() {
        return $this->monto;
    }

    function getFoto() {
        return $this->foto;
    }

    function getCodigo_usuario() {
        return $this->codigo_usuario;
    }

    function setCodigo_documento($codigo_documento) {
        $this->codigo_documento = $codigo_documento;
    }

    function setNumero_documento($numero_documento) {
        $this->numero_documento = $numero_documento;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setMonto($monto) {
        $this->monto = $monto;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setCodigo_usuario($codigo_usuario) {
        $this->codigo_usuario = $codigo_usuario;
    }

    public function cargarDatos() { //lista o carga todos los documentos
        try {
            $sql = "select d.codigo_tipo_documento, td.descripcion, d.codigo_documento, d.numero_documento, d.descripcion, d.monto, d.fecha_y_hora, d.foto, (case  when estado='E' then 'Emitido' else 'Anulado' end)::varchar as estado, d.codigo_usuario, u.nombre from documento d inner join usuario u on(d.codigo_usuario = u.codigo_usuario) inner join tipo_documento td on(d.codigo_tipo_documento = td.codigo_tipo_documento) order by 2;";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function listar($fecha1, $fecha2, $codigo_usuario, $estado, $_codigo_td) { //filtra por usuario y codigo del tipo de documento
        try {
            $sql = "select * from f_lista_documento(:p_fecha1, :p_fecha2, :p_codigo_usuario, :p_estado, :p_codigo_td);";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_fecha1", $fecha1);
            $sentencia->bindParam(":p_fecha2", $fecha2);
            $sentencia->bindParam(":p_codigo_usuario", $codigo_usuario);
            $sentencia->bindParam(":p_estado", $estado);
            $sentencia->bindParam(":p_codigo_td", $_codigo_td);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function listarRel($fecha1, $fecha2, $_codigo_td) { 
        try {
            $sql = "select * from f_lista_documento_rel(:p_fecha1, :p_fecha2, :p_codigo_td);";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_fecha1", $fecha1);
            $sentencia->bindParam(":p_fecha2", $fecha2);
            $sentencia->bindParam(":p_codigo_td", $_codigo_td);
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
            $sql = "select * from f_generar_correlativo('documento') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();

            if ($sentencia->rowCount()) {
                $nuevoCodigoDocumento = $resultado["nc"];
                $this->setCodigo_documento($nuevoCodigoDocumento);
                $sql = "INSERT INTO documento(codigo_documento, numero_documento, descripcion, monto, fecha_y_hora, foto, estado, codigo_usuario, codigo_tipo_documento)
                                      VALUES (:p_codigo_documento, :p_numero_documento, :p_descripcion, :p_monto, :p_fecha, :p_foto,'E', :p_codigo_usuario, :p_codigo_td);";

                $sentencia = $this->dblink->prepare($sql);

                $sentencia->bindParam(":p_codigo_documento", $this->getCodigo_documento());
                $sentencia->bindParam(":p_numero_documento", $this->getNumero_documento());
                $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
                $sentencia->bindParam(":p_monto", $this->getMonto());
                $sentencia->bindParam(":p_fecha", date("Y-m-d"));
                $sentencia->bindParam(":p_foto", array(bin2hex(file_get_contents($this->getFoto()))));
                $sentencia->bindParam(":p_codigo_usuario", $this->getCodigo_usuario());
                $sentencia->bindParam(":p_codigo_td", $this->getCodigo_tipo_documento());
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'documento'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();

                $this->dblink->commit();
                return true; //significa que todo se ha ejecutado correctamente
            } else {
                throw new Exception("No se ha configurado el correlativo para la tabla documento");
            }
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        return false;
    }

    public function anular($p_codigo_documento) {
        $this->dblink->beginTransaction();
        try {
            $sql = " 
               UPDATE documento
                                SET estado = 'A'
                              WHERE codigo_documento=:p_codigo_documento;
               ";


            //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_codigo_documento", $p_codigo_documento);
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

    public function leerDatos($p_codigo_documento) {
        try {
            $sql = "
                    select
                            d.*,
                            td.descripcion as descripcion_tipo_documento
                    from
                            documento d
                            inner join tipo_documento td on ( d.codigo_tipo_documento = td.codigo_tipo_documento)
                    where
                            d.codigo_documento = :p_codigo_documento
                ";

            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_documento", $p_codigo_documento);
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
               UPDATE documento SET 
                    numero_documento=:p_numero_documento, 
                    descripcion=:p_descripcion, 
                    monto=:p_monto, 
                    codigo_usuario=:p_codigo_usuario, 
                    codigo_tipo_documento=:p_codigo_td
                WHERE codigo_documento=:p_codigo_documento;
               ";
            //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_codigo_documento", $this->getCodigo_documento());
            $sentencia->bindParam(":p_numero_documento", $this->getNumero_documento());
            $sentencia->bindParam(":p_descripcion", $this->getDescripcion());
            $sentencia->bindParam(":p_monto", $this->getMonto());
            $sentencia->bindParam(":p_codigo_usuario", $this->getCodigo_usuario());
            $sentencia->bindParam(":p_codigo_td", $this->getCodigo_tipo_documento());
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
