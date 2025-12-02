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
    <p>Responda la siguiente pregunta de seguridad para <?php echo $_SESSION['usuario']; ?>.<br><?php echo $_SESSION['pregunta']; ?></p>
    <form>
        <input type="text" id="txtRespuesta">
        <button type="button" id="btnAceptar" value="Aceptar" onclick="javascript:enviarForm()">Aceptar</button>
    </form>
    <a href="../../index.php">Volver al inicio</a>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function enviarForm() {
            var respuesta = document.getElementById('txtRespuesta').value;
            var aceptar = document.getElementById('btnAceptar').value;
            $.ajax({
                type: "POST",
                url: "validacionFormPreguntaSeguridad.php",
                data: {
                    txtRespuesta: respuesta,
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
                            timer: 1500
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