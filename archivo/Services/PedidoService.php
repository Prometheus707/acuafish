<?php
include_once __DIR__ . '/../Models/PedidoModel.php';
include_once __DIR__. '/../Models/CarritoModel.php';
include_once __DIR__. '/../Models/ProductoModel.php';
class PedidoService{
    private $pedidoModel;
    private $carritoModel;
    private $productoModel;

    public function __construct($pdo) {
        $this->pedidoModel = new PedidoModel($pdo);
        $this->carritoModel = new CarritoModel($pdo);
        $this->productoModel = new ProductoModel($pdo);
    }

    public function listarPedidos() {
        $resultados = $this->pedidoModel->listarPedidos();
        if (!$resultados) {
            throw new Exception('No se pudieron obtener los pedidos con detalles');
        }

        $pedidos = [];
        foreach ($resultados as $fila) {
            $idPedido = $fila['id_pedido'];
            if (!isset($pedidos[$idPedido])) {
                $pedidos[$idPedido] = [
                    'id_pedido' => $fila['id_pedido'],
                    'nombre_usuario' => $fila['nombre_usuario'],
                    'correo_usuario' => $fila['correo_usuario'],
                    'estado_pedido' => $fila['estado_pedido'],
                    'total' => $fila['total'],
                    'fecha_pedido' => $fila['fecha_pedido'],
                    'detalles' => []
                ];
            }
            $pedidos[$idPedido]['detalles'][] = [
                'id_detalle_pedido' => $fila['id_detalle_pedido'],
                'id_producto_detalle' => $fila['id_producto_detalle'],
                'nombre_producto' => $fila['nombre_producto'],
                'cantidad' => $fila['cantidad'],
                'subtotal' => $fila['subtotal'],
                'costo_unitario' => $fila['costo_unitario']
            ];
        }
        return $pedidos;    
    }

    // public function realizarPedido($request) {
    //     session_start();
    //     // Obtener el id del cliente
    //     $idcliente = $_SESSION['id'];
    //     if(!$idcliente){
    //         throw new Exception('No se ha iniciado sesión');
    //     }

    //     // Verificar si el carrito está pendiente
    //     $carritoNoPendiente = $this->carritoModel->buscarCarritoPendiente($idcliente);
    //     if(!$carritoNoPendiente){
    //         throw new Exception('No hay carrito pendiente');
    //     }
    //     $carritoNoPendiente = $carritoNoPendiente['idCarrito'];

    //     //Obtener los productos del carrito
    //     $itemsCarrito = $this->carritoModel->listarItemsCarrito($carritoNoPendiente);
    //     if(!$itemsCarrito || count($itemsCarrito) === 0) {
    //         throw new Exception('El carrito está vacío');
    //     }

    //     // Calcular el total del pedido
    //     $total = 0;
    //     foreach($itemsCarrito as $item) {
    //         $subtotal = $item['cantidad'] * $item['precio_unitario'];
    //         $total += $subtotal;
    //     }

    //     // Crear el pedido
    //     $idPedido = $this->pedidoModel->crearPedido($idcliente, $total);
    //     if(!$idPedido){
    //         throw new Exception('No se pudo crear el pedido');
    //     }
    //     // Crear detalle del pedido
    //     foreach($itemsCarrito as $item) {
    //         $subtotal = $item['cantidad'] * $item['precio_unitario'];
    //         $this->pedidoModel->agregarDetallePedido(
    //             $idPedido,
    //             $item['id_producto_fk'],
    //             isset($item['nombre_producto']) ? $item['nombre_producto'] : '', // Si tienes el nombre, úsalo
    //             $item['cantidad'],
    //             $subtotal,
    //             $item['precio_unitario']
    //         );
    //         $this->productoModel->actualizarStock($item['id_producto_fk'], $item['cantidad']);
    //     }
    //     // carrito completado
    //     $this->carritoModel->cambiarEstadoCarrito($carritoNoPendiente, 2);
    //     return $idPedido;
    // }

    public function realizarPedido($request) {
        file_put_contents('webhook_log.txt', "Entrando a PedidoService->realizarPedido\n", FILE_APPEND);

        // Si viene id_carrito en el request, úsalo directamente (caso webhook)
        if (isset($request['id_carrito'])) {
            file_put_contents('webhook_log.txt', "Modo webhook, id_carrito: " . $request['id_carrito'] . "\n", FILE_APPEND);
            $carritoNoPendiente = $request['id_carrito'];
            // Buscar el id del cliente a partir del carrito
            $carritoInfo = $this->carritoModel->buscarCarritoPorId($carritoNoPendiente);
            if (!$carritoInfo || !isset($carritoInfo['idClienteCarrito'])) {
                file_put_contents('webhook_log.txt', "No se encontró el carrito o el cliente\n", FILE_APPEND);
                throw new Exception('No se encontró el carrito o el cliente');
            }
            $idcliente = $carritoInfo['idClienteCarrito'];
        } else {
            file_put_contents('webhook_log.txt', "Modo sesión usuario\n", FILE_APPEND);
            session_start();
            $idcliente = $_SESSION['id'];
            if(!$idcliente){
                file_put_contents('webhook_log.txt', "No se ha iniciado sesión\n", FILE_APPEND);
                throw new Exception('No se ha iniciado sesión');
            }
            $carritoNoPendiente = $this->carritoModel->buscarCarritoPendiente($idcliente);
            if(!$carritoNoPendiente){
                file_put_contents('webhook_log.txt', "No hay carrito pendiente\n", FILE_APPEND);
                throw new Exception('No hay carrito pendiente');
            }
            $carritoNoPendiente = $carritoNoPendiente['idCarrito'];
        }

        //Obtener los productos del carrito
        $itemsCarrito = $this->carritoModel->listarItemsCarrito($carritoNoPendiente);
        if(!$itemsCarrito || count($itemsCarrito) === 0) {
            file_put_contents('webhook_log.txt', "El carrito está vacío\n", FILE_APPEND);
            throw new Exception('El carrito está vacío');
        }

        // Calcular el total del pedido
        $total = 0;
        foreach($itemsCarrito as $item) {
            $subtotal = $item['cantidad'] * $item['precio_unitario'];
            $total += $subtotal;
        }
        file_put_contents('webhook_log.txt', "Total calculado: $total\n", FILE_APPEND);

        // Crear el pedido
        $idPedido = $this->pedidoModel->crearPedido($idcliente, $total);
        if(!$idPedido){
            file_put_contents('webhook_log.txt', "No se pudo crear el pedido\n", FILE_APPEND);
            throw new Exception('No se pudo crear el pedido');
        }
        file_put_contents('webhook_log.txt', "Pedido creado: $idPedido\n", FILE_APPEND);

        // Crear detalle del pedido
        foreach($itemsCarrito as $item) {
            $subtotal = $item['cantidad'] * $item['precio_unitario'];
            $this->pedidoModel->agregarDetallePedido(
                $idPedido,
                $item['id_producto_fk'],
                isset($item['nombre_producto']) ? $item['nombre_producto'] : '',
                $item['cantidad'],
                $subtotal,
                $item['precio_unitario']
            );
            $this->productoModel->actualizarStock($item['id_producto_fk'], $item['cantidad']);
        }
        file_put_contents('webhook_log.txt', "Detalles y stock actualizados\n", FILE_APPEND);

        // carrito completado
        $this->carritoModel->cambiarEstadoCarrito($carritoNoPendiente, 2);
        file_put_contents('webhook_log.txt', "Carrito cambiado a completado\n", FILE_APPEND);

        return $idPedido;
    }

}
?>