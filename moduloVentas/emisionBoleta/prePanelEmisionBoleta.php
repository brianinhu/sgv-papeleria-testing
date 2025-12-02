<?php
require_once "../../compartido/mensajeVulnerabilidadSistema.php";
require_once "controllerEmisionBoleta.php";
require_once "panelEmisionBoleta.php";
$controller = new ControllerEmisionBoleta();
$mensajeSistema = new MensajeVulnerabilidadSistema();
$panelEmisionBoleta = new PanelEmisionBoleta();
session_start();

if ($controller -> validarSesion()) {
    if ($controller -> validarBoton("btnEmitirBoleta")) {
        $listaProforma = $controller->listarProformas();
        $panelEmisionBoleta -> mostrarPanelEmisionBoleta($listaProforma);
    } else {
        $mensajeSistema->mostrarMensaje("Error", "No se ha seleccionado la opción de emisión de boleta");
    }
} else {
    $mensajeSistema->mostrarMensaje("Error", "No se ha iniciado sesión");
}