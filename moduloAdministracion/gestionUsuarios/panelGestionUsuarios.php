<?php

class PanelGestionUsuarios
{
    public function mostrarPanel($usuarios)
    {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>Gestión de usuarios</title>

            <!-- DataTables CSS -->
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css" />

            <!-- Layout global del proyecto (asegúrate que existe y contiene .dashboard, .header, .card, etc.) -->
            <link rel="stylesheet" href="../../assets/css/layout.css">
        </head>

        <body>
            <div class="dashboard">
                <div class="header">
                    <div class="title">
                        <h1>Gestión de usuarios</h1>
                        <div class="meta">Panel de administración · Usuarios registrados</div>
                    </div>

                    <div class="controls">
                        <a class="link" href="../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php">Volver al panel principal</a>
                    </div>
                </div>

                <div class="card">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;">
                        <div style="display:flex;flex-direction:column">
                            <strong style="font-size:0.98rem">Usuarios</strong>
                        </div>

                        <form method="POST" action="validacionPostPanelGestionUsuarios.php" style="margin-left:auto;">
                            <button class="btn" type="submit" name="btnAgregarUsuario" value="Agregar">Agregar usuario</button>
                        </form>
                    </div>

                    <div class="table-responsive" style="margin-top:12px;">
                        <table id="table" class="table stripe hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Apellido paterno</th>
                                    <th>Apellido materno</th>
                                    <th>DNI</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($usuarios as $usuario) {
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($usuario["usuario"]); ?></td>
                                        <td><?php echo htmlspecialchars($usuario["nombre"]); ?></td>
                                        <td><?php echo htmlspecialchars($usuario["apaterno"]); ?></td>
                                        <td><?php echo htmlspecialchars($usuario["amaterno"]); ?></td>
                                        <td><?php echo htmlspecialchars($usuario["DNI"]); ?></td>
                                        <td><?php
                                            if ($usuario['idrol'] == 1) echo "Vendedor";
                                            elseif ($usuario['idrol'] == 2) echo "Cajero";
                                            elseif ($usuario['idrol'] == 3) echo "Despachador";
                                            elseif ($usuario['idrol'] == 4) echo "Administrador";
                                            else echo "—";
                                            ?></td>
                                        <td><?php echo ($usuario["estado"] == 1) ? "Habilitado" : "Deshabilitado"; ?></td>
                                        <td style="display:flex;gap:8px;flex-wrap:wrap;">
                                            <form method="POST" action="validacionPostPanelGestionUsuarios.php" style="margin:0">
                                                <input type="hidden" name="idusuario" value="<?php echo htmlspecialchars($usuario["idusuario"]); ?>">
                                                <button class="btn" type="submit" name="btnEditarUsuario" value="Editar">Editar</button>
                                            </form>
                                            <form method="POST" action="validacionPostPanelGestionUsuarios.php" style="margin:0">
                                                <input type="hidden" name="idusuario" value="<?php echo htmlspecialchars($usuario["idusuario"]); ?>">
                                                <button class="btn secondary" type="submit" name="btnEliminarUsuario" value="Eliminar">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="footer">
                    <div class="meta">Último acceso: <?php echo date('d/m/Y'); ?></div>
                </div>
            </div>

            <!-- Dependencias JS -->
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                (function () {
                    $(document).ready(function () {
                        const table = $('#table').DataTable({
                            responsive: true,
                            pagingType: 'full_numbers',
                            lengthMenu: [4, 8, 12, 16],
                            pageLength: 8,
                            language: {
                                url: '../../assets/json/es-MX.json'
                            },
                            columnDefs: [
                                { orderable: false, targets: -1 } // acciones no ordenables
                            ]
                        });

                        // actualizar contador cuando cambie la búsqueda/paginación
                        function updateCount() {
                            const visible = table.rows({ search: 'applied' }).count();
                            $('#countUsers').text(visible + (visible === 1 ? ' elemento' : ' elementos'));
                        }
                        table.on('draw', updateCount);
                        updateCount();
                    });
                })();
            </script>
        </body>

        </html>
<?php
    }
}
?>
