<?php
require_once("conexion.php");

class detalle_proforma extends conexion
{
    public function registrarDetalleProforma($idProforma, $idProducto, $cantidad, $subtotal)
    {
        $sql = "INSERT INTO detalle_proforma (idproforma, idproducto, cantidad, subtotal) VALUES ('$idProforma', '$idProducto', '$cantidad', '$subtotal')";
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