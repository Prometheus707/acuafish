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
<body>
    <?php  
     require_once __DIR__ . '/../parcials/navbarAdmin.php';
    ?>
    <div class="container my-4">
        <!-- Dashboard -->
        <section id="dashboard" class="mb-5">
            <h2 class="mb-4">Dashboard</h2>
            
            <!-- Tarjetas de estadísticas -->
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Ventas Hoy</h5>
                            <h3>$1,250</h3>
                            <p class="small mb-0">+15% vs ayer</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Pedidos</h5>
                            <h3>8</h3>
                            <p class="small mb-0">2 pendientes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Productos</h5>
                            <h3>124</h3>
                            <p class="small mb-0">5 sin stock</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h5 class="card-title">Clientes</h5>
                            <h3>45</h3>
                            <p class="small mb-0">3 nuevos hoy</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Gestión de Productos -->
        <section id="productos" class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Productos</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fa-solid fa-plus me-1"></i> Nuevo Producto
                </button>
            </div>
            
            <!-- Tabla de productos -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>001</td>
                            <td>Pez Betta Azul</td>
                            <td>Peces Tropicales</td>
                            <td>$14.99</td>
                            <td>25</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-1"><i class="fa-solid fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>002</td>
                            <td>Acuario 30L</td>
                            <td>Acuarios</td>
                            <td>$89.99</td>
                            <td>8</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-1"><i class="fa-solid fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>003</td>
                            <td>Planta Acuática</td>
                            <td>Decoraciones</td>
                            <td>$8.99</td>
                            <td>42</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-1"><i class="fa-solid fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        
        <!-- Gestión de Pedidos -->
        <section id="pedidos" class="mb-5">
            <h2 class="mb-4">Pedidos</h2>
            
            <!-- Tabla de pedidos -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Pedido #</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>10045</td>
                            <td>Juan Pérez</td>
                            <td>15/04/2023</td>
                            <td>$124.50</td>
                            <td><span class="badge bg-success">Completado</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>10046</td>
                            <td>María López</td>
                            <td>15/04/2023</td>
                            <td>$89.99</td>
                            <td><span class="badge bg-warning text-dark">Pendiente</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>10047</td>
                            <td>Carlos Ruiz</td>
                            <td>16/04/2023</td>
                            <td>$45.75</td>
                            <td><span class="badge bg-info">Enviado</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        
        <!-- Gestión de Clientes -->
        <section id="clientes">
            <h2 class="mb-4">Clientes</h2>
            
            <!-- Tabla de clientes -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Pedidos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>001</td>
                            <td>Juan Pérez</td>
                            <td>juan@ejemplo.com</td>
                            <td>555-1234</td>
                            <td>3</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>002</td>
                            <td>María López</td>
                            <td>maria@ejemplo.com</td>
                            <td>555-5678</td>
                            <td>1</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>003</td>
                            <td>Carlos Ruiz</td>
                            <td>carlos@ejemplo.com</td>
                            <td>555-9012</td>
                            <td>2</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                        <div class="row mb-3">
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
    <?php 
     require_once __DIR__ . '/../parcials/footer.php'; 
    ?>
</body>
</html>
