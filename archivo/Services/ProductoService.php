<?php
 require_once __DIR__ . '/../Models/ProductoModel.php';
 class ProductoService {
    private $ProductoModel;

    public function __construct($pdo) {
        $this->ProductoModel = new ProductoModel($pdo);
    }

    public function registrarProducto($request) {
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = uniqid() . '_' . basename($_FILES['imagen']['name']);
            $rutaDestino = __DIR__ . '../../uploads/' . $nombreArchivo; 
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                $request['imagen_url'] = '/uploads/' . $nombreArchivo;
            } else {
                throw new Exception("Error al guardar la imagen.");
            }
        } else {
            $request['imagen_url'] = '';
        }
    
        $this->validarRegistroProducto($request);

        $resultado = $this->ProductoModel->registrarProducto($request);
        if ($resultado) {
            return "Producto registrado con éxito";
        } else {
            throw new Exception("Error al registrar producto");
        }
    }

    private function validarRegistroProducto($request) {
        $generales = ['nombre', 'categoria', 'precio', 'stock', 'descripcion'];
        $porCategoria = [
            '1' => ['especie', 'tipo_pez'], // Peces
            '3' => ['tipo_accesorio', 'material', 'potencia_w'], // Accesorios
            '2' => ['volumen_litros', 'dimensiones', 'material_acuario'], // Acuarios
        ];
    
        foreach ($generales as $campo) {
            if (!isset($request[$campo]) || trim($request[$campo]) === '') {
                throw new Exception("El campo '$campo' es obligatorio.");
            }
        }
    
        $categoria = $request['categoria'];
        if (isset($porCategoria[$categoria])) {
            foreach ($porCategoria[$categoria] as $campo) {
                if (!isset($request[$campo]) || trim($request[$campo]) === '') {
                    throw new Exception("El campo '$campo' es obligatorio para esta categoría.");
                }
            }
        }
    }

    public function listarProductos($request) {
        $categoria = $request['categoriaId'] ?? null;
        $productos = $this->ProductoModel->listarProductos($categoria);
        return $productos;
    }

    public function obtenerProducto($request) {
        $productoId = $request['idProductoTraer'] ?? null;
        if (!$productoId) {
            throw new Exception("ID de producto no especificado.");
        }
        $producto = $this->ProductoModel->obtenerProducto($productoId);
        if (!$producto) {
            throw new Exception("Producto no encontrado.");
        }
        return $producto;
    }
 }
?> 