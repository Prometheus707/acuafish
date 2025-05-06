<?php
class ProductoModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function registrarProducto($request) {
        try {
            $this->pdo->beginTransaction();
            $query = $this->pdo->prepare("
                INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen_url)
                VALUES (:nombre, :descripcion, :precio, :stock, :categoria_id, :imagen_url)
            ");
            $query->bindParam(':nombre', $request['nombre'], PDO::PARAM_STR);
            $query->bindParam(':descripcion', $request['descripcion'], PDO::PARAM_STR);
            $query->bindParam(':precio', $request['precio']);
            $query->bindParam(':stock', $request['stock'], PDO::PARAM_INT);
            $query->bindParam(':categoria_id', $request['categoria'], PDO::PARAM_INT);
            $query->bindParam(':imagen_url', $request['imagen_url'], PDO::PARAM_STR);
            $query->execute();
            $producto_id = $this->pdo->lastInsertId();
            switch ($request['categoria']) {
                case "1": // Peces
                    $query = $this->pdo->prepare("
                        INSERT INTO peces (producto_id, especie, tipo_pez_fk)
                        VALUES (:producto_id, :especie, :tipo_pez_fk)
                    ");
                    $query->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
                    $query->bindParam(':especie', $request['especie'], PDO::PARAM_STR);
                    $query->bindParam(':tipo_pez_fk', $request['tipo_pez'], PDO::PARAM_INT);
                    $query->execute();
                    break;
                case "3": // Accesorios
                    $query = $this->pdo->prepare("
                        INSERT INTO accesorios (producto_id, potencia_w, material, tipo_accesorio_fk)
                        VALUES (:producto_id, :potencia_w, :material, :tipo_accesorio)
                    ");
                    $query->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
                    $query->bindParam(':potencia_w', $request['potencia_w'], PDO::PARAM_INT);
                    $query->bindParam(':material', $request['material'], PDO::PARAM_STR);
                    $query->bindParam(':tipo_accesorio', $request['tipo_accesorio'], PDO::PARAM_INT);
                    $query->execute();
                    break;
                case "2": // Acuarios
                    $query = $this->pdo->prepare("
                        INSERT INTO acuarios (producto_id, volumen_litros, dimensiones, material_acuario)
                        VALUES (:producto_id, :volumen_litros, :dimensiones, :material_acuario)
                    ");
                    $query->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
                    $query->bindParam(':volumen_litros', $request['volumen_litros']);
                    $query->bindParam(':dimensiones', $request['dimensiones'], PDO::PARAM_STR);
                    $query->bindParam(':material_acuario', $request['material_acuario'], PDO::PARAM_STR);
                    $query->execute();
                    break;
            }
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Registro de producto fallido: " . $e->getMessage());
            throw $e;
        }
    }

    public function listarProductos($categoria = null) {
        try {
            if ($categoria) {
                $query = $this->pdo->prepare("
                  SELECT p.* , c.nombre AS categoria_nombre 
                  FROM productos p 
                  INNER JOIN categorias c ON p.categoria_id = c.id_categoria 
                  WHERE p.categoria_id = :categoria_id
                ");
                $query->bindParam(':categoria_id', $categoria, PDO::PARAM_INT);
                $query->execute();
            } else {
                $query = $this->pdo->prepare("
                    SELECT p.*, c.nombre as categoria_nombre
                    FROM productos p
                    INNER JOIN categorias c ON p.categoria_id = c.id_categoria
                ");
                $query->execute();
            }
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al listar productos: " . $e->getMessage());
            throw $e;
        }
    }

    public function obtenerProducto($productoId) {
        try {
            $query = $this->pdo->prepare("
                SELECT * FROM productos WHERE id_productos = :producto_id
            ");
            $query->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
            $query->execute();
            $producto = $query->fetch(PDO::FETCH_ASSOC);
    
            if (!$producto) return null;
    
            switch ($producto['categoria_id']) {
                case "1": // Peces
                    $q = $this->pdo->prepare("SELECT * FROM peces WHERE producto_id = :producto_id");
                    $q->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
                    $q->execute();
                    $pez = $q->fetch(PDO::FETCH_ASSOC);
                    if ($pez) {
                        $producto['especie'] = $pez['especie'];
                        $producto['tipo_pez_fk'] = $pez['tipo_pez_fk'];
                    }
                    break;
                case "2": // Acuarios
                    $q = $this->pdo->prepare("SELECT * FROM acuarios WHERE producto_id = :producto_id");
                    $q->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
                    $q->execute();
                    $acuario = $q->fetch(PDO::FETCH_ASSOC);
                    if ($acuario) {
                        $producto['volumen_litros'] = $acuario['volumen_litros'];
                        $producto['dimensiones'] = $acuario['dimensiones'];
                        $producto['material_acuario'] = $acuario['material_acuario'];
                    }
                    break;
                case "3": // Accesorios
                    $q = $this->pdo->prepare("SELECT * FROM accesorios WHERE producto_id = :producto_id");
                    $q->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
                    $q->execute();
                    $accesorio = $q->fetch(PDO::FETCH_ASSOC);
                    if ($accesorio) {
                        $producto['potencia_w'] = $accesorio['potencia_w'];
                        $producto['material'] = $accesorio['material'];
                        $producto['tipo_accesorio_id'] = $accesorio['tipo_accesorio_fk'];
                    }
                    break;
            }
    
            return $producto;
        } catch (PDOException $e) {
            error_log("Error al obtener producto: " . $e->getMessage());
            throw $e;
        }
    }

    public function actualizarProducto($request) {
        try {
            $this->pdo->beginTransaction();
            $query = $this->pdo->prepare("
                UPDATE productos SET 
                    nombre = :nombre,
                    descripcion = :descripcion,
                    precio = :precio,
                    stock = :stock,
                    categoria_id = :categoria_id
                WHERE id_productos = :id_producto
            ");
            $query->bindParam(':nombre', $request['nombre'], PDO::PARAM_STR);
            $query->bindParam(':descripcion', $request['descripcion'], PDO::PARAM_STR);
            $query->bindParam(':precio', $request['precio']);
            $query->bindParam(':stock', $request['stock'], PDO::PARAM_INT);
            $query->bindParam(':categoria_id', $request['categoria_id'], PDO::PARAM_INT);
            $query->bindParam(':id_producto', $request['id_producto'], PDO::PARAM_INT);
            $query->execute();
    
            // Actualizar datos específicos según la categoría
            switch ($request['categoria_id']) {
                case "1": // Peces
                    $query = $this->pdo->prepare("
                        UPDATE peces SET 
                            especie = :especie,
                            tipo_pez_fk = :tipo_pez
                        WHERE producto_id = :producto_id
                    ");
                    $query->bindParam(':especie', $request['especie'], PDO::PARAM_STR);
                    $query->bindParam(':tipo_pez', $request['tipo_pez'], PDO::PARAM_INT);
                    $query->bindParam(':producto_id', $request['id_producto'], PDO::PARAM_INT);
                    $query->execute();
                    break;
                case "2": // Acuarios
                    $query = $this->pdo->prepare("
                        UPDATE acuarios SET 
                            volumen_litros = :volumen_litros,
                            dimensiones = :dimensiones,
                            material_acuario = :material_acuario
                        WHERE producto_id = :producto_id
                    ");
                    $query->bindParam(':volumen_litros', $request['volumen_litros']);
                    $query->bindParam(':dimensiones', $request['dimensiones'], PDO::PARAM_STR);
                    $query->bindParam(':material_acuario', $request['material_acuario'], PDO::PARAM_STR);
                    $query->bindParam(':producto_id', $request['id_producto'], PDO::PARAM_INT);
                    $query->execute();
                    break;
                case "3": // Accesorios
                    $query = $this->pdo->prepare("
                        UPDATE accesorios SET 
                            potencia_w = :potencia_w,
                            material = :material,
                            tipo_accesorio_fk = :tipo_accesorio
                        WHERE producto_id = :producto_id
                    ");
                    $query->bindParam(':potencia_w', $request['potencia_w'], PDO::PARAM_INT);
                    $query->bindParam(':material', $request['material'], PDO::PARAM_STR);
                    $query->bindParam(':tipo_accesorio', $request['tipo_accesorio'], PDO::PARAM_INT);
                    $query->bindParam(':producto_id', $request['id_producto'], PDO::PARAM_INT);
                    $query->execute();
                    break;
            }
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Actualización de producto fallida: " . $e->getMessage());
            throw $e;
        }
    }

    public function eliminarProducto($productoId) {
        try {
            $this->pdo->beginTransaction();
            $query = $this->pdo->prepare("SELECT categoria_id FROM productos WHERE id_productos = :producto_id");
            $query->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
            $query->execute();
            $categoriaId = $query->fetchColumn();
            switch ($categoriaId) {
                case "1": // Peces
                    $query = $this->pdo->prepare("DELETE FROM peces WHERE producto_id = :producto_id");
                    break;
                case "2": // Acuarios
                    $query = $this->pdo->prepare("DELETE FROM acuarios WHERE producto_id = :producto_id");
                    break;
                case "3": // Accesorios
                    $query = $this->pdo->prepare("DELETE FROM accesorios WHERE producto_id = :producto_id");
                    break;
            }
            $query->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
            $query->execute();
            // Eliminar el producto general
            $query = $this->pdo->prepare("DELETE FROM productos WHERE id_productos = :producto_id");
            $query->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
            $query->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Eliminación de producto fallida: " . $e->getMessage());
            throw $e;
        }
    }

    public function obtenerPrecioPorId($productoId) {
        try {
            $query = $this->pdo->prepare("SELECT precio FROM productos WHERE id_productos = :producto_id");
            $query->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error al obtener precio: " . $e->getMessage());
            throw $e;
        }
    }
}
?>