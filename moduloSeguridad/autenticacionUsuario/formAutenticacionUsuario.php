<?php

session_start();
if (isset($_SESSION['usuario'])) {
    session_destroy();
}
class FormAutenticacionUsuario
{
    public function mostrarFormulario()
    {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Index</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                }

                form {
                    display: flex;
                    flex-direction: column;
                    width: 200px;
                    margin: 0 auto;
                }

                label {
                    margin-top: 10px;
                }

                input {
                    margin-top: 5px;
                }

                button {
                    margin-top: 10px;
                    padding: 5px;
                    background-color: #007bff;
                    color: white;
                    border: none;
                    cursor: pointer;
                }

                #antiRobot {
                    display: flex;
                    gap: 5px;
                }
            </style>
        </head>

        <body>
            <h1>Autenticación de Usuario</h1>
            <form>
                <label for="txtUsuario">Usuario:</label>
                <input type="text" id="txtUsuario">
                <label for="txtContraseña">Contraseña:</label>
                <input type="password" id="txtContraseña">
                <a href="./moduloSeguridad/restablecimientoContraseña/formRestablecimientoContraseña.php">¿Olvidó su contraseña?</a>
                <label for="txtRespuestaAntiRobot">Compruebe que no es un robot.</label>
                <div id="antiRobot">
                    <img src="moduloSeguridad/autenticacionUsuario/captcha/captcha.php" alt="Captcha" />
                    <input type="text" autocomplete="off" id="txtRespuestaAntiRobot">
                </div>
                <button type="button" id="btnIngresar" value="Ingresar" onclick="javascript:enviarForm()">Ingresar</button>
            </form>
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                function enviarForm() {
                    var usuario = document.getElementById("txtUsuario").value;
                    var password = document.getElementById("txtContraseña").value;
                    var respuestaAntiRobot = document.getElementById("txtRespuestaAntiRobot").value;
                    var btnIngresar = document.getElementById("btnIngresar").value;
                    $.ajax({
                        type: "POST",
                        url: "./moduloSeguridad/autenticacionUsuario/validacionFormAutenticacionUsuario.php",
                        data: {
                            txtUsuario: usuario,
                            txtContraseña: password,
                            txtRespuestaAntiRobot: respuestaAntiRobot,
                            btnIngresar: btnIngresar
                        },
                        success: function(response) {
                            if (response['flag'] == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'Usuario autenticado',
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
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error en la solicitud'
                            });
                        }
                    });
                }
            </script>

        </body>

        </html>
<?php
    }
}
