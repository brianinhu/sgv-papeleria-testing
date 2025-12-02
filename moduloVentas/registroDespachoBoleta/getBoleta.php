<?php
include_once "controlRegistrarDespacho.php";
include_once "../compartidoModuloVentas/mensajeSistema.php";
include_once "formRegistrarDespacho.php";
include_once "formVerDetalleBoleta.php";
include_once("../../modelo/boleta.php");
include_once("../../modelo/detalle_boleta.php");

session_start();

//Funciones -----------------------------
function validarBoton($boton)
{
    if (isset($boton)) {
        return true;
    } else {
        return false;
    }
}

function verificarCamposVacios($txtBuscarBoleta)
{
    return ($txtBuscarBoleta != "");
}

function verificarSoloNúmeros($txtBuscarBoleta)
{
    if (preg_match('/^\d+$/', $txtBuscarBoleta)) {
        return true;
    } else {
        return false;
    }
}

$btnRegistrarDespacho = $_POST['btnRegistrarDespacho'] ?? null;
$btnBuscarBoleta = $_POST['btnBuscarBoleta'] ?? null;
$btnVerDetalleBoleta = $_POST['btnVerDetalleBoleta'] ?? null;
$btnDespacharBoleta = $_POST['btnDespacharBoleta'] ?? null;

if (validarBoton($btnRegistrarDespacho)) {
    $objControlRegistrarDespacho = new controlRegistrarDespacho();
    $objControlRegistrarDespacho->listarBoletasBD();
} else if (validarBoton($btnBuscarBoleta)) {
    $txtBuscarBoleta = $_POST['txtBuscarBoleta'];
    if (verificarCamposVacios($txtBuscarBoleta)) {
        if (verificarSoloNúmeros($txtBuscarBoleta)) {
            $objControlRegistrarDespacho = new controlRegistrarDespacho();
            $objControlRegistrarDespacho->listarBoletasBusqueda($txtBuscarBoleta);
        } else {
            $objBoleta = new boleta();
            $listaBoletas = $objBoleta->listarBoletas();
            $objFormRegistrarDespacho = new formRegistrarDespacho();
            $objFormRegistrarDespacho->formRegistrarDespachoShow($listaBoletas);

            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Ingrese sólo dígitos numéricos", "");
        }
    } else {
        $objBoleta = new boleta();
        $listaBoletas = $objBoleta->listarBoletas();
        $objFormRegistrarDespacho = new formRegistrarDespacho();
        $objFormRegistrarDespacho->formRegistrarDespachoShow($listaBoletas);

        $objMensajeSistema = new mensajeSistema();
        $objMensajeSistema->mensajeSistemaShow("Ingrese número de boleta válido", "");
    }
} else if (validarBoton($btnVerDetalleBoleta)) {
    $idBoleta = (int) $_POST['idBoleta'];
    $objControlRegistrarDespacho = new controlRegistrarDespacho();
    $objControlRegistrarDespacho->obtenerDatosDetalleBoleta($idBoleta);
} else if (validarBoton($btnDespacharBoleta)) {
    $idBoleta = (int) $_POST['idBoleta'];
    $objControlRegistrarDespacho = new controlRegistrarDespacho();
    $objControlRegistrarDespacho->despacharBoleta($idBoleta);
} else {
    header('Location: ../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php');
    exit;
}
