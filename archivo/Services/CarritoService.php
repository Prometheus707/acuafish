<?php
include_once __DIR__ . '/../Models/CarritoModel.php';
include_once __DIR__ . '/../Models/ProductoModel.php';

class CarritoService {
    private $carritoModel;
    private $productoModel;

    public function __construct($pdo) {
        $this->carritoModel = new CarritoModel($pdo);
        $this->productoModel = new ProductoModel($pdo);
    }

    public function disminuirCarrito($request){
        session_start();
        if (!isset($_SESSION['id'])) {
            throw new Exception("No se ha iniciado sesión.");
        }
        
        $idCliente = $_SESSION['id'];
        $idProducto = $request['id_producto'];
        
        // Buscar carrito pendiente
        $carrito = $this->carritoModel->buscarCarritoPendiente($idCliente);
        if (!$carrito) {
            throw new Exception("No se encontró un carrito activo.");
        }
        
        $idCarrito = $carrito['idCarrito'];
        
        // Verificar si el producto está en el carrito
        $item = $this->carritoModel->buscarItemEnCarrito($idCarrito, $idProducto);
        if (!$item) {
            throw new Exception("El producto no está en el carrito.");
        }
        
        // Disminuir cantidad o eliminar el producto del carrito
        if ($item['cantidad'] > 1) {
            $nuevaCantidad = $item['cantidad'] - 1;
            $actualizado = $this->carritoModel->actualizarCantidadProducto($item['id_carrito_item'], $nuevaCantidad);
            if (!$actualizado) {
                throw new Exception("No se pudo actualizar la cantidad del producto en el carrito.");
            }
        } else {
            $eliminado = $this->carritoModel->eliminarProductoDelCarrito($item['id_carrito_item']);
            if (!$eliminado) {
                throw new Exception("No se pudo eliminar el producto del carrito.");
            }
        }
        
        return true;
    }

    public function listarCarrito($request) {
        session_start();
        if (!isset($_SESSION['id'])) {
            throw new Exception("No se ha iniciado sesión.");
        }
        
        $idCliente = $_SESSION['id'];
        $carrito = $this->carritoModel->buscarCarritoPendiente($idCliente);
        if (!$carrito) {
            return []; 
        }
        
        $idCarrito = $carrito['idCarrito'];
        $items = $this->carritoModel->listarItemsCarrito($idCarrito);
        
        return $items;
    }

    public function agregarCarrito($request) {
        
        session_start();
        if (!isset($_SESSION['id'])) {
            throw new Exception("No se ha iniciado sesión.");
        }
        
        $idCliente  = $_SESSION['id'];
        $idProducto = $request['id_producto'];
        $cantidad   = 1;
        
        // Obtener precio del producto
        $precio = $this->productoModel->obtenerPrecioPorId($idProducto);
        if ($precio === false) {
            throw new Exception("No se encontró el precio del producto.");
        }
        
        // Buscar carrito pendiente
        $carrito = $this->carritoModel->buscarCarritoPendiente($idCliente);
        if (!$carrito) {
            $idCarrito = $this->carritoModel->crearCarrito($idCliente);
            if (!$idCarrito) {
                throw new Exception("No se pudo crear el carrito.");
            }
        } else {
            $idCarrito = $carrito['idCarrito'];
        }
        
        // Verificar si el producto ya está en el carrito
        $item = $this->carritoModel->buscarItemEnCarrito($idCarrito, $idProducto);
        if ($item && isset($item['id_carrito_item'])) {
            // Si existe actualiza la cantidad
            $nuevaCantidad = $item['cantidad'] + $cantidad;
            $actualizado = $this->carritoModel->actualizarCantidadProducto($item['id_carrito_item'], $nuevaCantidad);
            if (!$actualizado) {
                throw new Exception("No se pudo actualizar la cantidad del producto en el carrito.");
            }
        } else {
            // Si no existe, lo agrega
            $agregado = $this->carritoModel->agregarProductoAlCarrito($idCarrito, $idProducto, $cantidad, $precio);
            if (!$agregado) {
                throw new Exception("No se pudo agregar el producto al carrito.");
            }
        }
        return true;
    }
}