import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";

export function inicializarEdicionProducto() {
    document.addEventListener('click', async function(e) {
        const btn = e.target.closest('[data-id-producto-update]');
        if (btn) {
            const btnActualizar = document.getElementById('btnActualizarProducto');
            const btnGuardarProducto = document.getElementById('btnGuardarProducto');
            const divUrlImagen = document.getElementById('div_imagen_url');
            const select_categoria = document.getElementById('categoria_id');
            if(select_categoria){
                select_categoria.disabled = true; 
            }
            if (divUrlImagen) {
                divUrlImagen.classList.add('d-none');
            }
            if (btnActualizar) {
                btnActualizar.classList.remove('d-none');
            }
            if (btnGuardarProducto) {
                btnGuardarProducto.classList.add('d-none');
            }

            const id = btn.getAttribute('data-id-producto-update');
            const response = await axios.post(`${rutaAbsoluta}/ProductoController.php`, new URLSearchParams({
                action: 'obtenerProducto',
                idProductoTraer: id
            }));
            if (response.data.result == "1") {
                const producto = response.data.payload;
                const modal = document.getElementById('modalNuevoProducto');
                modal.querySelector('#producto_id').value = producto.id_productos;
                modal.querySelector('#nombre').value = producto.nombre;
                modal.querySelector('#descripcion').value = producto.descripcion;
                modal.querySelector('#precio').value = producto.precio;
                modal.querySelector('#stock').value = producto.stock;

                modal.querySelector('#categoria_id').value = producto.categoria_id;

                if (typeof mostrarSeccionEspecifica === "function") {
                    mostrarSeccionEspecifica(producto.categoria_id);
                } else {
                    modal.querySelectorAll('.seccion-especifica').forEach(sec => sec.classList.add('d-none'));
                    if (producto.categoria_id == "1") modal.querySelector('#seccion-peces').classList.remove('d-none');
                    if (producto.categoria_id == "2") modal.querySelector('#seccion-acuarios').classList.remove('d-none');
                    if (producto.categoria_id == "3") modal.querySelector('#seccion-accesorios').classList.remove('d-none');
                }

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
                const modalBootstrap = new bootstrap.Modal(modal);
                modalBootstrap.show();
            } else {
                iziToast.error({ title: 'Error', message: response.data.message });
            }
        }
    });
}

export async function editarProducto() {
    const modal = document.getElementById('modalNuevoProducto');
    const id_producto = modal.querySelector('#producto_id').value;
    const nombre = modal.querySelector('#nombre').value;
    const descripcion = modal.querySelector('#descripcion').value;
    const precio = modal.querySelector('#precio').value;
    const stock = modal.querySelector('#stock').value;
    const categoria_id = modal.querySelector('#categoria_id').value;

    let data = {
        action: 'actualizarProducto',
        id_producto: id_producto,
        nombre: nombre,
        descripcion: descripcion,
        precio: precio,
        stock: stock,
        categoria_id: categoria_id
    };

    if (categoria_id == "1") { // Peces
        data.especie = modal.querySelector('#especie_id').value;
        data.tipo_pez = modal.querySelector('#tipo_pez_id').value;
    } else if (categoria_id == "3") { // Accesorios
        data.tipo_accesorio = modal.querySelector('#tipo_accesorio_id').value;
        data.material = modal.querySelector('#material').value;
        data.potencia_w = modal.querySelector('#potencia_w').value;
    } else if (categoria_id == "2") { // Acuarios
        data.volumen_litros = modal.querySelector('#volumen_litros').value;
        data.dimensiones = modal.querySelector('#dimensiones').value;
        data.material_acuario = modal.querySelector('#material_acuario').value;
    }
    // Envío de datos al servidor
    const response = await axios.post(`${rutaAbsoluta}/ProductoController.php`,new URLSearchParams(data));
    if (response.data.result == "1") {
        iziToast.success({ title: response.data.message });
    } else {
        iziToast.error({ title: response.data.message });
    }
}
