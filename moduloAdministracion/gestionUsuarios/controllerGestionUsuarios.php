<?php
session_start();
require_once("../../modelo/usuario.php");
class ControllerGestionUsuarios
{
    public $title = "";
    public $message = "";
    public function validarSesion() {
        if (!isset($_SESSION['usuario'])) {
            $this->title = "Error";
            $this->message = "Usuario no autenticado. Acceso denegado.";
            return false;
        }
        return true;
    }

    public function validarBoton($boton) {
        if (!isset($_POST[$boton])) {
            $this->title = "Error";
            $this->message = "Se identificó un intento de vulnerabilidad del sistema. Acceso denegado.";
            return false;
        }
        return true;
    }

    public function obtenerUsuarios()
    {
        $objUsuario = new Usuario();
        return $objUsuario->obtenerUsuarios();
    }

    public function obtenerUsuario($idusuario)
    {
        $objUsuario = new Usuario();
        return $objUsuario->obtenerUsuario($idusuario);
    }

    public function validarTextoNombreApellidos($txtNombre, $txtAPaterno, $txtAMaterno) {
        if (empty($txtNombre) || empty($txtAPaterno) || empty($txtAMaterno)) {
            $this->title = "Error";
            $this->message = "Por favor, complete los campos de nombre, apellido paterno y apellido materno.";
            return false;
        } else if (!preg_match("/^[a-zA-Z ]*$/", $txtNombre) || !preg_match("/^[a-zA-Z ]*$/", $txtAPaterno) || !preg_match("/^[a-zA-Z ]*$/", $txtAMaterno)) {
            $this->title = "Error";
            $this->message = "Por favor, digite solo caracteres alfabéticos para el nombre, apellido paterno y apellido materno.";
            return false;
        }
        return true;
    }

    public function validarTextoDNI($DNI) {
        if (empty($DNI)) {
            $this->title = "Error";
            $this->message = "Por favor, complete el campo de DNI.";
            return false;
        } else if (!preg_match("/^[0-9]*$/", $DNI)) {
            $this->title = "Error";
            $this->message = "Por favor, digite solo números para el DNI.";
            return false;
        } else if (strlen($DNI) != 8) {
            $this->title = "Error";
            $this->message = "El DNI debe tener 8 caracteres.";
            return false;
        }
        return true;
    }

    public function validarDNI($DNI) {
        $objUsuario = new Usuario();
        if ($objUsuario->validarDNI($DNI)) {
            $this->title = "Error";
            $this->message = "Ya existe un usuario con el DNI ";
            return false;
        }
        return true;
    }

    //validar que la contraseña no este vacia, que tenga al menos 8 caracteres, que tenga al menos un caracter alfanumerico y un caracter especial
    public function validarTextoContraseña($contraseña) {
        if (empty($contraseña)) {
            $this->title = "Error";
            $this->message = "Por favor, complete el campo de contraseña.";
            return false;
        } else if (strlen($contraseña) < 8) {
            $this->title = "Error";
            $this->message = "Por favor, cree una contraseña mayor o igual a 8 caracteres";
            return false;
        } else if (!preg_match("/[a-zA-Z0-9]+/", $contraseña) || !preg_match("/[!@#$%^&*()]+/", $contraseña)) {
            $this->title = "Error";
            $this->message = "La contraseña debe contener al menos 1 caracter alfabético, 1 caracter numérico y 1 caracter especial";
            return false;
        }
        return true;
    }

    public function validarTextoIgualdadContraseñayConfContraseña($contraseña, $confContraseña) {
        if ($contraseña != $confContraseña) {
            $this->title = "Error";
            $this->message = "Las contraseñas no coindicen. Verifique e intente nuevamente.";
            return false;
        }
        return true;
    }

    // verificar que el campo usuario no este vacio, que tenga al menos 5 caracteres y que contenga solo caracteres alfanumericos
    public function validarTextoUsuario($usuario) {
        if (empty($usuario)) {
            $this->title = "Error";
            $this->message = "Por favor, complete el campo de usuario.";
            return false;
        } else if (strlen($usuario) < 5) {
            $this->title = "Error";
            $this->message = "Por favor, cree un usuario mayor o igual a 5 caracteres";
            return false;
        } else if (!preg_match("/^[a-zA-Z0-9]*$/", $usuario)) {
            $this->title = "Error";
            $this->message = "El usuario solo puede contener caracteres alfabéticos y numéricos.";
            return false;
        }
        return true;
    }

    public function validarUsuario($usuario) {
        $objUsuario = new Usuario();
        if ($objUsuario->validarUsuario($usuario)) {
            $this->title = "Error";
            $this->message = "El usuario ya se encuentra registrado en el sistema. Por favor, cree otro usuario.";
            return false;
        }
        return true;
    }

    public function validarSeleccionRol($rol) {
        if ($rol == 0) {
            $this->title = "Error";
            $this->message = "Por favor, seleccione un rol para el usuario.";
            return false;
        }
        return true;
    }

    public function validarSeleccionEstado($estado) {
        if ($estado == -1) {
            $this->title = "Error";
            $this->message = "Por favor, seleccione un estado para el usuario.";
            return false;
        }
        return true;
    }

    public function validarSeleccionPreguntaSeguridad($preguntaSeguridad) {
        if ($preguntaSeguridad == 0) {
            $this->title = "Error";
            $this->message = "Por favor, seleccione una pregunta de seguridad.";
            return false;
        }
        return true;
    }

    public function validarTextoRespuestaSecreta($txtRespuestaSecreta) {
        //Verificar que el campo de respuesta secreta no este vacio, que tenga al menos 3 caracteres y que contenga solo caracteres alfanumericos
        if (empty($txtRespuestaSecreta)) {
            $this->title = "Error";
            $this->message = "El campo de respuesta secreta está vacío. Por favor, ingrese una respuesta secreta.";
            return false;
        } else if (strlen($txtRespuestaSecreta) < 3) {
            $this->title = "Error";
            $this->message = "Por favor, ingrese una respuesta secreta mayor o igual a 3 caracteres";
            return false;
        } else if (!preg_match("/^[a-zA-Z0-9]*$/", $txtRespuestaSecreta)) {
            $this->title = "Error";
            $this->message = "El campo de respuesta secreta solo puede contener caracteres alfabéticos y numéricos.";
            return false;
        }
        return true;
    }

    public function agregarUsuario($txtNombre, $txtAPaterno, $txtAMaterno, $txtDNI, $txtContraseña, $txtUsuario, $cbxRol, $cbxEstado, $cbxPreguntaSeguridad, $txtRespuestaSecreta) {
        $objUsuario = new Usuario();
        if ($objUsuario->agregarUsuario($txtNombre, $txtAPaterno, $txtAMaterno, $txtDNI, $txtContraseña, $txtUsuario, $cbxRol, $cbxEstado, $cbxPreguntaSeguridad, $txtRespuestaSecreta)) {
            $this->title = "Éxito";
            $this->message = "Usuario registrado correctamente. Será redirigido al panel de gestión de usuarios en 3 segundos.";
            return true;
        } else {
            $this->title = "Error";
            $this->message = "Error al registrar el usuario. Intente nuevamente.";
            return false;
        }
    }

    public function validarVacioTxtEditContraseña($contraseña) {
        if (empty($contraseña)) {
            return true;
        }
        return false;
    }

    public function validarSeleccionCbxEditPreguntaSeguridad($cbxEditPreguntaSeguridad, $idpregunta) {
        if ($cbxEditPreguntaSeguridad == $idpregunta) {
            return false;
        }
        return true;
    }

    public function editarUsuario($idusuario, $txtEditNuevaContraseña, $txtEditUsuario, $cbxEditRol, $cbxEditEstado, $cbxEditPreguntaSeguridad, $txtEditRespuestaSecreta) {
        $objUsuario = new Usuario();
        if ($objUsuario->editarUsuario($idusuario, $txtEditNuevaContraseña, $txtEditUsuario, $cbxEditRol, $cbxEditEstado, $cbxEditPreguntaSeguridad, $txtEditRespuestaSecreta)) {
            $this->title = "Éxito";
            $this->message = "Usuario editado correctamente. Será redirigido al panel de gestión de usuarios en 3 segundos.";
            return true;
        } else {
            $this->title = "Error";
            $this->message = "Error al editar el usuario. Intente nuevamente.";
            return false;
        }
    }

    public function editarUsuarioMenosContraseña($idusuario, $txtEditUsuario, $cbxEditRol, $cbxEditEstado, $cbxEditPreguntaSeguridad, $txtEditRespuestaSecreta) {
        $objUsuario = new Usuario();
        if ($objUsuario->editarUsuarioMenosContraseña($idusuario, $txtEditUsuario, $cbxEditRol, $cbxEditEstado, $cbxEditPreguntaSeguridad, $txtEditRespuestaSecreta)) {
            $this->title = "Éxito";
            $this->message = "Usuario editado correctamente. Será redirigido al panel de gestión de usuarios en 3 segundos.";
            return true;
        } else {
            $this->title = "Error";
            $this->message = "Error al editar el usuario. Intente nuevamente.";
            return false;
        }
    }

    public function editarUsuarioMenosPreguntaSeguridad($idusuario, $txtEditNuevaContraseña, $txtEditUsuario, $cbxEditRol, $cbxEditEstado) {
        $objUsuario = new Usuario();
        if ($objUsuario->editarUsuarioMenosPreguntaSeguridad($idusuario, $txtEditNuevaContraseña, $txtEditUsuario, $cbxEditRol, $cbxEditEstado)) {
            $this->title = "Éxito";
            $this->message = "Usuario editado correctamente. Será redirigido al panel de gestión de usuarios en 3 segundos.";
            return true;
        } else {
            $this->title = "Error";
            $this->message = "Error al editar el usuario. Intente nuevamente.";
            return false;
        }
    }

    public function editarUsuarioMenosContraseñaMenosPreguntaSeguridad($idusuario, $txtEditUsuario, $cbxEditRol, $cbxEditEstado) {
        $objUsuario = new Usuario();
        if ($objUsuario->editarUsuarioMenosContraseñaMenosPreguntaSeguridad($idusuario, $txtEditUsuario, $cbxEditRol, $cbxEditEstado)) {
            $this->title = "Éxito";
            $this->message = "Usuario editado correctamente. Será redirigido al panel de gestión de usuarios en 3 segundos.";
            return true;
        } else {
            $this->title = "Error";
            $this->message = "Error al editar el usuario. Intente nuevamente.";
            return false;
        }
    }

    public function eliminarUsuario($idusuario) {
        $objUsuario = new Usuario();
        if ($objUsuario->eliminarUsuario($idusuario)) {
            $this->title = "Éxito";
            $this->message = "Usuario eliminado correctamente. Será redirigido al panel de gestión de usuarios en 3 segundos.";
            return true;
        } else {
            $this->title = "Error";
            $this->message = "Error al eliminar el usuario. Intente nuevamente.";
            return false;
        }
    }
}
