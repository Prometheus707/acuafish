<div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-labelledby="modalNuevoProductoLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable"> <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalNuevoProductoLabel">Producto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
             <input type="hidden" id="producto_id" name="producto_id">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Producto:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="precio" class="form-label">Precio:</label>
                    <input type="number" class="form-control" id="precio" name="precio" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock:</label>
                    <input type="number" class="form-control" id="stock" pattern="[0-9]*" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  inputmode="numeric" name="stock" required>
                </div>

                <div class="mb-3" id="div_imagen_url">
                    <label for="imagen_url" class="form-label">URL de Imagen:</label>
                    <input type="file" class="form-control" id="imagen_url" name="imagen_url" accept="image/*">                </div>

                <div class="mb-3">
                    <label for="categoria_id" class="form-label">Categoría:</label>
                    <select class="form-select" id="categoria_id" name="categoria_id" required>
                    </select>
                </div>

                <div id="seccion-peces" class="seccion-especifica d-none">
                    <h3>Detalles Específicos para Peces</h3>
                    <div class="mb-3">
                        <label for="especie_id" class="form-label">Especie:</label>
                        <select class="form-select" id="especie_id" name="especie_id">
                            <!-- <option value="">-- Selecciona Tipo de Pez --</option>
                            <option value="1">Comunitario</option>
                            <option value="2">Agresivo</option> -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_pez_id" class="form-label">Tipo de Pez:</label>
                        <select class="form-select" id="tipo_pez_id" name="tipo_pez_id">
                            <!-- <option value="">-- Selecciona Tipo de Pez --</option>
                            <option value="1">Comunitario</option>
                            <option value="2">Agresivo</option> -->
                        </select>
                    </div>
                </div>

                <div id="seccion-accesorios" class="seccion-especifica d-none">
                    <h3>Detalles Específicos para Accesorios</h3>
                     <div class="mb-3">
                        <label for="tipo_accesorio_id" class="form-label">Tipo de Accesorio:</label>
                        <select class="form-select" id="tipo_accesorio_id" name="tipo_accesorio_id">
                            <!-- <option value="">-- Selecciona Tipo de Accesorio --</option>
                            <option value="1">Filtro</option>
                            <option value="2">Calentador</option> -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="material" class="form-label">Material:</label>
                        <input type="text" class="form-control" id="material" name="material">
                    </div>
                    <div class="mb-3">
                        <label for="potencia_w" class="form-label">Potencia (W):</label>
                        <input type="number" class="form-control" id="potencia_w" name="potencia_w">
                    </div>
                </div>

                <div id="seccion-acuarios" class="seccion-especifica d-none">
                    <h3>Detalles Específicos para Acuarios</h3>
                    <div class="mb-3">
                        <label for="volumen_litros" class="form-label">Volumen (Litros):</label>
                        <input type="number" class="form-control" id="volumen_litros" name="volumen_litros" step="0.1">
                    </div>
                    <div class="mb-3">
                        <label for="dimensiones" class="form-label">Dimensiones:</label>
                        <input type="text" class="form-control" id="dimensiones" name="dimensiones">
                    </div>
                    <div class="mb-3">
                        <label for="material_acuario" class="form-label">Material:</label>
                        <input type="text" class="form-control" id="material_acuario" name="material_acuario">
                    </div>
                </div>

                <button id="btnGuardarProducto" class="btn btn-primary mt-3">Guardar Producto</button>
                <button id="btnActualizarProducto"  class="btn btn-primary mt-3" >Actualizar Producto</button>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
      </div>
    </div>