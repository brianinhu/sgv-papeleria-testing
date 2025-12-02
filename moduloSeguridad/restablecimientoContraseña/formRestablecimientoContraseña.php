<?php
session_start();
if (isset($_SESSION['usuario'])) {
    session_destroy(); 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        form {
            display: flex;
            flex-direction: column;
            width: 200px;
            margin: 0 auto;
        }

        label {
            margin-top: 10px;
        }

        input {
            margin-top: 5px;
        }

        button {
            margin-top: 10px;
            padding: 5px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Restablecimiento de contraseña</h1>
    <form>
        <label for="txtUsuario">Ingresa tu usuario</label>
        <input type="text" id="txtUsuario">
        <button type="button" id="btnAceptar" value="Aceptar" onclick="javascript:enviarForm()">Aceptar</button>
    </form>
    <a href="../../index.php">Volver al inicio</a>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function enviarForm() {
            var txtUsuario = document.getElementById('txtUsuario').value;
            var btnAceptar = document.getElementById('btnAceptar').value;
            $.ajax({
                type: "POST",
                url: "validacionFormRestablecimientoContraseña.php",
                data: {
                    txtUsuario: txtUsuario,
                    btnAceptar: btnAceptar
                },
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                success: function(response) {
                    if (response['flag'] == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response['message'],
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = response['redirect'];
                        });
                    } else if (response['flag'] == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response['message']
                        });
                    }
                }
            });
        }
    </script>
</body>

</html>