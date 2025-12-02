<?php
include_once('conexion.php');
class producto extends conexion
{
    public function listarProductos()
    {
        $conexion = $this->conectar();
        $sql = "SELECT * FROM producto";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $listaProductos = $resultado->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $this->desconectar();
        return $listaProductos;
    }

    public function obtenerProductosBusqueda($txtBuscarProducto)
    {
        $terminos = explode(' ', $txtBuscarProducto);
        $condiciones = [];
        $parametros = [];
        $tipos = '';

        foreach ($terminos as $termino) {
            $condiciones[] = "(idproducto LIKE ? OR LOWER(producto) LIKE ? OR LOWER(descripcion) LIKE ?)";
            $paramTerm = '%' . $termino . '%';
            $parametros[] = $paramTerm;
            $parametros[] = $paramTerm;
            $parametros[] = $paramTerm;
            $tipos .= 'sss';
        }

        $sql = "SELECT * FROM producto WHERE " . implode(' AND ', $condiciones);
        $conexion = $this->conectar();
        $stmt = $conexion->prepare($sql);

        $stmt->bind_param($tipos, ...$parametros);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $listaProductos = $resultado->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $this->desconectar();
        return $listaProductos;
    }

    public function obtenerDatosProducto($idProducto)
    {
        $conexion = $this->conectar();
        $sql = "SELECT * FROM producto WHERE idproducto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idProducto);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $datosProducto = $resultado->fetch_assoc();
        $stmt->close();
        $this->desconectar();
        return $datosProducto;
    }
    public function verificarProductoExistente($nom_producto)
    {
        $conexion = $this->conectar();
        $sql = "SELECT * FROM producto WHERE producto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $nom_producto);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $producto = $resultado->fetch_assoc();
        $stmt->close();
        $this->desconectar();
        return $producto;
    }

    public function agregarProducto($nom_producto, $descripcion, $precio, $stock, $idcategoria)
    {
        $conexion = $this->conectar();
        $sql = "INSERT INTO producto (producto, descripcion, precio, stock, idcategoria) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssdii", $nom_producto, $descripcion, $precio, $stock, $idcategoria);
        $resultado = $stmt->execute();
        $stmt->close();
        $this->desconectar();
        return $resultado;
    }

    public function actualizarProducto($idProducto, $nom_producto, $descripcion, $precio, $stock, $idcategoria)
    {
        $conexion = $this->conectar();
        $sql = "UPDATE producto SET producto = ?, descripcion = ?, precio = ?, stock = ?, idcategoria = ? WHERE idproducto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssdiii", $nom_producto, $descripcion, $precio, $stock, $idcategoria, $idProducto);
        $resultado = $stmt->execute();
        $stmt->close();
        $this->desconectar();
        return $resultado;
    }
}
