<?php
require_once "controllerGestionUsuarios.php";
require_once "../../compartido/mensajeVulnerabilidadSistema.php";
require_once "../../modelo/usuario.php";
$controller = new ControllerGestionUsuarios();
$mensaje = new MensajeVulnerabilidadSistema();
$usuario = new Usuario();

if ($controller->validarSesion()) {
    if ($controller->validarBoton("btnEditGuardarCambios")) {
        $idusuario = $_POST["idusuario"];
        $txtEditNuevaContraseña = $_POST['txtEditNuevaContraseña'];
        $txtEditConfNuevaContraseña = $_POST['txtEditConfNuevaContraseña'];
        $txtEditUsuario = $_POST['txtEditUsuario'];
        $cbxEditRol = $_POST['cbxEditRol'];
        $cbxEditEstado = $_POST['cbxEditEstado'];
        $idpregunta = $_POST['idpregunta'];
        $cbxEditPreguntaSeguridad = $_POST['cbxEditPreguntaSeguridad'];
        $txtEditRespuestaSecreta = $_POST['txtEditRespuestaSecreta'];
        $response = array();

        if ($controller->validarVacioTxtEditContraseña($txtEditNuevaContraseña)) { // validar si txteditnuevacontraseña esta vacio
            if ($controller->validarTextoUsuario($txtEditUsuario)) {
                if ($controller->validarSeleccionCbxEditPreguntaSeguridad($cbxEditPreguntaSeguridad, $idpregunta)) { //validar si se quiere cambiar la respuesta secreta
                    if ($controller->validarTextoRespuestaSecreta($txtEditRespuestaSecreta)) {
                        // editar usuario sin cambiar la contraseña pero si la respuesta secreta.
                        if ($controller->editarUsuarioMenosContraseña($idusuario, $txtEditUsuario, $cbxEditRol, $cbxEditEstado, $cbxEditPreguntaSeguridad, $txtEditRespuestaSecreta)) {
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
                    // No cambiar la contraseña ni la respuesta secreta.
                    if ($controller->editarUsuarioMenosContraseñaMenosPreguntaSeguridad($idusuario, $txtEditUsuario, $cbxEditRol, $cbxEditEstado)) {
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
            if ($controller->validarTextoContraseña($txtEditNuevaContraseña)) {
                if ($controller->validarTextoIgualdadContraseñayConfContraseña($txtEditNuevaContraseña, $txtEditConfNuevaContraseña)) {
                    if ($controller->validarTextoUsuario($txtEditUsuario)) {
                        if ($controller->validarSeleccionCbxEditPreguntaSeguridad($cbxEditPreguntaSeguridad, $idpregunta)) { // validar si se quiere cambiar la respuesta secreta
                            if ($controller->validarTextoRespuestaSecreta($txtEditRespuestaSecreta)) {
                                // editar usuario cambiando la contraseña y la respuesta secreta.
                                if ($controller->editarUsuario($idusuario, $txtEditNuevaContraseña, $txtEditUsuario, $cbxEditRol, $cbxEditEstado, $cbxEditPreguntaSeguridad, $txtEditRespuestaSecreta)) {
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
                            // cambiar la contraseña pero no la respuesta secreta.
                            if ($controller->editarUsuarioMenosPreguntaSeguridad($idusuario, $txtEditNuevaContraseña, $txtEditUsuario, $cbxEditRol, $cbxEditEstado)) {
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
        }
    } else {
        $mensaje->mostrarMensaje($controller->title, $controller->message);
        exit;
    }
} else {
    $mensaje->mostrarMensaje($controller->title, $controller->message);
    exit;
}
