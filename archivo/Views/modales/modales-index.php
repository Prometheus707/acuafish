<!-- INICIO MODAL DE INICIO DE SESIÓN -->
<div class="modal fade" id="modalInicioSesion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-dark" id="staticBackdropLabel">Iniciar Sesión</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
                <label for="email" class="form-label text-dark">Correo Electrónico</label>
                <input type="email" class="form-control bg-light text-dark" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label text-dark">Contraseña</label>
                <input type="password" class="form-control bg-light text-dark" id="password" name="password" required>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" style="<?php echo $varColorAplication; ?>">Verificar</button>
      </div>
    </div>
  </div>
</div>
<!--INICIO MODAL DE REGISTRO DEL USUARIO-->
<!-- INICIO MODAL DE REGISTRO -->
<div class="modal fade" id="modalRegistroUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegistroUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-dark" id="modalRegistroLabel">Registrarse</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="nombre" class="form-label text-dark">Nombre</label>
          <input type="text" class="form-control bg-light text-dark" id="nombre" name="nombre" required>
        </div>
        <!-- <select class="form-select" id="documentoIdentidad" aria-label="Default select example">
 
        </select> -->
        <div class="mb-3">
          <label for="emailRegistro" class="form-label text-dark">Correo Electrónico</label>
          <input type="email" class="form-control bg-light text-dark" id="emailRegistro" name="emailRegistro" required>
        </div>
        <div class="mb-3">
          <label for="emailRegistro" class="form-label text-dark">Telefono</label>
          <input type="number" class="form-control bg-light text-dark"  pattern="[0-9]*" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  inputmode="numeric"  id="telefonoRegistro" name="telefonoRegistro" required>
        </div>
        <div class="mb-3">
          <label for="passwordRegistro" class="form-label text-dark">Contraseña</label>
          <input type="password" class="form-control bg-light text-dark" id="passwordRegistro" name="passwordRegistro" required>
        </div>
      </div>
      <div class="modal-footer">
        <button id="btnRegistrarUsuario" name="btnRegistrarUsuario" type="button" class="btn" style="<?php echo $varColorAplication; ?>">Registrarse</button>
      </div>
    </div>
  </div>
</div>
<!---- recuperar contraseña -->
<div class="modal fade" id="modalRecuperarContraseña" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRecuperarContraseñaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-dark" id="modalRecuperarContraseñaLabel">Recuperar Contraseña</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="emailRecuperarContraseña" class="form-label text-dark">Correo Electrónico</label>
          <input type="email" class="form-control bg-light text-dark" id="emailRecuperarContraseña" name="emailRecuperarContraseña" required>
        </div>
      </div>
      <div class="modal-footer">
        <button id="btnRecuperarContrasena" name="btnRecuperarContrasena" type="button" class="btn" style="<?php echo $varColorAplication;?>">Recuperar Contraseña</button>
      </div>
    </div>
  </div>
</div>
<!--FIN MODAL DE REGISTRO -->

