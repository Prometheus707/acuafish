<?php 
  session_start();
  if (!isset($_SESSION['id']) || $_SESSION['rol'] != 1) {
    header('Location: ../../../index.php');
    exit;
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <?php  
    $title = 'ACUAFISH CLIENTE';
    require_once __DIR__ . '/../parcials/head.php';
   ?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php  
     require_once __DIR__ . '/../parcials/navbarClient.php';
    ?>
    <div class="container my-4 flex-grow-1">
        <!-- Selector de categorías -->
        <div class="mb-4">
            <label for="categoriaSelectClient" class="form-label fw-bold">Filtrar por categoría:</label>
            <select id="categoriaSelectClient" class="form-select w-auto d-inline-block">
               
            </select>
        </div>

        <!-- Cards de productos -->
        <div id="productosContainer" class="row row-cols-1 row-cols-md-3 g-4">
           
        </div>
         <!-- Modal Carrito -->
         <div class="modal fade" id="modalCarrito" tabindex="-1" aria-labelledby="modalCarritoLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCarritoLabel">Mi Carrito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="carritoContenido">
                    <!-- Aquí se listan los productos del carrito con JS -->
                </div>
                <div class="modal-footer">
                    <a href="carrito.php" class="btn btn-primary">Ver carrito completo</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
            </div>
    </div>
    <?php 
     require_once __DIR__ . '/../parcials/footer.php'; 
    ?>
    <script type="module" src="../../../herramientas/js/usuario/client/productos/productos.js"></script>
    <script type="module" src="../../../herramientas/js/usuario/cerrarSesion.js"></script>

  
</body>
</html>