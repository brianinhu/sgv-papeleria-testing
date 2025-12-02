<?php

class PanelEmisionBoleta {
    public function mostrarPanelEmisionBoleta($listaProforma) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body>
            <h1>PANEL EMISION DE BOLETA</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID proforma</th>
                        <th>Fecha emitida</th>
                        <th>Hora emitida</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($listaProforma as $proforma) {
                        ?>
                        <tr>
                            <td><?php echo $proforma['idproforma']; ?></td>
                            <td><?php echo $proforma['fechaEmision']; ?></td>
                            <td><?php echo $proforma['horaEmision']; ?></td>
                            <td><?php echo $proforma['estado']; ?></td>
                            <td>
                                <form action="postAccionesEmisionBoleta.php" method="POST">
                                    <input type="hidden" name="idusuario" value="<?php echo $proforma['idusuario']; ?>">
                                    <button type="button">Ver Detalles</button>
                                    <button type="button">Emitir Boleta</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            <a href="../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php">Volver al panel principal</a>
        </body>
        </html>
        <?php
    }
}