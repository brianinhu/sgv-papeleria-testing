<?php
require_once "controllerGestionUsuarios.php";
require_once "../../compartido/mensajeVulnerabilidadSistema.php";
$controller = new ControllerGestionUsuarios();
$mensaje = new MensajeVulnerabilidadSistema();

if ($controller->validarSesion()) {
    if ($controller->validarBoton("btnCreateAgregar")) {
        $txtNombre = $_POST['txtNombre'];
        $txtAPaterno = $_POST['txtAPaterno'];
        $txtAMaterno = $_POST['txtAMaterno'];
        $txtDNI = $_POST['txtDNI'];
        $txtEditNuevaContraseña = $_POST['txtContraseña'];
        $txtEditConfNuevaContraseña = $_POST['txtConfContraseña'];
        $txtUsuario = $_POST['txtUsuario'];
        $cbxRol = $_POST['cbxRol'];
        $cbxEstado = $_POST['cbxEstado'];
        $cbxPreguntaSeguridad = $_POST['cbxPreguntaSeguridad'];
        $txtRespuestaSecreta = $_POST['txtRespuestaSecreta'];
        $response = array();
        if ($controller->validarTextoNombreApellidos($txtNombre, $txtAPaterno, $txtAMaterno)) {
            if ($controller->validarTextoDNI($txtDNI)) {
                if ($controller->validarDNI($txtDNI)) {
                    if ($controller->validarTextoContraseña($txtEditNuevaContraseña)) {
                        if ($controller->validarTextoIgualdadContraseñayConfContraseña($txtEditNuevaContraseña, $txtEditConfNuevaContraseña)) {
                            if ($controller->validarTextoUsuario($txtUsuario)) {
                                if ($controller->validarUsuario($txtUsuario)) {
                                    if ($controller->validarSeleccionRol($cbxRol)) {
                                        if ($controller->validarSeleccionEstado($cbxEstado)) {
                                            if ($controller->validarSeleccionPreguntaSeguridad($cbxPreguntaSeguridad)) {
                                                if ($controller->validarTextoRespuestaSecreta($txtRespuestaSecreta)) {
                                                    if ($controller->agregarUsuario($txtNombre, $txtAPaterno, $txtAMaterno, $txtDNI, $txtEditNuevaContraseña, $txtUsuario, $cbxRol, $cbxEstado, $cbxPreguntaSeguridad, $txtRespuestaSecreta)) {
                                                        $response['flag'] = 1;
                                                        $response['title'] = $controller->title;
                                                        $response['message'] = $controller->message;
                                                        $response['redirect'] = "validacionPostAccionesUsuario.php";
                                                        header('Content-Type: application/json');
                                                        echo json_encode($response);
                                                    } else {
                                                        $response['flag'] = 0;
                                                        $response['title'] = $controller->title;
                                                        $response['message'] = $controller->message;
                                                        header('Content-Type: application/json');
                                                        echo json_encode($response);
                                                        exit;
                                                    }
                                                } else {
                                                    $response['flag'] = 0;
                                                    $response['title'] = $controller->title;
                                                    $response['message'] = $controller->message;
                                                    header('Content-Type: application/json');
                                                    echo json_encode($response);
                                                    exit;
                                                }
                                            } else {
                                                $response['flag'] = 0;
                                                $response['title'] = $controller->title;
                                                $response['message'] = $controller->message;
                                                header('Content-Type: application/json');
                                                echo json_encode($response);
                                                exit;
                                            }
                                        } else {
                                            $response['flag'] = 0;
                                            $response['title'] = $controller->title;
                                            $response['message'] = $controller->message;
                                            header('Content-Type: application/json');
                                            echo json_encode($response);
                                            exit;
                                        }
                                    } else {
                                        $response['flag'] = 0;
                                        $response['title'] = $controller->title;
                                        $response['message'] = $controller->message;
                                        header('Content-Type: application/json');
                                        echo json_encode($response);
                                        exit;
                                    }
                                } else {
                                    $response['flag'] = 0;
                                    $response['title'] = $controller->title;
                                    $response['message'] = $controller->message;
                                    header('Content-Type: application/json');
                                    echo json_encode($response);
                                    exit;
                                }
                            } else {
                                $response['flag'] = 0;
                                $response['title'] = $controller->title;
                                $response['message'] = $controller->message;
                                header('Content-Type: application/json');
                                echo json_encode($response);
                                exit;
                            }
                        } else {
                            $response['flag'] = 0;
                            $response['title'] = $controller->title;
                            $response['message'] = $controller->message;
                            header('Content-Type: application/json');
                            echo json_encode($response);
                            exit;
                        }
                    } else {
                        $response['flag'] = 0;
                        $response['title'] = $controller->title;
                        $response['message'] = $controller->message;
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response['flag'] = 0;
                    $response['title'] = $controller->title;
                    $response['message'] = $controller->message;
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                }
            } else {
                // json
                $response['flag'] = 0;
                $response['title'] = $controller->title;
                $response['message'] = $controller->message;
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
        } else {
            // response para json
            $response['flag'] = 0;
            $response['title'] = $controller->title;
            $response['message'] = $controller->message;
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    } else {
        $mensaje->mostrarMensaje($controller->title, $controller->message);
    }
} else {
    $mensaje->mostrarMensaje($controller->title, $controller->message);
}
