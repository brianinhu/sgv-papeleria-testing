<?php
session_start();
require_once("controllerRestablecimientoContraseña.php");
$controller = new ControllerRestablecimientoContraseña();
if ($controller->validarBoton("btnAceptar")) {
    $response = array();
    $usuario = $_SESSION['usuario'];
    $txtNuevaContraseña = $_POST['txtNuevaContraseña'];
    $txtNuevaContraseñaRep = $_POST['txtNuevaContraseñaRep'];
    if ($controller->validarTextoNuevaContraseña($txtNuevaContraseña)) {
        if ($controller->validarTextoIgualdadContraseñas($txtNuevaContraseña, $txtNuevaContraseñaRep)) {
            $controller->restablecerContraseña($usuario, $txtNuevaContraseña);
            $response['flag'] = 1;
            $response['message'] = $controller->message;
            $response['redirect'] = "../../index.php";
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
    include_once("../../compartido/mensajeSistema.php");
    $modal = new MensajeVulnerabilidadSistema();
    $modal->mostrarMensaje("Acceso denegado", "Se identificó un intento de vulnerabilidad del sistema.");
    exit;
}
