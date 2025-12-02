<?php
require_once("conexion.php");

class detalle_boleta extends conexion
{
    public function obtenerDetalleBoleta($idBoleta)
    {
        $sql = "SELECT b.IDBoleta, p.idproducto, p.producto, d.cantidad, d.Importe, d.IGV, b.importe_total
                FROM detalle_boleta d, producto p, boleta b WHERE d.IDBoleta = '$idBoleta' AND 
                p.idproducto = d.idproducto AND d.IDBoleta = b.IDBoleta;";
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

}