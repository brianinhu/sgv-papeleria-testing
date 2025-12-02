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
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Autenticación</title>
            <!-- Usar el CSS global -->
            <link rel="stylesheet" href="./assets/css/layout.css">
            <style>
                .card form label {
                    display: block;
                    margin-top: 12px;
                    color: var(--muted);
                    font-size: 0.92rem;
                    font-weight: 600;
                }

                .card form input[type="text"],
                .card form input[type="password"],
                #txtRespuestaAntiRobot {
                    width: 100%;
                    padding: 10px 12px;
                    border-radius: 8px;
                    border: 1px solid rgba(15, 23, 42, 0.06);
                    background: transparent;
                    margin-top: 6px;
                    font-size: 0.95rem;
                    color: inherit;
                    outline: none;
                    transition: box-shadow .12s ease, border-color .12s ease;
                }

                .card form input[type="text"]:focus,
                .card form input[type="password"]:focus,
                #txtRespuestaAntiRobot:focus {
                    box-shadow: 0 6px 18px rgba(16, 24, 40, 0.04);
                    border-color: rgba(37, 99, 235, 0.25);
                }

                #antiRobot {
                    display: flex;
                    gap: 8px;
                    align-items: center;
                    margin-top: 6px;
                }

                #antiRobot img {
                    height: 48px;
                    width: auto;
                    border-radius: 6px;
                    background: rgba(0, 0, 0, 0.02);
                    padding: 4px;
                }

                .btn {
                    min-width: 110px;
                }

                /* Ajustes móviles */
                @media (max-width: 520px) {
                    .card {
                        margin: 12px;
                        padding: 14px;
                    }

                    #antiRobot img {
                        height: 44px;
                    }
                }

                /* Centrar el header */
                .header .title {
                    text-align: center;
                    width: 100%;
                }

                /* Centrar el dashboard correctamente dentro del body */
                .dashboard {
                    align-items: center;
                    justify-content: center;
                    display: flex;
                    min-height: 100vh;
                    flex-direction: column;
                }

                body {
                    padding: 0;
                }
            </style>
        </head>

        <body>
            <div class="dashboard">
                <div class="header">
                    <div class="title">
                        <h1>Autenticación de Usuario</h1>
                        <div class="meta">Ingrese sus credenciales para acceder</div>
                    </div>
                </div>

                <div class="card" style="max-width:420px; margin:18px auto;">
                    <form id="formAutenticacion" autocomplete="off">
                        <label for="txtUsuario">Usuario</label>
                        <input type="text" id="txtUsuario" name="txtUsuario" placeholder="usuario" />

                        <label for="txtContraseña">Contraseña</label>
                        <input type="password" id="txtContraseña" name="txtContraseña" placeholder="contraseña" />

                        <div style="margin-top:8px;">
                            <a class="link" href="./moduloSeguridad/restablecimientoContraseña/formRestablecimientoContraseña.php">¿Olvidó su contraseña?</a>
                        </div>

                        <label for="txtRespuestaAntiRobot" style="margin-top:14px;">Compruebe que no es un robot</label>
                        <div id="antiRobot" style="align-items:center; margin-top:6px;">
                            <img src="moduloSeguridad/autenticacionUsuario/captcha/captcha.php" alt="Captcha" />
                            <input type="text" autocomplete="off" id="txtRespuestaAntiRobot" name="txtRespuestaAntiRobot" style="flex:1;" />
                        </div>

                        <div style="display:flex; justify-content:flex-end; margin-top:14px;">
                            <button type="button" id="btnIngresar" class="btn" value="Ingresar" onclick="enviarForm()">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>

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
