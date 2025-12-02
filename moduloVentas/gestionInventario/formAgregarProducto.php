<?php
class formAgregarProducto
{
    public function formAgregarProductoShow($listaCategoria)
    { ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Agregar producto</title>
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
            <div>
                <form action="getInventario.php" method="POST">
                    <div>
                        <p>Nombre Producto</p>
                        <input type="text" name="producto" value="">
                    </div>
                    <div>
                        <p>Descripción Producto</p>
                        <textarea name="descripcion"></textarea>
                    </div>
                    <div>
                        <p>Precio Producto</p>
                        <input type="text" name="precio" value="">
                    </div>
                    <div>
                        <p>Stock</p>
                        <input type="number" name="stock" value="1" min="1">
                    </div>
                    <div>
                        <p>Categoria</p>
                        <select name="idcategoria">
                            <option value="">Seleccione categoría</option>
                            <?php
                            foreach ($listaCategoria as $categoria) {
                                $idcategoria = $categoria['idcategoria'];
                                $nom_categoria = $categoria['categoria'];
                            ?>
                                <option value="<?php echo $idcategoria ?>"><?php echo $nom_categoria ?>
                                </option>
                            <?php
                            } ?>
                        </select>
                    </div>
                    <div>
                        <input type="submit" class="btn btn-primary" name="btnRegistrarProducto" value="Registrar producto">
                    </div>
                </form>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
        </body>

        </html>

<?php
    }
}
?>