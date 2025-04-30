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
    $title = 'ACUAFISH ADMIN';
    require_once __DIR__ . '/../parcials/head.php';
   ?>
</head>
<body>
    <?php  
     require_once __DIR__ . '/../parcials/navbarClient.php';
    ?>
    <!-- Contenido principal -->
    <div class="container my-4">
        <!-- Carrusel simplificado -->
        <div id="mainCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="bg-primary text-white p-5 text-center rounded">
                        <h2>Bienvenido a ACUAFISH</h2>
                        <p>Tu tienda especializada en peces y acuarios</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="bg-info text-white p-5 text-center rounded">
                        <h2>Nuevos Peces Tropicales</h2>
                        <p>Descubre nuestra nueva colección</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Productos destacados simplificados -->
        <h2 class="mb-3">Productos Destacados</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Producto 1 -->
            <div class="col">
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
            
            <!-- Producto 2 -->
            <div class="col">
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
            
            <!-- Producto 3 -->
            <div class="col">
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
</body>
</html>
