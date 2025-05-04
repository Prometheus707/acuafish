<?php
include_once __DIR__ . '/../Models/PedidoModel.php';
include_once __DIR__. '/../Models/CarritoModel.php';
class PedidoService{
    private $pedidoModel;
    private $carritoModel;

    public function __construct($pdo) {
        $this->pedidoModel = new PedidoModel($pdo);
        $this->carritoModel = new CarritoModel($pdo);
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

    public function realizarPedido($request) {
        session_start();
        // Obtener el id del cliente
        $idcliente = $_SESSION['id'];
        if(!$idcliente){
            throw new Exception('No se ha iniciado sesión');
        }

        // Verificar si el carrito está pendiente
        $carritoNoPendiente = $this->carritoModel->buscarCarritoPendiente($idcliente);
        if(!$carritoNoPendiente){
            throw new Exception('No hay carrito pendiente');
        }
        $carritoNoPendiente = $carritoNoPendiente['idCarrito'];

        //Obtener los productos del carrito
        $itemsCarrito = $this->carritoModel->listarItemsCarrito($carritoNoPendiente);
        if(!$itemsCarrito || count($itemsCarrito) === 0) {
            throw new Exception('El carrito está vacío');
        }

        // Calcular el total del pedido
        $total = 0;
        foreach($itemsCarrito as $item) {
            $subtotal = $item['cantidad'] * $item['precio_unitario'];
            $total += $subtotal;
        }

        // Crear el pedido
        $idPedido = $this->pedidoModel->crearPedido($idcliente, $total);
        if(!$idPedido){
            throw new Exception('No se pudo crear el pedido');
        }

        // Crear detalle del pedido
        foreach($itemsCarrito as $item) {
            $subtotal = $item['cantidad'] * $item['precio_unitario'];
            $this->pedidoModel->agregarDetallePedido(
                $idPedido,
                $item['id_producto_fk'],
                isset($item['nombre_producto']) ? $item['nombre_producto'] : '', // Si tienes el nombre, úsalo
                $item['cantidad'],
                $subtotal,
                $item['precio_unitario']
            );
        }
        // carrito completado
        $this->carritoModel->cambiarEstadoCarrito($carritoNoPendiente, 2);
        return $idPedido;
    }
}
?> 