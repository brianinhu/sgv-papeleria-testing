<?php
class formGestionarInventario
{
    public function formGestionarInventarioShow($listaProductos, $listaCategoria)
    { ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Gestión de Inventario</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <!-- DataTables CSS -->
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
            <link rel="stylesheet" href="../../assets/css/layout.css">
        </head>

        <body>
            <div class="dashboard">
                <div class="header">
                    <div class="title">
                        <h1>Gestión de Inventario</h1>
                        <div class="meta">Usuario conectado: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></div>
                    </div>

                    <div class="controls">
                        <a class="link" href="../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php">Volver al panel principal</a>
                    </div>
                </div>

                <div class="card" aria-live="polite">
                    <p class="subtitle">Productos disponibles</p>
                    <div class="table-responsive">
                        <table class="table" id="inventoryTable">
                            <thead>
                                <tr>
                                    <td>ID Producto</td>
                                    <td>Nombre</td>
                                    <td>Descripción</td>
                                    <td>Precio</td>
                                    <td>Stock</td>
                                    <td>Categoría</td>
                                    <td>Acción</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $categoriasPorId = [];
                                foreach ($listaCategoria as $categoria) {
                                    $categoriasPorId[$categoria['idcategoria']] = $categoria['categoria'];
                                }
                                if (!empty($listaProductos)) {
                                    foreach ($listaProductos as $producto) {
                                        $idproducto = $producto['idproducto'];
                                        $nom_producto = $producto['producto'];
                                        $descripcion = $producto['descripcion'];
                                        $precio = $producto['precio'];
                                        $stock = $producto['stock'];
                                        $categoriaId = $producto['idcategoria'];
                                        $nombreCategoria = isset($categoriasPorId[$categoriaId]) ? $categoriasPorId[$categoriaId] : 'null';
                                ?>
                                        <tr>
                                            <td><?php echo $idproducto; ?></td>
                                            <td><?php echo $nom_producto; ?></td>
                                            <td><?php echo $descripcion; ?></td>
                                            <td><?php echo $precio; ?></td>
                                            <td><?php echo $stock; ?></td>
                                            <td><?php echo $nombreCategoria; ?></td>
                                            <td>
                                                <form action="getInventario.php" method="POST">
                                                    <input type="hidden" name="idproducto" value="<?php echo $idproducto; ?>">
                                                    <input type="submit" class="btn" name="btnEditarProducto" value="Editar producto">
                                                </form>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7">No se encontraron productos</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div style="margin-top:12px; display:flex; gap:8px;">
                        <form action="getInventario.php" method="POST">
                            <input type="submit" class="btn" name="btnGenerarReporte" value="Generar reporte">
                        </form>
                        <form action="getInventario.php" method="POST">
                            <input type="submit" class="btn secondary" name="btnAgregarProducto" value="Agregar producto">
                        </form>
                    </div>
                </div>

                <div class="footer">
                    <div class="meta">Último acceso: <?php echo date('d/m/Y'); ?></div>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <!-- DataTables JS -->
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
            <script>
                (function(){
                    $(document).ready(function(){
                        $('#inventoryTable').DataTable({
                            responsive: true,
                            pageLength: 5,
                            lengthChange: false,
                            language: {
                                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                            },
                            columnDefs: [
                                { orderable: false, targets: -1 } // columna de acciones no ordenable
                            ]
                        });
                    });
                })();
            </script>
        </body>

        </html>

<?php
    }
}

?>