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
   <style>
    .carrito-table th, .carrito-table td {
        vertical-align: middle !important;
        text-align: center;
    }
    .carrito-table thead {
        background: linear-gradient(90deg, #0d6efd 0%, #0dcaf0 100%);
        color: #fff;
    }
    .carrito-table tbody tr:hover {
        background-color: #f1f3f4;
        transition: background 0.2s;
    }
    .carrito-table tfoot {
        background-color: #e9ecef;
        font-size: 1.1em;
    }
    .btn-outline-secondary, .btn-danger {
        min-width: 32px;
    }
    .carrito-table .btn-outline-secondary:hover {
        background-color: #0dcaf0;
        color: #fff;
    }
    .carrito-table .btn-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }
    .table-responsive {
    max-height: 400px; /* Ajusta la altura máxima a tu gusto */
    overflow-y: auto;
}
   </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php  
     require_once __DIR__ . '/../parcials/navbarClient.php';
    ?>
    <div class="container my-4 flex-grow-1">
        <h2 class="mb-4 text-primary">🛒 Mi Carrito</h2>
        <input type="text" id = "carrito_id" value="<?php echo $_SESSION['id']; ?>" hidden>
        <div class="table-responsive">
            <table class="table table-bordered align-middle carrito-table shadow-sm">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <a href="" class="btn btn-secondary"><i class="fa fa-arrow-left me-2"></i>Seguir comprando</a>
            <a  class="btn btn-primary" id="btnFinalizar" data-id-carrito="">Finalizar compra <i class="fa fa-credit-card ms-2"></i></a>
        </div>
    </div>
    <?php 
     require_once __DIR__ . '/../parcials/footer.php'; 
    ?>
    <script type="module" src="../../../herramientas/js/usuario/client/productos/carritoCompras.js"></script>
    <script type="module" src="../../../herramientas/js/usuario/client/pedidos/pedidos.js"></script>
    <script type="module" src="../../../herramientas/js/usuario/cerrarSesion.js"></script>

</body>
</html>