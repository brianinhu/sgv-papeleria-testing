<?php
class formRegistrarDespacho
{
    public function formRegistrarDespachoShow($listaBoletas)
    { ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registro de despacho</title>
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
            <form action="getBoleta.php" method="POST">
                <div class="input-group">
                    <input class="form-control" type="text" name="txtBuscarBoleta" placeholder="Buscar boleta" aria-label="Search">
                    <button class="btn btn-light" type="submit" name="btnBuscarBoleta">Buscar</button>
                </div>
            </form>
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <td>ID Boleta</td>
                            <td>Fecha</td>
                            <td>Hora</td>
                            <td>Estado</td>
                            <td>Total</td>
                            <td>Acción</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (empty($listaBoletas)) {
                            echo "<tr><td colspan='6'>No hay boletas pendientes.</td></tr>";
                        } else {
                            foreach ($listaBoletas as $boleta) {
                                $idboleta = $boleta['IDBoleta'];
                                $fecha = $boleta['FechaEmision'];
                                $hora = $boleta['HoraEmision'];
                                $estado = $boleta['Estado'];
                                $total = $boleta['importe_total'];
                        ?>
                                <tr>
                                    <td><?php echo $idboleta; ?></td>
                                    <td><?php echo $fecha; ?></td>
                                    <td><?php echo $hora; ?></td>
                                    <td><?php echo $estado; ?></td>
                                    <td><?php echo $total; ?></td>
                                    <td>
                                        <form action="getBoleta.php" method="POST">
                                            <input type="hidden" name="idBoleta" value="<?php echo $idboleta; ?>">
                                            <input type="submit" class="btn btn-secondary" name="btnVerDetalleBoleta" value="Ver detalle">
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
        </body>

        </html>
<?php
    }
}
?>