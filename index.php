<?php 
    include('archivo/Core/parametros_index.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ACUAFISH</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="/IMG/fish.jpg" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
</head>
<body class="text-white" style="<?php echo $varColorAplication; ?>">
    <div class="container">
        <header class="py-3">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand d-flex align-items-center" href="#">
                        <i class="fa-regular fa-circle-dot me-2"></i>
                        <h1 class="m-0 h4" style="<?php echo $varColorLetra; ?>">ACUAFISH</h1>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto text-white text-center">
                            <li class="nav-item"><a class="nav-link" style="<?php echo $varColorLetra; ?>" href="https://www.google.com/maps">Ubicación</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="row py-4 align-items-center">
            <div class="col-md-7">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <h2>ACUAFISH <br> POPAYÁN</h2>
                        <p>Realiza tus pedidos de peces, decoraciones, acuarios y accesorios para armar tu propio acuario con nosotros.</p>
                        <button class="btn btn-primary" style="<?php echo $varColorSecundaryAplication; ?>">Hacer Pedido <i class="fa-solid fa-circle-chevron-right"></i></button>
                    </div>
                    <div class="col-md-6 text-center mb-3">
                        <img src="imagenes/logoAcusFish.jpeg" alt="Logo" class="rounded-circle mt-3" width="150" height="150">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="row text-center">
                            <div class="col-4 mb-2">
                                <div class="d-inline-block border border-light rounded-pill px-3 py-1">
                                    <i class="fa-solid fa-check me-1"></i> Peces agresivos
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="d-inline-block border border-light rounded-pill px-3 py-1">
                                    <i class="fa-solid fa-check me-1"></i> Peces comunitarios
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="d-inline-block border border-light rounded-pill px-3 py-1">
                                    <i class="fa-solid fa-check me-1"></i> Plantas naturales
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="d-inline-block border border-light rounded-pill px-3 py-1">
                                    <i class="fa-solid fa-check me-1"></i> Plantas artificiales
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="d-inline-block border border-light rounded-pill px-3 py-1">
                                    <i class="fa-solid fa-check me-1"></i> Acuarios
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="d-inline-block border border-light rounded-pill px-3 py-1">
                                    <i class="fa-solid fa-check me-1"></i> Iluminación
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="d-inline-block border border-light rounded-pill px-3 py-1">
                                    <i class="fa-solid fa-check me-1"></i> Alimentos
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 order-md-last order-first mb-4 mb-md-0">
                <div class="bg-white p-4 rounded shadow">
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-lg py-3" id="emailLogin" name="emailLogin" placeholder="Correo electrónico o número de teléfono"  autocomplete="nope" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control form-control-lg py-3" id="passwordLogin" name="passwordLogin" placeholder="Contraseña"  autocomplete="nope" required>
                        </div>
                        <div class="d-grid gap-2 mb-3">
                            <button id="btnIniciarSesion" class="btn btn-primary btn-lg fw-bold fs-5 py-2" style="<?php echo $varColorSecundaryAplication; ?>">Iniciar sesión</button>
                        </div>
                        <div class="d-grid gap-2">
                        <button id="btnIniciarSesion" class="btn btn-primary btn-lg fw-bold fs-5 py-2"  data-bs-toggle="modal" data-bs-target="#modalRecuperarContraseña" style="<?php echo $varColorAplication;?>">Recuperar contraseña</button>
                        </div>
                        <hr class="my-4">
                        <div class="d-grid gap-2">
                            <button type="button"  id="abrirModalRegistro" class="btn btn-success btn-lg fw-bold" data-bs-toggle="modal" data-bs-target="#modalRegistroUsuario" style="<?php echo $varColorAplication;?>">Crear cuenta nueva</button>
                        </div>
                </div>
            </div>
        </div>
        <div class="row text-center py-4">
            <div class="col-md-3 col-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="/IMG/whas.png" class="img-fluid mb-2" alt="Whatsapp">
                        <h3>WHATSAPP</h3>
                        <a style="<?php echo $varColorSecundaryAplication; ?>" href="#" class="btn">Whatsapp</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="/IMG/facebook.png" class="img-fluid mb-2" alt="Facebook">
                        <h3>FACEBOOK</h3>
                        <a style="<?php echo $varColorSecundaryAplication; ?>" href="#" class="btn">Facebook</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="IMG/instagram.png" class="img-fluid mb-2" alt="Instagram">
                        <h3>INSTAGRAM</h3>
                        <a style="<?php echo $varColorSecundaryAplication; ?>" href="#" class="btn">Instagram</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="IMG/tik-tok.png" class="img-fluid mb-2" alt="Tik Tok">
                        <h3>TIK TOK</h3>
                        <a style="<?php echo $varColorSecundaryAplication; ?>" href="#" class="btn">Tik Tok</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('archivo/views/modales/modales-index.php'); ?>
    <!-- Overlay de carga Bootstrap -->
    <div id="overlay-cargando" class="position-fixed top-0 start-0 w-100 h-100 d-none justify-content-center align-items-center" style="background:rgba(0,0,0,0.4);z-index:9999;">
      <div class="bg-white rounded p-4 d-flex flex-column align-items-center shadow">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
          <span class="visually-hidden">Cargando...</span>
        </div>
        <p class="mt-3 mb-0 text-dark">Enviando correo de recuperación...</p>
      </div>
    </div>
    <!-- Fin overlay de carga -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="herramientas/js/usuario/usuario.js"></script>
</body>
</html>

