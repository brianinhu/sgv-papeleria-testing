<?php
require_once "controllerEmisionBoleta.php";
require_once "../../compartido/mensajeVulnerabilidadSistema.php";
require_once "panelEmisionBoleta.php";
$controller = new ControllerEmisionBoleta();
$mensajeSistema = new MensajeVulnerabilidadSistema();
$objPanelEmisionBoleta = new PanelEmisionBoleta();


session_start();
if ($controller->validarSesion()) {
    $lista = $controller->listarProformas();
    $objPanelEmisionBoleta->mostrarPanelEmisionBoleta($lista);
} else {
    $mensajeSistema->mostrarMensaje("Error", "No se ha iniciado sesión");
    exit;
}

$btnEmitirBoleta = $_POST['btnEmitirBoleta'] ?? null;

if ($btnEmitirBoleta) {
    $idusuario = $_POST['idusuario'] ?? null;
    if ($idusuario) {
        $resultado = $controller->emitirBoleta($idusuario);
        if ($resultado) {
            $mensajeSistema->mostrarMensaje("Éxito", "Boleta emitida correctamente");
        } else {
            $mensajeSistema->mostrarMensaje("Error", "No se pudo emitir la boleta");
        }
    } else {
        $mensajeSistema->mostrarMensaje("Error", "ID de usuario no proporcionado");
    }
}