<?php
class PanelPrincipalUsuario
{
    public function mostrarPanel()
    {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Panel principal</title>
            <link rel="stylesheet" href="../../assets/css/layout.css">
        </head>

        <body>
            <div class="dashboard">
                <div class="header">
                    <div class="title">
                        <h1>Panel principal</h1>
                        <div class="meta">Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong> · Rol: <strong><?php echo htmlspecialchars($_SESSION['rol']); ?></strong></div>
                    </div>

                    <div class="controls">
                        <a class="link" href="../cerrarSesion.php">Cerrar sesión</a>
                    </div>
                </div>

                <div class="card" aria-live="polite">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;">
                        <div style="display:flex;flex-direction:column">
                            <strong style="font-size:0.98rem">Accesos rápidos</strong>
                            <span class="count" id="count"><?php echo count($_SESSION['privilegios']); ?> elementos</span>
                        </div>
                    </div>

                    <div class="privileges-grid" id="grid">
                        <?php
                        foreach ($_SESSION['privilegios'] as $privilegio) {
                            // normalizar nombre/label para búsqueda
                            $label = $privilegio['label'];
                            $icono = $privilegio['icono'];
                            $ruta = $privilegio['ruta'];
                            $name = $privilegio['name'];
                        ?>
                            <div class="privilege" data-label="<?php echo strtolower(htmlspecialchars($label)); ?>">
                                <div class="icon" aria-hidden="true">
                                    <img src="<?php echo htmlspecialchars($icono); ?>" alt="">
                                </div>
                                <div class="priv-text">
                                    <div class="priv-label"><?php echo htmlspecialchars($label); ?></div>
                                </div>

                                <div class="priv-action">
                                    <form method="post" action="<?php echo htmlspecialchars($ruta); ?>">
                                        <button class="btn" type="submit" name="<?php echo htmlspecialchars($name); ?>" value="<?php echo htmlspecialchars($name); ?>">
                                            Abrir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div id="empty" class="empty" style="display:none">No se encontraron privilegios.</div>
                </div>

                <div class="footer">
                    <div class="meta">Último acceso: <?php echo date('d/m/Y'); ?></div>
                </div>
            </div>

            <script>
                (function(){
                    const input = document.getElementById('filter');
                    const grid = document.getElementById('grid');
                    const items = Array.from(grid.querySelectorAll('.privilege'));
                    const empty = document.getElementById('empty');
                    const count = document.getElementById('count');

                    function updateCount() {
                        const visible = items.filter(i => i.style.display !== 'none').length;
                        count.textContent = visible + (visible === 1 ? ' elemento' : ' elementos');
                    }

                    input.addEventListener('input', function(e){
                        const q = e.target.value.trim().toLowerCase();
                        if(!q){
                            items.forEach(i => i.style.display = '');
                        } else {
                            items.forEach(i => {
                                const label = i.getAttribute('data-label') || '';
                                i.style.display = label.indexOf(q) !== -1 ? '' : 'none';
                            });
                        }
                        const visible = items.filter(i => i.style.display !== 'none').length;
                        empty.style.display = visible === 0 ? 'block' : 'none';
                        updateCount();
                    });

                    // accesibilidad: permitir buscar con '/':
                    window.addEventListener('keydown', (e) => {
                        if (e.key === '/' && document.activeElement !== input) {
                            e.preventDefault();
                            input.focus();
                            input.select();
                        }
                    });

                    // inicial
                    updateCount();
                })();
            </script>
        </body>

        </html>
<?php
    }
}
?>
