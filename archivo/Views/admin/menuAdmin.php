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
    $title = 'ACUAFISH ADMIN';
    require_once __DIR__ . '/../parcials/head.php';
   ?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php  
     require_once __DIR__ . '/../parcials/navbarAdmin.php';
    ?>
    <div class="container my-4 flex-grow-1">
        <section id="dashboard" class="text-center">
            <h2 class="mb-4">Bienvenido al panel de administración</h2>
            <p class="lead">Desde aquí puedes gestionar los productos, pedidos y clientes de tu tienda AcuaFish.</p>
            <img src="https://cdn-icons-png.flaticon.com/512/616/616494.png" alt="Admin" width="120" class="my-4">
            <div class="alert alert-info mt-4" role="alert">
                Usa el menú superior para acceder a las diferentes secciones de administración.
            </div>
        </section>
    </div>
    <?php 
     require_once __DIR__ . '/../parcials/footer.php'; 
    ?>
    <script type="module" src="../../../herramientas/js/usuario/cerrarSesion.js"></script>
</body>
</html>