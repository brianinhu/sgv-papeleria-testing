<?php

class FormEditarUsuario
{
    public function mostrarFormulario($usuario)
    {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar usuario</title>
            <link rel="stylesheet" href="../../assets/css/layout.css">
            <style>
                /* ajustes locales para el formulario de edición */
                #formEditar {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 12px;
                }

                #formEditar div {
                    display: flex;
                    flex-direction: column;
                    gap: 6px;
                }

                #formEditar .full {
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

                form.inline {
                    display: inline-block;
                    margin: 0;
                }
            </style>
        </head>

        <body>
            <div class="dashboard">
                <div class="header">
                    <div>
                        <div class="title">
                            <h1>Editar usuario</h1>
                            <div class="meta">Actualice los datos del usuario</div>
                        </div>
                    </div>
                    <div class="controls">
                        <form method="post" action="validacionPrePanelGestionUsuarios.php" class="inline">
                            <button type="submit" name="btnGestionUsuarios" value="btnGestionUsuarios" class="btn">Volver al panel</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <form id="formEditar">
                        <input type="hidden" id="idusuario" value="<?php echo $usuario['idusuario']; ?>">

                        <div>
                            <label>Nombre</label>
                            <input type="text" disabled value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
                        </div>

                        <div>
                            <label>Apellido paterno</label>
                            <input type="text" disabled value="<?php echo htmlspecialchars($usuario['apaterno']); ?>">
                        </div>

                        <div>
                            <label>Apellido materno</label>
                            <input type="text" disabled value="<?php echo htmlspecialchars($usuario['amaterno']); ?>">
                        </div>

                        <div>
                            <label>DNI</label>
                            <input type="text" disabled value="<?php echo htmlspecialchars($usuario['DNI']); ?>">
                        </div>

                        <div>
                            <label for="txtEditNuevaContraseña">Nueva contraseña</label>
                            <input type="password" id="txtEditNuevaContraseña">
                        </div>

                        <div>
                            <label for="txtEditConfNuevaContraseña">Confirme la nueva contraseña</label>
                            <input type="password" id="txtEditConfNuevaContraseña">
                        </div>

                        <div>
                            <label for="txtEditUsuario">Usuario</label>
                            <input type="text" id="txtEditUsuario" value="<?php echo htmlspecialchars($usuario['usuario']); ?>">
                        </div>

                        <div>
                            <label for="cbxEditRol">Rol</label>
                            <select id="cbxEditRol">
                                <option value="1" <?php if ($usuario['idrol'] == 1) echo "selected"; ?>>Vendedor</option>
                                <option value="2" <?php if ($usuario['idrol'] == 2) echo "selected"; ?>>Cajero</option>
                                <option value="3" <?php if ($usuario['idrol'] == 3) echo "selected"; ?>>Despachador</option>
                                <option value="4" <?php if ($usuario['idrol'] == 4) echo "selected"; ?>>Administrador</option>
                            </select>
                        </div>

                        <div>
                            <label for="cbxEditEstado">Estado</label>
                            <select id="cbxEditEstado">
                                <option value="1" <?php if ($usuario['estado'] == 1) echo "selected"; ?>>Habilitado</option>
                                <option value="0" <?php if ($usuario['estado'] == 0) echo "selected"; ?>>Deshabilitado</option>
                            </select>
                        </div>

                        <div>
                            <label for="cbxEditPreguntaSeguridad">Pregunta de seguridad</label>
                            <input type="hidden" id="idpregunta" value="<?php echo $usuario['idpregunta']; ?>">
                            <select id="cbxEditPreguntaSeguridad">
                                <option value="1" <?php if ($usuario['idpregunta'] == 1) echo "selected"; ?>>¿Cuál es su comida favorita?</option>
                                <option value="2" <?php if ($usuario['idpregunta'] == 2) echo "selected"; ?>>¿Cuál es el nombre de su abuela?</option>
                            </select>
                        </div>

                        <div class="full">
                            <label for="txtEditRespuestaSecreta">Respuesta secreta</label>
                            <input type="text" id="txtEditRespuestaSecreta" value="">
                        </div>

                        <div class="full" style="display:flex; justify-content:flex-end; gap:10px; margin-top:6px;">
                            <button type="button" id="btnEditGuardarCambios" value="btnEditGuardarCambios" class="btn" onclick="guardarCambios()">Guardar cambios</button>
                        </div>
                    </form>
                </div>

                <div class="footer">
                    <div class="count">Campos obligatorios: ninguno marcado</div>
                    <a href="#" class="link" onclick="document.getElementById('formEditar').reset(); return false;">Limpiar formulario</a>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                function guardarCambios() {
                    var idusuario = document.getElementById("idusuario").value;
                    var contraseña = document.getElementById("txtEditNuevaContraseña").value;
                    var confContraseña = document.getElementById("txtEditConfNuevaContraseña").value;
                    var usuario = document.getElementById("txtEditUsuario").value;
                    var rol = document.getElementById("cbxEditRol").value;
                    var estado = document.getElementById("cbxEditEstado").value;
                    var idpregunta = document.getElementById("idpregunta").value;
                    var preguntaSeguridad = document.getElementById("cbxEditPreguntaSeguridad").value;
                    var respuesta = document.getElementById("txtEditRespuestaSecreta").value;
                    var boton = document.getElementById("btnEditGuardarCambios").value;
                    $.ajax({
                        type: "POST",
                        url: "validacionEditarUsuario.php",
                        data: {
                            idusuario: idusuario,
                            txtEditNuevaContraseña: contraseña,
                            txtEditConfNuevaContraseña: confContraseña,
                            txtEditUsuario: usuario,
                            cbxEditRol: rol,
                            cbxEditEstado: estado,
                            idpregunta: idpregunta,
                            cbxEditPreguntaSeguridad: preguntaSeguridad,
                            txtEditRespuestaSecreta: respuesta,
                            btnEditGuardarCambios: boton
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
