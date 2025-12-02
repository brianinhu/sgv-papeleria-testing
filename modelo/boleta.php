<?php
require_once("conexion.php");

class boleta extends Conexion
{
    public function listarBoletas()
    {
        $sql = "SELECT * FROM boleta WHERE Estado = 'Pendiente';";
        $resultado = $this->conectar()->query($sql);
        $filas = $resultado->num_rows;
        $this->desconectar();
        if ($filas == 0)
            return NULL;
        else {
            for ($i = 0; $i < $filas; $i++)
                $respuesta[$i] = mysqli_fetch_array($resultado);
            return $respuesta;
        }
    }

    public function listarBoletasBusqueda($idboleta)
    {
        $sql = "SELECT * FROM boleta WHERE Estado = 'Pendiente' AND IDBoleta = '$idboleta';";
        $resultado = $this->conectar()->query($sql);
        $filas = $resultado->num_rows;
        $this->desconectar();
        if ($filas == 0)
            return NULL;
        else {
            for ($i = 0; $i < $filas; $i++)
                $respuesta[$i] = mysqli_fetch_array($resultado);
            return $respuesta;
        }
    }

    public function actualizarBoleta($idboleta)
    {
        $sql = "UPDATE boleta SET Estado = 'Despachada' WHERE IDBoleta = '$idboleta'";
        $conexion = $this->conectar();

        if ($conexion->query($sql) === TRUE) {
            $this->desconectar();
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
            $this->desconectar();
            return false;
        }
    }

    public function emitirBoleta($fecha, $hora, $idusuario, $importe_total)
    { {
            $sql = "INSERT INTO boleta (FechaEmision, HoraEmision, Estado, idusuario, importe_total) VALUES ('$fecha', '$hora', 'Emitida', '$idusuario', '$importe_total')";
            $conexion = $this->conectar();
            if ($conexion->query($sql) === TRUE) {
                $this->desconectar();
                return true;
            } else {
                echo "Error: " . $sql . "<br>" . $conexion->error;
                $this->desconectar();
                return false;
            }
        }
    }
}
