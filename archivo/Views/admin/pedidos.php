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
    $title = 'ACUAFISH ADMIN - Pedidos';
    require_once __DIR__ . '/../parcials/head.php';
   ?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php  
     require_once __DIR__ . '/../parcials/navbarAdmin.php';
    ?>
    <div class="container my-4 flex-grow-1">
        <!-- Gestión de Pedidos -->
        <section id="pedidos" class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Pedidos</h2>
            </div>
            <!-- Tabla de pedidos -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody id="lista_pedidos">
                        <!-- Aquí se insertarán los pedidos y sus detalles -->
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <script type="module" src="../../../herramientas/js/usuario/admin/pedidos/pedidos.js"></script>
    <script type="module" src="../../../herramientas/js/usuario/cerrarSesion.js"></script>
    <?php require_once __DIR__ . '/../parcials/footer.php'; ?>
</body>
</html>