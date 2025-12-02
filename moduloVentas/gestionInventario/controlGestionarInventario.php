<?php
include_once("../../modelo/producto.php");
include_once("../../modelo/categoria.php");
include_once("formGestionarInventario.php");
include_once("formAgregarProducto.php");
include_once("formEditarProducto.php");
include_once("../compartidoModuloVentas/mensajeSistema.php");
include_once("../../assets/fpdf/fpdf.php");
include_once("../../assets/tfpdf/tfpdf.php");

class controlGestionarInventario
{
    public function listarProductosBD()
    {
        $objProducto = new producto();
        $listaProductos = $objProducto->listarProductos();
        $objCategoria = new categoria();
        $listaCategoria = $objCategoria->listarCategoria();
        $objFormGestionarInventario = new formGestionarInventario();
        $objFormGestionarInventario->formGestionarInventarioShow($listaProductos, $listaCategoria);
    }

    public function listarBusquedaProductos($txtBuscarProducto)
    {
        $objProducto = new producto();
        $listaProductos = $objProducto->obtenerProductosBusqueda($txtBuscarProducto);
        $objCategoria = new categoria();
        $listaCategoria = $objCategoria->listarCategoria();
        $objFormGestionarInventario = new formGestionarInventario();
        $objFormGestionarInventario->formGestionarInventarioShow($listaProductos, $listaCategoria);
    }

    public function mostrarFormAgregarProducto()
    {
        $objCategoria = new categoria();
        $listaCategoria = $objCategoria->listarCategoria();
        $objFormAgregarProducto = new formAgregarProducto();
        $objFormAgregarProducto->formAgregarProductoShow($listaCategoria);
    }

    public function registrarProducto($nom_producto, $descripcion, $precio, $stock, $idcategoria)
    {
        $objProducto = new producto();
        $resultado = $objProducto->verificarProductoExistente($nom_producto);
        if ($resultado !== null) {
            $this->mostrarFormAgregarProducto();
            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("El producto ya se encuentra registrado", "");
        } else {
            $resultado = $objProducto->agregarProducto($nom_producto, $descripcion, $precio, $stock, $idcategoria);
            if ($resultado) {
                $objMensajeSistema = new mensajeSistema();
                $objMensajeSistema->mensajeSistemaShow("Proforma generada con éxito", "../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php", "systemOut", true);
            } else {
                $objMensajeSistema = new mensajeSistema();
                $objMensajeSistema->mensajeSistemaShow("Error al registrar producto", "../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php", "systemOut", true);
            }
        }
    }

    public function mostrarFormEditarProducto($idProducto)
    {
        $objProducto = new producto();
        $datosProducto = $objProducto->obtenerDatosProducto($idProducto);
        $objCategoria = new categoria();
        $listaCategoria = $objCategoria->listarCategoria();
        $objFormEditarProducto = new formEditarProducto();
        $objFormEditarProducto->formEditarProductoShow($datosProducto, $listaCategoria);
    }

    public function editarProducto($idProducto, $nom_producto, $descripcion, $precio, $stock, $idcategoria)
    {
        $objProducto = new producto();
        $resultado = $objProducto->actualizarProducto($idProducto, $nom_producto, $descripcion, $precio, $stock, $idcategoria);
        if ($resultado) {
            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("El producto fue editado correctamente", "../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php", "systemOut", true);
        } else {
            $objMensajeSistema = new mensajeSistema();
            $objMensajeSistema->mensajeSistemaShow("Error al editar producto", "../../moduloSeguridad/autenticacionUsuario/prePanelPrincipalUsuario.php", "systemOut", true);
        }
    }

    function calcularLineas($ancho, $texto)
    {
        // $ancho es el ancho de la celda
        // $texto es el texto a ajustar
        global $pdf; // Asegúrate de tener acceso al objeto $pdf
        $anchoTexto = $pdf->GetStringWidth($texto);
        $numLineas = ceil($anchoTexto / $ancho);
        return $numLineas;
    }

    public function generarReporteInventario()
    {
        $objProducto = new producto();
        $listaProductos = $objProducto->listarProductos();
        $objCategoria = new categoria();
        $listaCategoria = $objCategoria->listarCategoria();
        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");
        $pdf = new tFPDF();
        $pdf->AddPage();
        $pdf->AddFont('DejaVu', 'B', 'DejaVuSans.ttf', true);
        $pdf->SetFont('DejaVu', 'B', 16);
        $pdf->Cell(190, 10, 'Reporte de Inventario', 0, 1, 'C');
        $pdf->SetFont('DejaVu', 'B', 10); // Cambiar la fuente para fecha y hora
        $pdf->Cell(190, 10, "Fecha: $fecha, Hora: $hora", 0, 1, 'C');
        $pdf->SetFont('DejaVu', 'B', 10);
        $pdf->Cell(10, 8, 'ID', 1, 0, 'C');
        $pdf->Cell(50, 8, 'Producto', 1, 0, 'C');
        $pdf->Cell(70, 8, 'Descripcion', 1, 0, 'C');
        $pdf->Cell(15, 8, 'Precio', 1, 0, 'C');
        $pdf->Cell(15, 8, 'Stock', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Categoria', 1, 1, 'C');
        $pdf->AddFont('DejaVu', 'B', 'DejaVuSans.ttf', true);
        $pdf->SetFont('DejaVu', 'B', 8);
        $categoriasPorId = [];
        foreach ($listaCategoria as $categoria) {
            $categoriasPorId[$categoria['idcategoria']] = $categoria['categoria'];
        }
        foreach ($listaProductos as $producto) {
            $descripcion = $producto['descripcion'];
            $num_lineas = ceil($pdf->GetStringWidth($descripcion) / 70); // Asumiendo 70 de ancho como en MultiCell
            $altura_celda = $num_lineas * 5; // Asumiendo 5 de altura por línea como en MultiCell
            $pdf->Cell(10, $altura_celda, $producto['idproducto'], 1, 0, 'C');
            $pdf->Cell(50, $altura_celda, $producto['producto'], 1, 0, 'C');

            // Ajuste de texto para descripción larga
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $pdf->MultiCell(70, 5, $descripcion, 1, 'C');
            $pdf->SetXY($x + 70, $y); // Restablecer la posición para la siguiente celda

            $pdf->Cell(15, $altura_celda, $producto['precio'], 1, 0, 'C');
            $pdf->Cell(15, $altura_celda, $producto['stock'], 1, 0, 'C');
            $pdf->Cell(30, $altura_celda, isset($categoriasPorId[$producto['idcategoria']]) ? $categoriasPorId[$producto['idcategoria']] : 'null', 1, 1, 'C');
        }
        $pdf->Output('reporte_inventario.pdf', 'I');
    }
}
