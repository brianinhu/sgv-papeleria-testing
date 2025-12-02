<?php
require_once "controllerGestionUsuarios.php";
require_once "../../compartido/mensajeVulnerabilidadSistema.php";

$controller = new ControllerGestionUsuarios();
$mensaje = new MensajeVulnerabilidadSistema();

if ($controller->validarSesion()) {
    if ($controller->validarBoton("btnEliminarUsuario")) {
        $response = array();
        $idusuario = $_POST["idusuario"];
        $usuario = $controller -> obtenerUsuario($idusuario);
        $response['flag'] = 1;
        $response['usuario'] = $usuario;
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    } else {
        $mensaje->mostrarMensaje($controller->title, $controller->message);
    }

} else {
    $mensaje->mostrarMensaje($controller->title, $controller->message);
}