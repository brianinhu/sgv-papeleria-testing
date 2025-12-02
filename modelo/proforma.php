<?php
require_once("conexion.php");
class proforma extends conexion
{
    public function insertarProforma($idUsuario, $fecha, $hora, $totalProforma)
    {
        $sql = "INSERT INTO proforma (idusuario, fechaEmision, horaEmision, estado, importe) VALUES ('$idUsuario', '$fecha', '$hora', 'Pendiente', '$totalProforma')";
        $conexion = $this->conectar();
        
        if ($conexion->query($sql) === TRUE) {
            $idProforma = $conexion->insert_id;
            $this->desconectar();
            return $idProforma;
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
            $this->desconectar();
            return false;
        }
    }

    public function listarProformas()
    {
        $sql = "SELECT * FROM proforma";
        $conexion = $this->conectar();
        $resultado = $conexion->query($sql);
        $this->desconectar();
        return $resultado;
    }
}