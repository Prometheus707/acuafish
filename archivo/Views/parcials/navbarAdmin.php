<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-fish me-2"></i>ACUAFISH ADMIN</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../admin/productos.php">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="admin.html#pedidos">Pedidos</a></li>
                <li class="nav-item"><a class="nav-link" href="admin.html#clientes">Clientes</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user-circle me-2"></i>
                        <?php 
                            $primerNombre = explode(' ', $_SESSION['nombre'])[0]; // Obtener el primer nombre
                            echo $primerNombre; 
                        ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user me-2"></i>Mi Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="fa-solid fa-right-from-bracket me-2"></i>Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>