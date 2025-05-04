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
    $title = 'ACUAFISH ADMIN - Clientes';
    require_once __DIR__ . '/../parcials/head.php';
  ?>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php  
    require_once __DIR__ . '/../parcials/navbarAdmin.php';
    ?>
    <div class="container my-4 flex-grow-1">
    <!-- Barra de búsqueda -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" id="busquedaUsuario" class="form-control" placeholder="Buscar usuario por nombre o correo...">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody id="lista_clientes">

            </tbody>
        </table>
    </div>
</div>

    <script type="module" src="../../../herramientas/js/usuario/cerrarSesion.js"></script>
    <script type="module" src="../../../herramientas/js/usuario/admin/usuarios/usuarios.js"></script>
    <?php require_once __DIR__ . '/../parcials/footer.php'; ?>
</body>
</html>