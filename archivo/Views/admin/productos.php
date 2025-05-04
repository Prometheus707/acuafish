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
    <script type="module" src="../../../herramientas/js/usuario/admin/productos/productos.js"></script>
    <script type="module" src="../../../herramientas/js/usuario/cerrarSesion.js"></script>
    <?php require_once __DIR__ . '/../modales/modales-productos.php'; ?>
    <?php require_once __DIR__ . '/../parcials/footer.php'; ?>
</body>
</html>