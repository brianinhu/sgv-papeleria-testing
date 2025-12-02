<?php
require_once("conexion.php");

class Rol_privilegio extends Conexion
{
    public function obtenerPrivilegios($usuario) {
        $sql = "SELECT p.label, p.ruta, p.icono, p.name 
        FROM usuario u 
        JOIN rol r ON u.idrol = r.idrol
        JOIN rol_privilegio rp ON r.idrol = rp.idrol
        JOIN privilegio p ON rp.idprivilegio = p.idprivilegio
        WHERE u.usuario = '$usuario'";
        $resultado = $this->conectar()->query($sql);
        $privilegios = array();
        while ($fila = $resultado->fetch_assoc()) {
            $privilegios[] = $fila;
        }
        return $privilegios;
    }
}