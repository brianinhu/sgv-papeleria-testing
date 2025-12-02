<?php
require_once("conexion.php");

class Usuario extends Conexion
{
    public function validarUsuario($usuario)
    {
        $sql = "SELECT * FROM usuario WHERE usuario = '$usuario'";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        return $resultado->num_rows > 0;
    }

    public function validarContraseña($usuario, $contraseña)
    {
        //verificar el hash de la contraseña
        $sql = "SELECT contraseña FROM usuario WHERE usuario = '$usuario'";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        $fila = $resultado->fetch_assoc();
        return password_verify($contraseña, $fila['contraseña']);
    }

    public function validarEstadoUsuario($usuario)
    {
        $sql = "SELECT estado FROM usuario WHERE usuario = '$usuario'";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        $fila = $resultado->fetch_assoc();
        return $fila['estado'] == 1;
    }

    public function obtenerRol($usuario)
    {
        $sql = "SELECT r.rol FROM usuario u
                JOIN rol r ON u.idrol = r.idrol 
                WHERE u.usuario = '$usuario'";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        $fila = $resultado->fetch_assoc();
        return $fila['rol'];
    }

    public function obtenerPreguntaSeguridad($usuario)
    {
        $sql = "SELECT p.pregunta FROM usuario u JOIN pregunta p ON u.idpregunta = p.idpregunta WHERE usuario = '$usuario'";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        $fila = $resultado->fetch_assoc();
        return $fila['pregunta'];
    }

    public function validarRespuesta($usuario, $respuesta)
    {
        $sql = "SELECT * FROM usuario WHERE usuario = '$usuario' AND respuesta = '$respuesta'";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        return $resultado->num_rows > 0;
    }

    public function restablecerContraseña($usuario, $contraseña)
    {
        //hashear contraseña
        $contraseña = password_hash($contraseña, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET contraseña = '$contraseña' WHERE usuario = '$usuario'";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        return $resultado;
    }

    public function obtenerUsuarios()
    {
        $sql = "SELECT * FROM usuario";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        return $resultado;
    }

    public function obtenerUsuario($idusuario)
    {
        $sql = "SELECT * FROM usuario WHERE idusuario = $idusuario";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        return $resultado->fetch_assoc();
    }

    public function validarDNI($DNI)
    {
        $sql = "SELECT * FROM usuario WHERE dni = '$DNI'";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        return $resultado->num_rows > 0;
    }

    public function agregarUsuario($nombre, $aPaterno, $aMaterno, $DNI, $contraseña, $usuario, $rol, $estado, $pregunta, $respuesta)
    {
        //hashear contraseña
        $contraseña = password_hash($contraseña, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (nombre, apaterno, amaterno, dni, contraseña, usuario, idrol, estado, idpregunta, respuesta) 
                VALUES ('$nombre', '$aPaterno', '$aMaterno', '$DNI', '$contraseña', '$usuario', $rol, $estado, $pregunta, '$respuesta')";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        return $resultado;
    }

    public function editarUsuario($idusuario, $txtEditNuevaContraseña, $txtEditUsuario, $cbxEditRol, $cbxEditEstado, $cbxEditPreguntaSeguridad, $txtEditRespuestaSecreta)
    {
        //hashear contraseña
        $txtEditNuevaContraseña = password_hash($txtEditNuevaContraseña, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET contraseña = '$txtEditNuevaContraseña', usuario = '$txtEditUsuario', idrol = $cbxEditRol, estado = $cbxEditEstado, idpregunta = $cbxEditPreguntaSeguridad, respuesta = '$txtEditRespuestaSecreta' WHERE idusuario = $idusuario";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        return $resultado;
    }

    public function editarUsuarioMenosContraseña($idusuario, $txtEditUsuario, $cbxEditRol, $cbxEditEstado, $cbxEditPreguntaSeguridad, $txtEditRespuestaSecreta)
    {
        $sql = "UPDATE usuario SET usuario = '$txtEditUsuario', idrol = $cbxEditRol, estado = $cbxEditEstado, idpregunta = $cbxEditPreguntaSeguridad, respuesta = '$txtEditRespuestaSecreta' WHERE idusuario = $idusuario";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        return $resultado;
    }

    public function editarUsuarioMenosPreguntaSeguridad($idusuario, $txtEditNuevaContraseña, $txtEditUsuario, $cbxEditRol, $cbxEditEstado)
    {
        //hashear contraseña
        $txtEditNuevaContraseña = password_hash($txtEditNuevaContraseña, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET contraseña = '$txtEditNuevaContraseña', usuario = '$txtEditUsuario', idrol = $cbxEditRol, estado = $cbxEditEstado WHERE idusuario = $idusuario";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        return $resultado;
    }

    public function editarUsuarioMenosContraseñaMenosPreguntaSeguridad($idusuario, $txtEditUsuario, $cbxEditRol, $cbxEditEstado)
    {
        $sql = "UPDATE usuario SET usuario = '$txtEditUsuario', idrol = $cbxEditRol, estado = $cbxEditEstado WHERE idusuario = $idusuario";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        return $resultado;
    }

    public function eliminarUsuario($idusuario)
    {
        $sql = "DELETE FROM usuario WHERE idusuario = $idusuario";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        return $resultado;
    }

    // obtener id del usuario
    public function obtenerIdUsuario($usuario)
    {
        $sql = "SELECT idusuario FROM usuario WHERE usuario = '$usuario'";
        $resultado = $this->conectar()->query($sql);
        $this->desconectar();
        $fila = $resultado->fetch_assoc();
        return $fila['idusuario'];
    }
}
