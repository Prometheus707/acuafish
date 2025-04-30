import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";

export async function enviarProducto() {
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