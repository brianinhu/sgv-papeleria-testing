<?php
require_once("controllerRestablecimientoContraseña.php");
$controller = new ControllerRestablecimientoContraseña();
if ($controller->validarBoton("btnAceptar")) {
    $response = array();
    $usuario = $_POST['txtUsuario'];
    if ($controller->validarTextoUsuario($usuario)) {
        if ($controller->validarUsuario($usuario)) {
            session_start();
            $_SESSION['usuario'] = $usuario;
            $_SESSION['pregunta'] = $controller->obtenerPreguntaSeguridad($usuario);
            $response['message'] = "Usuario autenticado";
            $response['flag'] = 1;
            $response['redirect'] = "formPreguntaSeguridad.php";
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response['flag'] = 0;
            $response['message'] = $controller->message;
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    } else {
        $response['flag'] = 0;
        $response['message'] = $controller->message;
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
} else {
    include_once("../../compartido/mensajeVulnerabilidadSistema.php");
    $modal = new MensajeVulnerabilidadSistema();
    $modal->mostrarMensaje("Acceso denegado", "Se identificó un intento de vulnerabilidad del sistema.");
    exit;
}
