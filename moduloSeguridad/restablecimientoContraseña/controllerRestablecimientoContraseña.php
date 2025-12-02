<?php
require_once("../../modelo/usuario.php");
class ControllerRestablecimientoContraseña
{
    public $message = "";

    public function validarBoton($nombreBoton)
    {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "Aceptar";
    }

    public function validarTextoUsuario($usuario)
    {
        if (empty($usuario)) {
            $this->message = "Complete el campo usuario";
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
            $this->message = "El usuario ingresado no existe. Intente nuevamente.";
            return false;
        }
    }

    public function obtenerPreguntaSeguridad($usuario)
    {
        $objUsuario = new Usuario();
        return $objUsuario->obtenerPreguntaSeguridad($usuario);
    }

    public function validarTextoRespuesta($respuesta)
    {
        if (empty($respuesta)) {
            $this->message = "Complete el campo respuesta";
        } elseif (strlen($respuesta) < 3) {
            $this->message = "La respuesta debe tener al menos 3 caracteres";
        } elseif (!ctype_alnum(str_replace(' ', '', $respuesta))) {
            $this->message = "La respuesta debe contener solo caracteres alfanuméricos";
        } else {
            return true;
        }
        return false;
    }

    public function validarRespuesta($usuario, $respuesta)
    {
        $objUsuario = new Usuario();
        if ($objUsuario->validarRespuesta($usuario, $respuesta)) {
            return true;
        } else {
            $this->message = "La respuesta ingresada es incorrecta. Intente nuevamente.";
            return false;
        }
    }

    public function validarTextoNuevaContraseña($txtNuevaContraseña)
    {
        if (empty($txtNuevaContraseña)) {
            $this->message = "Complete el campo contraseña";
        } elseif (strlen($txtNuevaContraseña) < 8) {
            $this->message = "La contraseña debe tener al menos 8 caracteres";
        } elseif (!preg_match('/[A-Za-z]/', $txtNuevaContraseña) || !preg_match('/[0-9]/', $txtNuevaContraseña) || !preg_match('/[^A-Za-z0-9]/', $txtNuevaContraseña)) {
            $this->message = "La contraseña debe contener al menos un caracter alfabético, numérico y especial";
        } else {
            return true;
        }
        return false;
    }

    public function validarTextoIgualdadContraseñas($txtNuevaContraseña, $txtNuevaContraseñaRep)
    {
        if ($txtNuevaContraseña == $txtNuevaContraseñaRep) {
            return true;
        } else {
            $this->message = "Las contraseñas no coinciden";
            return false;
        }
    }

    public function restablecerContraseña($usuario, $txtNuevaContraseña)
    {
        $objUsuario = new Usuario();
        $objUsuario->restablecerContraseña($usuario, $txtNuevaContraseña);
        $this->message = "Su contraseña fue actualizada correctamente. Será redirigido al inicio de sesión en 3 segundos.";
    }
}
