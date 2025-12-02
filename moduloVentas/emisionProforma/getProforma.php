<?php
include_once "controlEmitirProforma.php";
include_once "../compartidoModuloVentas/mensajeSistema.php";
include_once "formEmitirProforma.php";
include_once("../../modelo/producto.php");
include_once("../../modelo/categoria.php");

session_start();

//Funciones -------------------------------------
function validarBoton($boton)
{
    return (isset($boton));
}

function verificarSesionIniciada()
{
    return isset($_SESSION['usuario']);
}

function verificarCamposVacios($txtBuscarProducto)
{
    return ($txtBuscarProducto != "");
}

function verificarCaracteresEspeciales($txtBuscarProducto)
{
    if (preg_match("/[^a-zA-Z0-9áéíóúÁÉÍÓÚ\s]/", $txtBuscarProducto)) {
        return true;
    } else {
        return false;
    }
}

function verificarExistenciaProductos($listaProductos)
{
    if ($listaProductos) {
        return true;
    } else {
        return false;
    }
}

function crearListaProforma($idProductos, $cantidades, $subtotales)
{
    $listaProforma = [];

    for ($i = 0; $i < count($idProductos); $i++) {
        $listaProforma[$i]["idProducto"] = $idProductos[$i];
        $listaProforma[$i]["cantidad"] = $cantidades[$i];
        $listaProforma[$i]["subtotal"] = $subtotales[$i];
    }

    return $listaProforma;
}

//Declaración de botones -----------------------------------
$btnEmitirProforma = $_POST['btnEmitirProforma'] ?? null;
$btnBuscarProducto = $_POST['btnBuscarProducto'] ?? null;
$btnGenerarProforma = $_POST['btnGenerarProforma'] ?? null;

//Validación de botones -------------------------------------
if (validarBoton($btnEmitirProforma)) {
    if (verificarSesionIniciada()) {
        $objControlEmitirProforma = new controlEmitirProforma();
        $objControlEmitirProforma->listarProductosBD();
    } else {
        header('Location: ../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php');
        exit;
    }
} else if (validarBoton($btnBuscarProducto)) {
    $txtBuscarProducto = strtolower($_POST['txtBuscarProducto']);

    if (verificarCamposVacios($txtBuscarProducto)) {
        if (!verificarCaracteresEspeciales($txtBuscarProducto)) {
            $objControlEmitirProforma = new controlEmitirProforma();
            $objControlEmitirProforma->listarBusquedaProductos($txtBuscarProducto);
        } else {
            $objProducto = new producto();
            $listaProductos = $objProducto->listarProductos();
            $objCategoria = new categoria();
            $listaCategoria = $objCategoria->listarCategoria();
            $objFormEmitirProforma = new formEmitirProforma();
            $objFormEmitirProforma->formEmitirProformaShow($listaProductos, $listaCategoria);

            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Se detectaron caracteres no válidos", "");
        }
    } else {
        $objProducto = new producto();
        $listaProductos = $objProducto->listarProductos();
        $objCategoria = new categoria();
        $listaCategoria = $objCategoria->listarCategoria();
        $objFormEmitirProforma = new formEmitirProforma();
        $objFormEmitirProforma->formEmitirProformaShow($listaProductos, $listaCategoria);

        $objMensajeSistema = new mensajeSistema();
        $objMensajeSistema->mensajeSistemaShow("Ingrese id o nombre de producto válido", "");
    }
} else if (validarBoton($btnGenerarProforma)) {
    $idProductos = $_POST["idProducto"] ?? null;

    if (verificarExistenciaProductos($idProductos)) {
        $cantidades = $_POST["cantidadProducto"];
        $subtotales = $_POST["subTotal"];
        $totalProforma = $_POST["totalProforma"];
        $listaProductos = crearListaProforma($idProductos, $cantidades, $subtotales);
        $objControlEmitirProforma = new controlEmitirProforma();
        $objControlEmitirProforma->emitirProforma($listaProductos, $totalProforma);
    } else {
        $objProducto = new producto();
        $listaProductos = $objProducto->listarProductos();
        $objCategoria = new categoria();
        $listaCategoria = $objCategoria->listarCategoria();
        $objFormEmitirProforma = new formEmitirProforma();
        $objFormEmitirProforma->formEmitirProformaShow($listaProductos, $listaCategoria);

        $objMensajeSistema = new mensajeSistema();
        $objMensajeSistema->mensajeSistemaShow("No se ha agregado ningún producto", "");
    }
} else {
    header('Location: ../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php');
    exit;
}
