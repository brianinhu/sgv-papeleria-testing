<?php
require_once "controllerGestionUsuarios.php";
require_once "../../compartido/mensajeVulnerabilidadSistema.php";
require_once "formAgregarUsuario.php";
require_once "formEditarUsuario.php";
$controller = new ControllerGestionUsuarios();
$mensajeSistema = new MensajeVulnerabilidadSistema();
$formAgregarUsuario = new FormAgregarUsuario();
$formEditarUsuario = new FormEditarUsuario();
if ($controller->validarSesion()) {
    if ($controller->validarBoton("btnAgregarUsuario")) {
        $formAgregarUsuario->mostrarFormulario();
        exit;
    } else if ($controller->validarBoton("btnEditarUsuario")) {
        $idusuario = $_POST["idusuario"];
        $usuario = $controller->obtenerUsuario($idusuario);
        $formEditarUsuario->mostrarFormulario($usuario);
        exit;
    } else if ($controller->validarBoton("btnEliminarUsuario")) {
        $idusuario = $_POST["idusuario"];
        $controller->eliminarUsuario($idusuario);
        header("Location: validacionPostAccionesUsuario.php");
        exit;
    } else {
        $mensajeSistema->mostrarMensaje($controller->title, $controller->message);
        exit;
    }
} else {
    $mensajeSistema->mostrarMensaje($controller->title, $controller->message);
    exit;
}
