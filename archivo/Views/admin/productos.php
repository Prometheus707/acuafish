<?php 
  session_start();
  if (!isset($_SESSION['id']) || $_SESSION['rol'] != 2) {
    header('Location: ../../../index.php');
    exit;
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <?php  
    $title = 'ACUAFISH ADMIN - Productos';
    require_once __DIR__ . '/../parcials/head.php';
   ?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php  
     require_once __DIR__ . '/../parcials/navbarAdmin.php';
    ?>
    <div class="container my-4 flex-grow-1">
        <!-- Gestión de Productos -->
        <section id="productos" class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Productos</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" id="abrirModalAProducto" data-bs-target="#modalNuevoProducto">
                    <i class="fa-solid fa-plus me-1"></i> Nuevo Producto
                </button>
            </div>
            <div class="mb-3">
                    <label for="categoria_id" class="form-label">Categoría:</label>
                    <select class="form-select" id="select_categoria_menu" name="select_categoria_menu" required>
                    </select>
            </div>
            <!-- Tabla de productos -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="lista_productos">
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    
    <!-- Modal para agregar producto -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btnNuevoProducto"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="productName" class="form-label">Categoria</label>
                            <select class="form-select" id="productCategory">
                                <option>Peces ornamentales</option>
                                <option>Acuarios</option>
                                <option>Accesorios</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productCategory" class="form-label">Categoría</label>
                            <select class="form-select" id="productCategory">
                                <option>comunitarios</option>
                                <option>Limpiadores</option>
                                <option>Agresivos</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productCategory" class="form-label">Especie</label>
                            <select class="form-select" id="productCategory">
                                <option>Peces Tropicales</option>
                                <option>Acuarios</option>
                                <option>Decoraciones</option>
                                <option>Equipamiento</option>
                                <option>Alimentación</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productCategory" class="form-label">Variedad</label>
                            <select class="form-select" id="productCategory">
                                <option>Peces Tropicales</option>
                                <option>Acuarios</option>
                                <option>Decoraciones</option>
                                <option>Equipamiento</option>
                                <option>Alimentación</option>
                            </select>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="productPrice" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="productPrice" step="0.01">
                            </div>
                            <div class="col">
                                <label for="productStock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="productStock">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="productDescription" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="productImage" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="productImage">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar Producto</button>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="../../../herramientas/js/usuario/admin/productos/productos.js"></script>
    <?php require_once __DIR__ . '/../modales/modales-productos.php'; ?>
    <?php require_once __DIR__ . '/../parcials/footer.php'; ?>
</body>
</html>