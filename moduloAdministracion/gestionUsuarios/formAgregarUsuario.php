<?php

class FormAgregarUsuario
{
    public function mostrarFormulario()
    {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Agregar usuario</title>
            <link rel="stylesheet" href="../../assets/css/layout.css">
            <style>
                /* ajustes locales pequeños para el formulario */
                * {
                    font-family: system-ui, arial;
                }

                body {
                    margin: 0;
                }

                #formAgregar {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 12px;
                }

                #formAgregar div {
                    display: flex;
                    flex-direction: column;
                    gap: 6px;
                }

                #formAgregar .full {
                    grid-column: 1 / -1;
                }

                label {
                    font-weight: 600;
                    font-size: 0.95rem;
                }

                input[type="text"],
                input[type="password"],
                select {
                    padding: 8px 10px;
                    border-radius: 8px;
                    border: 1px solid rgba(15,23,42,0.08);
                    background: #fff;
                }

                .actions {
                    display: flex;
                    gap: 10px;
                    justify-content: flex-end;
                    align-items: center;
                }
            </style>
        </head>

        <body>
            <div class="dashboard">
                <div class="header">
                    <div>
                        <div class="title">
                            <h1>Agregar usuario</h1>
                            <div class="meta">Complete los datos para crear un nuevo usuario</div>
                        </div>
                    </div>
                    <div class="controls">
                        <form method="post" action="validacionPrePanelGestionUsuarios.php" style="margin:0">
                            <button type="submit" name="btnGestionUsuarios" value="btnGestionUsuarios" class="btn">Volver al panel</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <form id="formAgregar">
                        <div>
                            <label for="txtNombre">Nombre:</label>
                            <input type="text" id="txtNombre" name="txtNombre">
                        </div>
                        <div>
                            <label for="txtAPaterno">Apellido paterno:</label>
                            <input type="text" id="txtAPaterno" name="txtAPaterno">
                        </div>
                        <div>
                            <label for="txtAMaterno">Apellido materno:</label>
                            <input type="text" id="txtAMaterno" name="txtAMaterno">
                        </div>
                        <div>
                            <label for="txtDNI">DNI:</label>
                            <input type="text" id="txtDNI" name="txtDNI">
                        </div>
                        <div>
                            <label for="txtContraseña">Contraseña:</label>
                            <input type="password" id="txtContraseña" name="txtContraseña">
                        </div>
                        <div>
                            <label for="txtConfContraseña">Confirme su contraseña:</label>
                            <input type="password" id="txtConfContraseña" name="txtConfContraseña">
                        </div>
                        <div>
                            <label for="txtUsuario">Usuario:</label>
                            <input type="text" id="txtUsuario" name="txtUsuario">
                        </div>
                        <div>
                            <label for="cbxRol">Rol:</label>
                            <select id="cbxRol" name="cbxRol">
                                <option value="0">Seleccione un rol</option>
                                <option value="1">Vendedor</option>
                                <option value="2">Cajero</option>
                                <option value="3">Despachador</option>
                                <option value="4">Administrador</option>
                            </select>
                        </div>
                        <div>
                            <label for="cbxEstado">Estado:</label>
                            <select id="cbxEstado" name="cbxEstado">
                                <option value="-1">Seleccione un estado</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div>
                            <label for="cbxPreguntaSeguridad">Pregunta de seguridad:</label>
                            <select id="cbxPreguntaSeguridad" name="cbxPreguntaSeguridad">
                                <option value="0">Seleccione una pregunta</option>
                                <option value="1">¿Cuál es tu comida favorita?</option>
                                <option value="2">¿Cuál es el nombre de su abuela?</option>
                            </select>
                        </div>
                        <div class="full">
                            <label for="txtRespuestaSecreta">Respuesta secreta:</label>
                            <input type="text" id="txtRespuestaSecreta" name="txtRespuestaSecreta">
                        </div>

                        <div class="full actions">
                            <button type="button" id="btnCreateAgregar" class="btn" onclick="createAgregar()" value="btnCreateAgregar">Agregar usuario</button>
                        </div>
                    </form>
                </div>

                <div class="footer">
                    <div class="count">Campos obligatorios: ninguno marcado</div>
                    <a href="#" class="link" onclick="document.getElementById('formAgregar').reset(); return false;">Limpiar formulario</a>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                function createAgregar() {
                    var nombre = document.getElementById("txtNombre").value;
                    var aPaterno = document.getElementById("txtAPaterno").value;
                    var aMaterno = document.getElementById("txtAMaterno").value;
                    var dni = document.getElementById("txtDNI").value;
                    var contraseña = document.getElementById("txtContraseña").value;
                    var confContraseña = document.getElementById("txtConfContraseña").value;
                    var usuario = document.getElementById("txtUsuario").value;
                    var rol = document.getElementById("cbxRol").value;
                    var estado = document.getElementById("cbxEstado").value;
                    var preguntaSeguridad = document.getElementById("cbxPreguntaSeguridad").value;
                    var respuesta = document.getElementById("txtRespuestaSecreta").value;
                    var btnCreateAgregar = document.getElementById("btnCreateAgregar").value;
                    $.ajax({
                        type: "POST",
                        url: "validacionAgregarUsuario.php",
                        data: {
                            txtNombre: nombre,
                            txtAPaterno: aPaterno,
                            txtAMaterno: aMaterno,
                            txtDNI: dni,
                            txtContraseña: contraseña,
                            txtConfContraseña: confContraseña,
                            txtUsuario: usuario,
                            cbxRol: rol,
                            cbxEstado: estado,
                            cbxPreguntaSeguridad: preguntaSeguridad,
                            txtRespuestaSecreta: respuesta,
                            btnCreateAgregar: btnCreateAgregar
                        },
                        success: function(response) {
                            if (response['flag'] == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: response['title'],
                                    text: response['message'],
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(function() {
                                    window.location.href = response['redirect'];
                                });
                            } else if (response['flag'] == 0) {
                                Swal.fire({
                                    icon: 'error',
                                    title: response['title'],
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
