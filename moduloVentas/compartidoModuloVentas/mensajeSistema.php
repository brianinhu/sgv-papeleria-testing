<?php
class mensajeSistema
{
    public function mensajeSistemaShow($mensaje, $ruta, $tipo = "", $suceso = false)
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Alerta</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        </head>

        <body>
            <div id="myModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-confirm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="icon-box">
                            </div>
                            <h4 class="modal-title w-100">
                                <?php echo $suceso ? '¡Éxito!' : '¡Error!'; ?>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p class="text-center">
                                <?php echo strtoupper($mensaje) ?>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <?php
                            $buttonClass = $suceso ? 'btn-success' : 'btn-danger';
                            ?>
                            <button type="button" class="btn <?php echo $buttonClass; ?> btn-block"
                                onclick="redirigir('<?php echo $ruta; ?>')">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                crossorigin="anonymous"></script>
            <script>
                $(document).ready(function () {
                    $('#myModal').modal('show');
                });

                function redirigir(enlace) {
                    <?php if ($tipo === "systemOut"): ?>
                        window.location.href = "<?php echo $ruta; ?>";
                    <?php else: ?>
                        $('#myModal').modal('hide');
                    <?php endif; ?>
                }
            </script>
        </body>

        </html>
        <?php
    }
}
?>