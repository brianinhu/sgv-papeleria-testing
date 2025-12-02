<?php
include_once "controlGestionarInventario.php";
include_once "../compartidoModuloVentas/mensajeSistema.php";
include_once "formGestionarInventario.php";
include_once "formAgregarProducto.php";
include_once "formEditarProducto.php";
include_once("../../modelo/producto.php");
include_once("../../modelo/categoria.php");

session_start();

$campo = "";
$mensaje = "";

function verificarSesionIniciada()
{
    return isset($_SESSION['usuario']);
}

function validarBoton($boton)
{
    return isset($boton);
}

function verificarCamposVacios($txtBuscarProducto)
{
    return $txtBuscarProducto != "";
}

function verificarCaracteresEspeciales($txtBuscarProducto)
{
    if (preg_match("/[^a-zA-Z0-9áéíóúÁÉÍÓÚ\s]/", $txtBuscarProducto)) {
        return true;
    } else {
        return false;
    }
}

function verificarCamposProducto($nom_producto, $descripcion, $precio, $stock, $idcategoria)
{
    global $campo, $mensaje;
    if (strlen($nom_producto) < 4 || strlen($nom_producto) > 45 || preg_match("/[^a-zA-Z0-9áéíóúÁÉÍÓÚ\s]/", $nom_producto)) {
        $campo = 'Nombre de producto';
        $mensaje = 'Complete el campo ' . $campo . ' correctamente. (Mínimo 4 caracteres y máximo 45 caracteres)';
        return false;
    } else if (strlen($descripcion) < 4 || strlen($descripcion) > 50) {
        $campo = 'Descripción';
        $mensaje = 'Complete el campo ' . $campo . ' correctamente. (Mínimo 4 caracteres y máximo 50 caracteres)';
        return false;
    } else if (empty($precio) || $precio < 0 || !preg_match("/^\d+(\.\d+)?$/", $precio)) {
        $campo = 'Precio';
        $mensaje = 'Complete el campo ' . $campo . ' correctamente. (Sólo números)';
        return false;
    } else if (empty($stock) || $stock < 0 || !preg_match("/^\d+$/", $stock)) {
        $campo = 'Stock';
        $mensaje = 'Complete el campo ' . $campo . ' correctamente. (Sólo números enteros)';
        return false;
    } else if (empty($idcategoria) || $idcategoria < 0 || !preg_match("/^\d+$/", $idcategoria)) {
        $mensaje = 'Seleccione una categoría';
        return false;
    }
    return true;
}

$btnGestionarInventario = $_POST['btnGestionarInventario'] ?? null;
$btnBuscarProducto = $_POST['btnBuscarProducto'] ?? null;
$btnAgregarProducto = $_POST['btnAgregarProducto'] ?? null;
$btnRegistrarProducto = $_POST['btnRegistrarProducto'] ?? null;
$btnEditarProducto = $_POST['btnEditarProducto'] ?? null;
$btnGuardarCambios = $_POST['btnGuardarCambios'] ?? null;
$btnGenerarReporte = $_POST['btnGenerarReporte'] ?? null;

//Validación de botones -------------------------------------
if (validarBoton($btnGestionarInventario)) {
    if (verificarSesionIniciada()) {
        $objControlGestionarInventario = new controlGestionarInventario();
        $objControlGestionarInventario->listarProductosBD();
    } else {
        header('Location: ../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php');
        exit;
    }
} else if (validarBoton($btnBuscarProducto)) {
    $txtBuscarProducto = strtolower($_POST['txtBuscarProducto']);

    if (verificarCamposVacios($txtBuscarProducto)) {
        if (!verificarCaracteresEspeciales($txtBuscarProducto)) {
            $objControlGestionarInventario = new controlGestionarInventario();
            $objControlGestionarInventario->listarBusquedaProductos($txtBuscarProducto);
        } else {
            $objProducto = new producto();
            $listaProductos = $objProducto->listarProductos();
            $objCategoria = new categoria();
            $listaCategoria = $objCategoria->listarCategoria();
            $objFormGestionarInventario = new formGestionarInventario();
            $objFormGestionarInventario->formGestionarInventarioShow($listaProductos, $listaCategoria);

            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Se detectaron caracteres no válidos", "");
        }
    } else {
        $objProducto = new producto();
        $listaProductos = $objProducto->listarProductos();
        $objCategoria = new categoria();
        $listaCategoria = $objCategoria->listarCategoria();
        $objFormGestionarInventario = new formGestionarInventario();
        $objFormGestionarInventario->formGestionarInventarioShow($listaProductos, $listaCategoria);

        $objMensajeSistema = new mensajeSistema();
        $objMensajeSistema->mensajeSistemaShow("Ingrese id o nombre de producto válido", "");
    }
} else if (validarBoton($btnAgregarProducto)) {
    $objControlGestionarInventario = new controlGestionarInventario();
    $objControlGestionarInventario->mostrarFormAgregarProducto();
} else if (validarBoton($btnRegistrarProducto)) {
    $nom_producto = $_POST['producto'];
    $descripcion = $_POST['descripcion'];
    $precio = trim($_POST['precio']);
    $stock = trim($_POST['stock']);
    $idcategoria = $_POST['idcategoria'];

    if (verificarCamposProducto($nom_producto, $descripcion, $precio, $stock, $idcategoria)) {
        $objControlGestionarInventario = new controlGestionarInventario();
        $objControlGestionarInventario->registrarProducto($nom_producto, $descripcion, $precio, $stock, $idcategoria);
    } else {
        $objCategoria = new categoria();
        $listaCategoria = $objCategoria->listarCategoria();
        $objFormAgregarProducto = new formAgregarProducto();
        $objFormAgregarProducto->formAgregarProductoShow($listaCategoria);

        $objMensajeSistema = new mensajeSistema();
        $objMensajeSistema->mensajeSistemaShow($mensaje, "");
    }
} else if (validarBoton($btnEditarProducto)) {
    $idProducto = (int) $_POST['idproducto'];
    $objControlGestionarInventario = new controlGestionarInventario();
    $objControlGestionarInventario->mostrarFormEditarProducto($idProducto);
} else if (validarBoton($btnGuardarCambios)) {
    $idProducto = $_POST['idproducto'];
    $nom_producto = $_POST['producto'];
    $descripcion = $_POST['descripcion'];
    $precio = trim($_POST['precio']);
    $stock = trim($_POST['stock']);
    $idcategoria = $_POST['idcategoria'];

    if (verificarCamposProducto($nom_producto, $descripcion, $precio, $stock, $idcategoria)) {
        $objControlGestionarInventario = new controlGestionarInventario();
        $objControlGestionarInventario->editarProducto($idProducto, $nom_producto, $descripcion, $precio, $stock, $idcategoria);
    } else {
        $objProducto = new producto();
        $datosProducto = $objProducto->obtenerDatosProducto($idProducto);
        $objCategoria = new categoria();
        $listaCategoria = $objCategoria->listarCategoria();
        $objFormEditarProducto = new formEditarProducto();
        $objFormEditarProducto->formEditarProductoShow($datosProducto, $listaCategoria);

        $objMensajeSistema = new mensajeSistema();
        $objMensajeSistema->mensajeSistemaShow($mensaje, "");
    }
} else if (validarBoton($btnGenerarReporte)) {
    $objControlGestionarInventario = new controlGestionarInventario();
    $objControlGestionarInventario->generarReporteInventario();
} else {
    header('Location: ../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php');
    exit;
}
