import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";
export async function cargarCategorias() {
    const select = document.getElementById('categoria_id');
    const select_categoria_menu = document.getElementById('select_categoria_menu');
    try {
            const response = await axios.post(`${rutaAbsoluta}/CategoriaController.php`, new URLSearchParams({
            action: 'listarCategorias'
        }));

        const categorias = response.data.payload || [];
        select.innerHTML = '<option value="">-- Selecciona una Categoría --</option>';
        select.innerHTML = [
            '<option value="">-- Selecciona una Categoría --</option>',
            ...categorias.map(categoria => `<option value="${categoria.id_categoria}">${categoria.nombre}</option>`)
        ].join('');

        select_categoria_menu.innnerHTML = '<option value="">-- Todas las categorias --</option>'
        select_categoria_menu.innerHTML = [
            '<option value="">-- Todas las categorias --</option>',
            ...categorias.map(categoria => `<option value="${categoria.id_categoria}">${categoria.nombre}</option>`)
        ].join('');

    } catch (error) {
        console.error('Error al cargar categorías:', error);
    }
}

export async function cargarEspecies() {
    const selectEspecie = document.getElementById('especie_id');
    try {
        const response = await axios.post(`${rutaAbsoluta}/EspecieController.php`, new URLSearchParams({
            action: 'listarEspecie'
        }));

        const especies = response.data.payload || [];
        selectEspecie.innerHTML = '<option value="">-- Selecciona una especie --</option>';
        selectEspecie.innerHTML = [
            '<option value="">-- Selecciona una especie --</option>',
            ...especies.map(especie => `<option value="${especie.id_especie}">${especie.nombre_especie}</option>`)
        ].join('');
    } catch (error) {
        console.error('Error al cargar especie:', error);
    }
}

export async function cargarTipoPez() {
    const selectTipoPez = document.getElementById('tipo_pez_id');
    try {
        const response = await axios.post(`${rutaAbsoluta}/TipoPezController.php`, new URLSearchParams({
            action: 'listarTipoPez'
        }));

        const tipoPez = response.data.payload || [];
        selectTipoPez.innerHTML = '<option value="">-- Selecciona un tipo de pez --</option>';
        selectTipoPez.innerHTML = [
            '<option value="">-- Selecciona un tipo de pez --</option>',
            ...tipoPez.map(tipoPez => `<option value="${tipoPez.id_tipo_pez}">${tipoPez.nombre_tipo_pez}</option>`)
        ].join('');
    } catch (error) {
        console.error('Error al cargar especie:', error);
    }
}

export async function cargarTipoAccesorio() {
    const selectTipoAccesorio = document.getElementById('tipo_accesorio_id');
    try {
        const response = await axios.post(`${rutaAbsoluta}/TipoAccesorioController.php`, new URLSearchParams({
            action: 'listarTipoAccesorio'
        }));

        const tipoAccesorios = response.data.payload || [];
        selectTipoAccesorio.innerHTML = '<option value="">-- Selecciona un tipo de accesorio --</option>';
        selectTipoAccesorio.innerHTML = [
            '<option value="">-- Selecciona un tipo de accesorio --</option>',
            ...tipoAccesorios.map(tipoAccesorio => `<option value="${tipoAccesorio.id_tipo_accesorio}">${tipoAccesorio.nombre_tipo_accesorio}</option>`)
        ].join('');
    } catch (error) {
        console.error('Error al cargar especie:', error);
    }
}

export function mostrarSeccionEspecifica(categoriaSelect) {
    // cargar seccion en formulario dependiendo de la categoria seleccionada
    const seccionPeces = document.getElementById('seccion-peces');
    const seccionAccesorios = document.getElementById('seccion-accesorios');
    const seccionAcuarios = document.getElementById('seccion-acuarios');
 
    seccionPeces.classList.add('d-none');
    seccionAccesorios.classList.add('d-none');
    seccionAcuarios.classList.add('d-none');

    if (categoriaSelect === "1") {
        seccionPeces.classList.remove('d-none');
    } else if (categoriaSelect === "3") {
        seccionAccesorios.classList.remove('d-none');
    } else if (categoriaSelect === "2") {
        seccionAcuarios.classList.remove('d-none');
    }   
}