<?php
include_once("../../modelo/boleta.php");
include_once("../../modelo/detalle_boleta.php");
include_once("formRegistrarDespacho.php");
include_once("formVerDetalleBoleta.php");
include_once("../compartidoModuloVentas/mensajeSistema.php");

class controlRegistrarDespacho
{
    public function listarBoletasBD()
    {
        $objBoleta = new boleta();
        $listaBoletas = $objBoleta->listarBoletas();
        $objFormRegistrarDespacho = new formRegistrarDespacho();
        $objFormRegistrarDespacho->formRegistrarDespachoShow($listaBoletas);
    }

    public function listarBoletasBusqueda($txtBuscarBoleta)
    {
        $objBoleta = new boleta();
        $listaBoletas = $objBoleta->listarBoletasBusqueda($txtBuscarBoleta);
        $objFormRegistrarDespacho = new formRegistrarDespacho();
        $objFormRegistrarDespacho->formRegistrarDespachoShow($listaBoletas);
    }

    public function obtenerDatosDetalleBoleta($idBoleta)
    {
        $objDetalleBoleta = new detalle_boleta();
        $detalleBoleta = $objDetalleBoleta->obtenerDetalleBoleta($idBoleta);
        $objFormVerDetalleBoleta = new formVerDetalleBoleta();
        $objFormVerDetalleBoleta->formVerDetalleBoletaShow($detalleBoleta);
    }

    public function despacharBoleta($idBoleta)
    {
        $objMensajeSistema = new mensajeSistema();
        $objBoleta = new boleta();
        $respuesta = $objBoleta->actualizarBoleta($idBoleta);
        if ($respuesta) {
            $objMensajeSistema->mensajeSistemaShow("Boleta actualizada con éxito", "../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php", "systemOut", true);
        } else {
            $objMensajeSistema->mensajeSistemaShow("Oops! Parece que algo salió mal.", "../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php", "systemOut");
        }
    }
}
