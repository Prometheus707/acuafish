import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";

export async function traerCamposEditar() {
    const modal = document.getElementById('modalNuevoProducto');
    const categoria = modal.querySelector('#categoria_id').value;
    const formData = new FormData();

    formData.append('action', 'registrarProducto');
    formData.append('nombre', modal.querySelector('#nombre').value);
    formData.append('descripcion', modal.querySelector('#descripcion').value);
    formData.append('precio', modal.querySelector('#precio').value);
    formData.append('stock', modal.querySelector('#stock').value);
    formData.append('categoria', categoria);

    // Archivo
    const imagenInput = modal.querySelector('#imagen_url');
    if (imagenInput.files && imagenInput.files[0]) {
        formData.append('imagen', imagenInput.files[0]);
    }

    if (categoria === "1") { // Peces
        formData.append('especie', modal.querySelector('#especie_id').value);
        formData.append('tipo_pez', modal.querySelector('#tipo_pez_id').value);
    } else if (categoria === "3") { // Accesorios
        formData.append('tipo_accesorio', modal.querySelector('#tipo_accesorio_id').value);
        formData.append('material', modal.querySelector('#material').value);
        formData.append('potencia_w', modal.querySelector('#potencia_w').value);
    } else if (categoria === "2") { // Acuarios
        formData.append('volumen_litros', modal.querySelector('#volumen_litros').value);
        formData.append('dimensiones', modal.querySelector('#dimensiones').value);
        formData.append('material_acuario', modal.querySelector('#material_acuario').value);
    }

    const response = await axios.post(`${rutaAbsoluta}/ProductoController.php`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
    });

    if (response.data.result == "1") {
        iziToast.success({ title: response.data.message });
        modal.querySelectorAll('input, textarea, select').forEach(el => {
            if (el.tagName === 'SELECT') {
                el.selectedIndex = 0;
            } else {
                el.value = '';
            }
        });
        modal.querySelectorAll('.seccion-especifica').forEach(sec => sec.classList.add('d-none'));
    } else {
        iziToast.error({ title: response.data.message });
    }
}

export function inicializarEdicionProducto() {
    document.addEventListener('click', async function(e) {
        const btn = e.target.closest('[data-id-producto-update]');
        if (btn) {
            const id = btn.getAttribute('data-id-producto-update');
            // Petición para obtener los datos del producto
            const response = await axios.post(`${rutaAbsoluta}/ProductoController.php`, new URLSearchParams({
                action: 'obtenerProducto',
                idProductoTraer: id
            }));
            if (response.data.result == "1") {
                const producto = response.data.payload;
                const modal = document.getElementById('modalNuevoProducto');
                // Llena los campos generales
                modal.querySelector('#producto_id').value = producto.id_productos;
                modal.querySelector('#nombre').value = producto.nombre;
                modal.querySelector('#descripcion').value = producto.descripcion;
                modal.querySelector('#precio').value = producto.precio;
                modal.querySelector('#stock').value = producto.stock;

                modal.querySelector('#categoria_id').value = producto.categoria_id;

                // 2. Muestra la sección específica
                if (typeof mostrarSeccionEspecifica === "function") {
                    mostrarSeccionEspecifica(producto.categoria_id);
                } else {
                    // Si no tienes la función, muestra/oculta manualmente
                    modal.querySelectorAll('.seccion-especifica').forEach(sec => sec.classList.add('d-none'));
                    if (producto.categoria_id == "1") modal.querySelector('#seccion-peces').classList.remove('d-none');
                    if (producto.categoria_id == "2") modal.querySelector('#seccion-acuarios').classList.remove('d-none');
                    if (producto.categoria_id == "3") modal.querySelector('#seccion-accesorios').classList.remove('d-none');
                }

                // 3. Llena los campos específicos
                if (producto.categoria_id == "1") { // Peces
                    modal.querySelector('#especie_id').value = producto.especie_id || producto.especie || '';
                    modal.querySelector('#tipo_pez_id').value = producto.tipo_pez_id || producto.tipo_pez_fk || '';
                } else if (producto.categoria_id == "3") { // Accesorios
                    modal.querySelector('#tipo_accesorio_id').value = producto.tipo_accesorio_id || '';
                    modal.querySelector('#material').value = producto.material || '';
                    modal.querySelector('#potencia_w').value = producto.potencia_w || '';
                } else if (producto.categoria_id == "2") { // Acuarios
                    modal.querySelector('#volumen_litros').value = producto.volumen_litros || '';
                    modal.querySelector('#dimensiones').value = producto.dimensiones || '';
                    modal.querySelector('#material_acuario').value = producto.material_acuario || '';
                }
                // Abre el modal
                const modalBootstrap = new bootstrap.Modal(modal);
                modalBootstrap.show();
            } else {
                iziToast.error({ title: 'Error', message: response.data.message });
            }
        }
    });
}