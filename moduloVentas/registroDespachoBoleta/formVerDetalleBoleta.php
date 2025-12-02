<?php
class formVerDetalleBoleta
{
    public function formVerDetalleBoletaShow($detalleBoleta)
    {
        $idboleta = isset($detalleBoleta[0]['IDBoleta']) ? $detalleBoleta[0]['IDBoleta'] : '';
        $total = isset($detalleBoleta[0]['importe_total']) ? $detalleBoleta[0]['importe_total'] : '';
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Detalles de boleta | Registrar despacho</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        </head>

        <body>
            <div>
                <a href="../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php">Volver al panel principal</a>
            </div>
            <div>
                <p>Usuario conectado: <?php echo $_SESSION['usuario'] ?></p>
            </div>
            <div>
                <p>Boleta <?php echo $idboleta ?></p>
            </div>
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <td>ID Producto</td>
                            <td>Nombre</td>
                            <td>Cantidad</td>
                            <td>Importe</td>
                            <td>IGV</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($detalleBoleta as $detalle) {
                            $idproducto = $detalle['idproducto'];
                            $nombre = $detalle['producto'];
                            $cantidad = $detalle['cantidad'];
                            $importe = $detalle['Importe'];
                            $igv = $detalle['IGV'];
                        ?>
                            <tr>
                                <td><?php echo $idproducto; ?></td>
                                <td><?php echo $nombre; ?></td>
                                <td><?php echo $cantidad; ?></td>
                                <td><?php echo $importe; ?></td>
                                <td><?php echo $igv; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div>
                    <p>Total</p>
                    <input type="text" value="<?php echo $total ?>" readonly>
                </div>
                <form action="getBoleta.php" method="POST">
                    <input type="hidden" name="idBoleta" value="<?php echo $idboleta; ?>">
                    <input type="submit" class="btn btn-secondary" name="btnDespacharBoleta" value="Despachar boleta">
                </form>

            </div>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
        </body>

        </html>
<?php
    }
} ?>