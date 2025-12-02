<?php

include_once ("../../modelo/producto.php");
include_once ("../../modelo/categoria.php");
include_once ("formEmitirProforma.php");
include_once ("../compartidoModuloVentas/mensajeSistema.php");
include_once ("../../modelo/proforma.php");
include_once ("../../modelo/detalle_proforma.php");
class controlEmitirProforma
{
    public function listarProductosBD()
    {
        $objProducto = new producto();
        $listaProductos = $objProducto->listarProductos();
        $objCategoria = new categoria();
        $listaCategoria = $objCategoria->listarCategoria();
        $objFormEmitirProforma = new formEmitirProforma();
        $objFormEmitirProforma->formEmitirProformaShow($listaProductos, $listaCategoria);
    }

    public function listarBusquedaProductos($txtBuscarProducto)
    {
        $objProducto = new producto();
        $listaProductos = $objProducto->obtenerProductosBusqueda($txtBuscarProducto);
        $objCategoria = new categoria();
        $listaCategoria = $objCategoria->listarCategoria();
        $objFormEmitirProforma = new formEmitirProforma();
        $objFormEmitirProforma->formEmitirProformaShow($listaProductos, $listaCategoria);
    }

    public function emitirProforma($listaProductos, $totalProforma)
    {
        $objMensajeSistema = new mensajeSistema();
        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");
        $idUsuario = $_SESSION["idusuario"];
        $objProforma = new proforma();
        $idProforma = $objProforma->insertarProforma($idUsuario, $fecha, $hora, $totalProforma);
        $objDetalleProforma = new detalle_proforma();
        foreach ($listaProductos as $listaProducto) {
            $idProducto = $listaProducto["idProducto"];
            $cantidad = $listaProducto["cantidad"];
            $subtotal = $listaProducto["subtotal"];
            $respuesta = $objDetalleProforma->registrarDetalleProforma($idProforma, $idProducto, $cantidad, $subtotal);
        }
        if ($respuesta) {
            $objMensajeSistema->mensajeSistemaShow("Proforma generada con éxito", "../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php", "systemOut", true);
        } else {
            $objMensajeSistema->mensajeSistemaShow("Oops! Parece que algo salió mal.", "../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php", "systemOut");
        }
    }
}
