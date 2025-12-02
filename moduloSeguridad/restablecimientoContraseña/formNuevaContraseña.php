<?php
session_start();
include_once("../../compartido/mensajeVulnerabilidadSistema.php");
$modal = new MensajeVulnerabilidadSistema();
function validarSesion()
{
    if (isset($_SESSION['usuario'])) {
        return true;
    }
    return false;
}

if (!validarSesion()) {
    $modal->mostrarMensaje("Acceso denegado", "Se identificó un intento de vulnerabilidad del sistema.");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
      <h1>Cambio de contraseña</h1>
    <form>
        <label for="txtNuevaContraseña">Ingresa tu nueva contraseña</label>
        <input type="password" id="txtNuevaContraseña">
        <label for="txtNuevaContraseñaRep">Confirma tu nueva contraseña</label>
        <input type="password" id="txtNuevaContraseñaRep">
        <button type="button" id="btnAceptar" value="Aceptar" onclick="javascript:enviarForm()">Aceptar</button>
    </form>
    <a href="../../index.php">Volver al inicio</a>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function enviarForm() {
            var txtNuevaContraseña = document.getElementById('txtNuevaContraseña').value;
            var txtNuevaContraseñaRep = document.getElementById('txtNuevaContraseñaRep').value;
            var aceptar = document.getElementById('btnAceptar').value;
            $.ajax({
                type: "POST",
                url: "validacionFormNuevaContraseña.php",
                data: {
                    txtNuevaContraseña: txtNuevaContraseña,
                    txtNuevaContraseñaRep: txtNuevaContraseñaRep,
                    btnAceptar: aceptar
                },
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                success: function(response) {
                    if (response['flag'] == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response['message'],
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function() {
                            window.location.href = response['redirect'];
                        });
                    } else if (response['flag'] == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response['message']
                        });
                    }
                }
            });
        }
    </script>
</body>
</html>