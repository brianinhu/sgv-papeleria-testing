<?php
require_once("../../modelo/usuario.php");
require_once("../../modelo/rol_privilegio.php");

class ControllerAutenticacionUsuario
{
    public $title = "";
    public $message = "";

    public function validarBoton($nombreBoton)
    {
        if (isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "Ingresar") {
            return true;
        } else {
            $this->title = "Acceso denegado";
            $this->message = "Se identificó un intento de vulnerabilidad del sistema. Acceso denegado.";
            return false;
        }
    }

    public function validarTextoRespuestaAntiRobot($respuestaAntiRobot)
    {
        if (empty($respuestaAntiRobot)) {
            $this->message = "Complete la respuesta de la suma.";
        } elseif (!ctype_digit($respuestaAntiRobot)) {
            $this->message = "La respuesta debe ser un número entero.";
        } elseif ($respuestaAntiRobot != $_SESSION['captchaResultadoCorrecto']) {
            $this->message = "La respuesta es incorrecta. Intente nuevamente.";
        } else {
            return true;
        }
        return false;
    }

    public function validarTextoUsuario($usuario)
    {
        if (empty($usuario)) {
            $this->message = "Por favor, complete el campo usuario";
        } elseif (strlen($usuario) < 5) {
            $this->message = "El usuario debe tener al menos 5 caracteres";
        } elseif (!ctype_alnum($usuario)) {
            $this->message = "El usuario debe contener solo caracteres alfanuméricos";
        } else {
            return true;
        }
        return false;
    }

    public function validarUsuario($usuario)
    {
        $objUsuario = new Usuario();
        if ($objUsuario->validarUsuario($usuario)) {
            return true;
        } else {
            $this->message = "El usuario ingresado no existe. Intente nuevamente";
            return false;
        }
    }

    public function validarTextoContraseña($contraseña)
    {
        if (empty($contraseña)) {
            $this->message = "Por favor, ingrese su contraseña";
        } elseif (strlen($contraseña) < 8) {
            $this->message = "La contraseña debe tener al menos 8 caracteres";
        } elseif (!preg_match('/[A-Za-z]/', $contraseña) || !preg_match('/[0-9]/', $contraseña) || !preg_match('/[^A-Za-z0-9]/', $contraseña)) {
            $this->message = "La contraseña debe contener al menos un caracter alfabético, numérico y un caracter especial";
        } else {
            return true;
        }
        return false;
    }

    public function validarContraseña($usuario, $contraseña)
    {
        $objUsuario = new Usuario();
        if ($objUsuario->validarContraseña($usuario, $contraseña)) {
            return true;
        } else {
            $this->message = "La contraseña ingresada es incorrecta. Intente nuevamente";
            return false;
        }
    }

    public function validarEstadoUsuario($usuario)
    {
        $objUsuario = new Usuario();
        if ($objUsuario->validarEstadoUsuario($usuario)) {
            $this->message = "Usuario autenticado";
            return true;
        } else {
            $this->message = "El usuario ingresado se encuentra deshabilitado. Comuníquese con el administrador";
            return false;
        }
    }

    public function obtenerPrivilegios($usuario)
    {
        $objRolPrivilegio = new Rol_privilegio();
        return $objRolPrivilegio->obtenerPrivilegios($usuario);
    }

    public function obtenerRol($usuario)
    {
        $objUsuario = new Usuario();
        return $objUsuario->obtenerRol($usuario);
    }

    public function obtenerIDUsuario($usuario)
    {
        $objUsuario = new Usuario();
        return $objUsuario->obtenerIDUsuario($usuario);
    }
}
