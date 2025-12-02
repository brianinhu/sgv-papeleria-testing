<?php
class formEditarProducto
{
    public function formEditarProductoShow($datosProducto, $listaCategoria)
    { ?>
        <!DOCTYPE html>
        <div lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Editar producto</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
                <link rel="stylesheet" href="../../assets/css/layout.css">
            </head>

            <body>
                <div>
                    <a href="../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php">Volver al panel principal</a>
                </div>
                <div>
                    <p>Usuario conectado: <?php echo $_SESSION['usuario'] ?></p>
                </div>
                <form action="getInventario.php" method="POST">
                    <div>
                        <p>Nombre Producto</p>
                        <input type="text" name="producto" value="<?php echo $datosProducto['producto']; ?>">
                    </div>
                    <div>
                        <p>Descripción Producto</p>
                        <textarea name="descripcion"><?php echo htmlspecialchars($datosProducto['descripcion']); ?></textarea>
                    </div>
                    <div>
                        <p>Precio Producto</p>
                        <input type="text" name="precio" value="<?php echo $datosProducto['precio']; ?>">
                    </div>
                    <div>
                        <p>Stock</p>
                        <input type="number" name="stock" value="<?php echo $datosProducto['stock']; ?>" min="1">
                    </div>
                    <div>
                        <p>Categoria</p>
                        <select name="idcategoria">
                            <?php
                            foreach ($listaCategoria as $categoria) {
                                $idcategoria = $categoria['idcategoria'];
                                $nom_categoria = $categoria['categoria'];
                                $selected = ($idcategoria == $datosProducto['idcategoria']) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $idcategoria ?>" <?php echo $selected ?>><?php echo $nom_categoria ?></option>
                            <?php
                            } ?>
                        </select>
                    </div>
                    <div>
                        <input type="hidden" name="idproducto" value="<?php echo $datosProducto['idproducto']; ?>">
                        <input type="submit" class="btn btn-primary" name="btnGuardarCambios" value="Guardar cambios">
                    </div>
                </form>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
            </body>

            </html>

    <?php
    }
}
    ?>