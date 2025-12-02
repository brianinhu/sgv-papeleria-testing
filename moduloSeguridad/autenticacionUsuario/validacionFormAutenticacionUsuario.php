<?php
session_start();
require_once "../../compartido/mensajeVulnerabilidadSistema.php";
include_once("controllerAutenticacionUsuario.php");
$controller = new ControllerAutenticacionUsuario();
$mensaje = new MensajeVulnerabilidadSistema();
if ($controller->validarBoton("btnIngresar")) {
    $response = array();
    $txtUsuario = $_POST['txtUsuario'];
    $txtContraseña = $_POST['txtContraseña'];
    $txtRespuestaAntiRobot = $_POST['txtRespuestaAntiRobot'];
    if ($controller->validarTextoRespuestaAntiRobot($txtRespuestaAntiRobot)) {
        if ($controller->validarTextoUsuario($txtUsuario)) {
            if ($controller->validarUsuario($txtUsuario)) {
                if ($controller->validarTextoContraseña($txtContraseña)) {
                    if ($controller->validarContraseña($txtUsuario, $txtContraseña)) {
                        if ($controller->validarEstadoUsuario($txtUsuario)) {
                            $privilegios = $controller->obtenerPrivilegios($txtUsuario);
                            $rol = $controller->obtenerRol($txtUsuario);
                            $idusuario = $controller->obtenerIdUsuario($txtUsuario);
                            $_SESSION['usuario'] = $txtUsuario;
                            $_SESSION['rol'] = $rol;
                            $_SESSION['idusuario'] = $idusuario;
                            $_SESSION['privilegios'] = $privilegios;
                            $response['flag'] = 1;
                            $response['message'] = $controller->message;
                            $response['redirect'] = "./moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php";
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
    $mensaje->mostrarMensaje($controller->title, $controller->message);
    exit;
}
