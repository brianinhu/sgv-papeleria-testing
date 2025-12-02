<?php
class formEmitirProforma
{
    public function formEmitirProformaShow($listaProductos, $listaCategoria)
    { ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Emisión de Proforma</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <!-- DataTables CSS -->
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
            <link rel="stylesheet" href="../../assets/css/layout.css">
        </head>

        <body>
            <div class="dashboard">
                <div class="header">
                    <div>
                        <h1>Emisión de Proforma</h1>
                        <div class="meta">Usuario: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></div>
                    </div>

                    <div class="controls">
                        <a class="link" href="../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php">Volver al panel</a>
                    </div>
                </div>

                <div class="card" aria-live="polite">
                    <p class="subtitle">Productos disponibles</p>
                    <div class="table-responsive">
                        <table id="productsTable" class="table align-middle mb-0" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="productGrid">
                                <?php
                                if (!empty($listaProductos)) {
                                    $categoriasPorId = [];
                                    foreach ($listaCategoria as $categoria) {
                                        $categoriasPorId[$categoria['idcategoria']] = $categoria['categoria'];
                                    }

                                    foreach ($listaProductos as $producto) {
                                        $idProducto = $producto['idproducto'];
                                        $nombre = $producto['producto'];
                                        $descripcion = $producto['descripcion'];
                                        $categoriaId = $producto['idcategoria'];
                                        $precio = $producto['precio'];
                                        $stock = $producto['stock'];
                                        $nombreCategoria = isset($categoriasPorId[$categoriaId]) ? $categoriasPorId[$categoriaId] : 'Sin categoría';
                                        $dataLabel = strtolower($nombre . ' ' . $descripcion . ' ' . $nombreCategoria);
                                ?>
                                        <tr class="product-row" data-label="<?php echo htmlspecialchars($dataLabel); ?>">
                                            <td class="datosProducto"><?php echo htmlspecialchars($idProducto); ?></td>
                                            <td class="datosProducto"><?php echo htmlspecialchars($nombre); ?></td>
                                            <td><?php echo htmlspecialchars($descripcion); ?></td>
                                            <td><?php echo htmlspecialchars($nombreCategoria); ?></td>
                                            <td class="datosProducto"><?php echo htmlspecialchars($precio); ?></td>
                                            <td class="datosProducto"><?php echo htmlspecialchars($stock); ?></td>
                                            <td><?php echo $stock == 0 ? 'Agotado' : 'Disponible'; ?></td>
                                            <td>
                                                <input type="button" class="btn <?php echo $stock == 0 ? 'secondary' : ''; ?> add-product" name="btnAgregarProducto" data-id="<?php echo htmlspecialchars($idProducto); ?>" data-nombre="<?php echo htmlspecialchars($nombre); ?>" data-precio="<?php echo htmlspecialchars($precio); ?>" value="Agregar" <?php echo $stock == 0 ? 'disabled' : ''; ?>>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                } else { ?>
                                    <tr>
                                        <td colspan='8'>No hay productos disponibles.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div style="display:flex;justify-content:flex-end;margin-top:12px;">
                        <input type="button" id="verListaProforma" value="Ver lista de productos" class="btn">
                    </div>
                </div>

                <div class="resumenProforma card">
                    <form action="getProforma.php" method="POST" class="formEmitirProforma">
                        <h2 class="subtitle">Lista de productos</h2>
                        <div>
                            <p style="text-align: left;">Productos seleccionados</p>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody class="listaProductos">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:12px;">
                            <p style="margin:0">Total</p>
                            <input type="text" name="totalProforma" class="totalProforma form-control" style="max-width:160px" readonly>
                        </div>

                        <div style="margin-top:12px;">
                            <input type="submit" name="btnGenerarProforma" value="Generar Proforma" class="btn">
                        </div>
                    </form>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <!-- DataTables JS -->
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
            <script src="../../assets/js/emitirProforma.js"></script>
            <script>
                (function(){
                    // Toggle resumen
                    $(document).ready(function() {
                        $('#verListaProforma').click(function() {
                            $('.resumenProforma').toggle();
                        });
                    });

                    // Inicializar DataTable
                    let table = $('#productsTable').DataTable({
                        responsive: true,
                        pageLength: 8,
                        lengthChange: false,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                        },
                        columnDefs: [
                            { orderable: false, targets: -1 } // acciones no ordenables
                        ]
                    });
                })();
            </script>
        </body>

        </html>
<?php
    }
}
?>