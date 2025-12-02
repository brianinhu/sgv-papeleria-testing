<?php
require_once "../../modelo/proforma.php";
class ControllerEmisionBoleta {
    public function validarSesion() {
        if (isset($_SESSION['usuario'])) {
            return true;
        } else {
            return false;
        }
    }

    public function validarBoton($boton) {
        if (isset($_POST[$boton])) {
            return true;
        } else {
            return false;
        }
    }

    public function listarProformas() {
        $proforma = new Proforma();
        return $proforma->listarProformas();
    }
}