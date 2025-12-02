<?php
require_once "controllerGestionUsuarios.php";
require_once "../../compartido/mensajeVulnerabilidadSistema.php";
require_once "panelGestionUsuarios.php";
$controller = new ControllerGestionUsuarios();
$mensajeSistema = new MensajeVulnerabilidadSistema();
$objPanelGestionUsuarios = new PanelGestionUsuarios();
if ($controller->validarSesion()) {
    if ($controller->validarBoton("btnGestionUsuarios")) {
        $usuarios = $controller->obtenerUsuarios();
        $objPanelGestionUsuarios->mostrarPanel($usuarios);
        exit;
    } else {
        $mensajeSistema->mostrarMensaje($controller->title, $controller->message);
        exit;
    }
} else {
    $mensajeSistema->mostrarMensaje($controller->title, $controller->message);
    exit;
}
