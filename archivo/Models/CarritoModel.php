<?php
class CarritoModel{
    private $pdo ;

    public function __construct($pdo) {
        $this->pdo= $pdo;
    }

    // Eliminar producto del carrito
    public function eliminarProductoDelCarrito($idCarritoItem){
        try{
            $query = $this->pdo->prepare("DELETE FROM carrito_item WHERE id_carrito_item = :idCarritoItem");
            $query->bindParam(':idCarritoItem', $idCarritoItem);
            return $query->execute();
        }catch(PDOException $e){
            return false; 
        }
    }

    // Listar items del carrito
    public function listarItemsCarrito($idCarrito){
        try{
            $query = $this->pdo->prepare("SELECT *, productos.nombre AS nombre_producto FROM carrito_item INNER JOIN
            productos ON carrito_item.id_producto_fk = productos.id_productos WHERE id_carrito_fk = :idCarrito");
            $query->bindParam(':idCarrito', $idCarrito);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            return false; 
        }
    }

    // Buscar carrito pendiente (estado 1 = Activo)
    public function buscarCarritoPendiente($idCliente){
        try{
            $query = $this->pdo->prepare("SELECT idCarrito FROM carritos WHERE idClienteCarrito = :idCliente AND estado = 1");
            $query->bindParam(':idCliente', $idCliente);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            return false; 
        }
    }

    // Crear carrito nuevo (estado 1 = Activo)
    public function crearCarrito($idCliente){
        try{
            $estado = 1; // Activo
            $query = $this->pdo->prepare("INSERT INTO carritos (idClienteCarrito, estado) VALUES (:idCliente, :estado)");
            $query->bindParam(':idCliente', $idCliente);
            $query->bindParam(':estado', $estado);
            if($query->execute()){
                return $this->pdo->lastInsertId();
            }
        }catch(PDOException $e){
            return false;
        }
    }

    // Buscar si el producto ya está en el carrito
    public function buscarItemEnCarrito($idCarrito, $idProducto) {
        try {
            $query = $this->pdo->prepare("SELECT * FROM carrito_item WHERE id_carrito_fk = :idCarrito AND id_producto_fk = :idProducto");
            $query->bindParam(':idCarrito', $idCarrito);
            $query->bindParam(':idProducto', $idProducto);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return false;
        }
    }

    // Actualizar cantidad de un producto en el carrito
    public function actualizarCantidadProducto($idCarritoItem, $nuevaCantidad) {
        try {
            $query = $this->pdo->prepare("UPDATE carrito_item SET cantidad = :cantidad WHERE id_carrito_item = :idCarritoItem");
            $query->bindParam(':cantidad', $nuevaCantidad);
            $query->bindParam(':idCarritoItem', $idCarritoItem);
            return $query->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    // Agregar producto al carrito (nuevo item)
    public function agregarProductoAlCarrito($idCarrito, $idProducto, $cantidad, $precio){
        try{
            $query = $this->pdo->prepare("INSERT INTO carrito_item (id_carrito_fk, id_producto_fk, cantidad, precio_unitario) VALUES (:idCarrito, :idProducto, :cantidad, :precio)");
            $query->bindParam(':idCarrito', $idCarrito);
            $query->bindParam(':idProducto', $idProducto);
            $query->bindParam(':cantidad', $cantidad);
            $query->bindParam(':precio', $precio);
            return $query->execute();
        }catch(PDOException $e){
            return false;
        }
    }

    public function cambiarEstadoCarrito($idCarrito, $estado){
        try{
            $query = $this->pdo->prepare("UPDATE carritos SET estado = :estado WHERE idCarrito = :idCarrito");
            $query->bindParam(':idCarrito', $idCarrito);
            $query->bindParam(':estado', $estado);
            return $query->execute();   
        }
        catch(PDOException $e){
            return false;
        }
    }
}
?>