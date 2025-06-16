<?php
    // class PedidoModel{
    //     private $pdo ;

    //     public function __construct($pdo)
    //     {
    //         $this->pdo= $pdo;
    //     }

    //     public function crearPedido($idCliente, $total, $estado = 1) {
    //         $query = $this->pdo->prepare(
    //             "INSERT INTO pedidos (id_cliente_pedido, estado_pedido, total, fecha_pedido) VALUES (:idCliente, :estado, :total, NOW())"
    //         );
    //         $query->bindParam(':idCliente', $idCliente, \PDO::PARAM_INT);
    //         $query->bindParam(':estado', $estado, \PDO::PARAM_INT);
    //         $query->bindParam(':total', $total);
    //         $query->execute();
    //         return $this->pdo->lastInsertId();
    //     }

    //     public function agregarDetallePedido($idPedido, $idProducto, $nombreProducto, $cantidad, $subtotal, $costoUnitario) {
    //         $query = $this->pdo->prepare(
    //             "INSERT INTO detalle_pedidos (id_pedido_detalle, id_producto_detalle, nombre_producto, cantidad, subtotal, costo_unitario)
    //             VALUES (:idPedido, :idProducto, :nombreProducto, :cantidad, :subtotal, :costoUnitario)"
    //         );
    //         $query->bindParam(':idPedido', $idPedido, \PDO::PARAM_INT);
    //         $query->bindParam(':idProducto', $idProducto, \PDO::PARAM_INT);
    //         $query->bindParam(':nombreProducto', $nombreProducto, \PDO::PARAM_STR);
    //         $query->bindParam(':cantidad', $cantidad, \PDO::PARAM_INT);
    //         $query->bindParam(':subtotal', $subtotal);
    //         $query->bindParam(':costoUnitario', $costoUnitario);
    //         $query->execute();
    //     }

    //     public function listarPedidos($idCliente) {
    //         $query = $this->pdo->prepare(
    //             "SELECT * FROM pedidos WHERE id_cliente_pedido = :idCliente"
    //         );
    //         $query->bindParam(':idCliente', $idCliente, \PDO::PARAM_INT);
    //         $query->execute();
    //         return $query->fetchAll(\PDO::FETCH_ASSOC);
    //     }
    // }
    class PedidoModel{
        private $pdo ;
    
        public function __construct($pdo)
        {
            $this->pdo= $pdo;
        }
    
        public function crearPedido($idCliente, $total, $estado = 1) {
            try {
                $this->pdo->beginTransaction();
                $query = $this->pdo->prepare(
                    "INSERT INTO pedidos (id_cliente_pedido, estado_pedido, total, fecha_pedido) VALUES (:idCliente, :estado, :total, NOW())"
                );
                $query->bindParam(':idCliente', $idCliente, \PDO::PARAM_INT);
                $query->bindParam(':estado', $estado, \PDO::PARAM_INT);
                $query->bindParam(':total', $total);
                $query->execute();
                $lastInsertId = $this->pdo->lastInsertId();
                $this->pdo->commit();
                return $lastInsertId;
            } catch (\PDOException $e) {
                $this->pdo->rollBack();
                error_log("Error al crear pedido: " . $e->getMessage());
                return false;
            }
        }
    
        public function agregarDetallePedido($idPedido, $idProducto, $nombreProducto, $cantidad, $subtotal, $costoUnitario) {
            try {
                $this->pdo->beginTransaction();
                $query = $this->pdo->prepare(
                    "INSERT INTO detalle_pedidos (id_pedido_detalle, id_producto_detalle, nombre_producto, cantidad, subtotal, costo_unitario)
                    VALUES (:idPedido, :idProducto, :nombreProducto, :cantidad, :subtotal, :costoUnitario)"
                );
                $query->bindParam(':idPedido', $idPedido, \PDO::PARAM_INT);
                $query->bindParam(':idProducto', $idProducto, \PDO::PARAM_INT);
                $query->bindParam(':nombreProducto', $nombreProducto, \PDO::PARAM_STR);
                $query->bindParam(':cantidad', $cantidad, \PDO::PARAM_INT);
                $query->bindParam(':subtotal', $subtotal);
                $query->bindParam(':costoUnitario', $costoUnitario);
                $query->execute();
                $this->pdo->commit();
                return true;
            } catch (\PDOException $e) {
                $this->pdo->rollBack();
                error_log("Error al agregar detalle de pedido: " . $e->getMessage());
                return false;
            }
        }
    
        public function listarPedidos() {
            try {
                $query = $this->pdo->prepare(
                    "SELECT pedidos.*, usuarios.nombre AS nombre_usuario, usuarios.email AS correo_usuario, detalle_pedidos.*
                    FROM pedidos
                    INNER JOIN detalle_pedidos ON detalle_pedidos.id_pedido_detalle = pedidos.id_pedido
                    INNER JOIN usuarios ON pedidos.id_cliente_pedido = usuarios.id_usuario"
                ); 
                $query->execute();
                return $query->fetchAll(\PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                error_log("Error al listar pedidos: " . $e->getMessage());
                return false;
            }
        }
    }
?>
