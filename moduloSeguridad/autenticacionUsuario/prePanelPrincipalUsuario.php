<?php
require_once("../../compartido/mensajeVulnerabilidadSistema.php");
require_once("../panelPrincipalUsuario.php");
$mensajeSistema = new MensajeVulnerabilidadSistema();
$panel = new PanelPrincipalUsuario();
session_start();

function validarSesion()
{
    if (!isset($_SESSION["usuario"])) {
        return false;
    } else {
        return true;
    }
}

if (validarSesion()) {
    $panel->mostrarPanel();
} else {
    $mensajeSistema->mostrarMensaje("Acceso denegado", "Se identificó un intento de vulnerabilidad del sistema. Acceso denegado.");
}
