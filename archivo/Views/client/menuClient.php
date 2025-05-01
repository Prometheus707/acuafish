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
            <!-- Ejemplo de producto, puedes repetir o generar dinámicamente -->
            <div class="col producto-card" data-categoria="peces">
                <div class="card h-100">
                    <div class="bg-light" style="height: 150px;"></div>
                    <div class="card-body">
                        <h5 class="card-title">Pez Betta Azul</h5>
                        <p class="card-text">Pez luchador de Siam con colores vibrantes.</p>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">$14.99</span>
                            <button class="btn btn-primary btn-sm">Añadir</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col producto-card" data-categoria="acuarios">
                <div class="card h-100">
                    <div class="bg-light" style="height: 150px;"></div>
                    <div class="card-body">
                        <h5 class="card-title">Acuario 30L</h5>
                        <p class="card-text">Kit completo con filtro e iluminación LED.</p>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">$89.99</span>
                            <button class="btn btn-primary btn-sm">Añadir</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col producto-card" data-categoria="accesorios">
                <div class="card h-100">
                    <div class="bg-light" style="height: 150px;"></div>
                    <div class="card-body">
                        <h5 class="card-title">Planta Acuática</h5>
                        <p class="card-text">Planta viva para decorar tu acuario.</p>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">$8.99</span>
                            <button class="btn btn-primary btn-sm">Añadir</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
     require_once __DIR__ . '/../parcials/footer.php'; 
    ?>
    <script type="module" src="../../../herramientas/js/usuario/client/productos/productos.js"></script>

    <script>
    // Filtrado simple en el frontend
    document.getElementById('categoriaSelect').addEventListener('change', function() {
        const categoria = this.value;
        document.querySelectorAll('.producto-card').forEach(card => {
            if (categoria === 'todas' || card.dataset.categoria === categoria) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
    </script>
</body>
</html>