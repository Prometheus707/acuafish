import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";
export async function cargarCategoriasClient() {
    const categoriaSelectClient = document.getElementById('categoriaSelectClient');
    try {
        const response = await axios.post(`${rutaAbsoluta}/CategoriaController.php`, new URLSearchParams({
            action: 'listarCategorias'
        }));
        const categorias = response.data.payload || [];
        categoriaSelectClient.innerHTML = '<option value="">-- Todas las categorias --</option>';
        categoriaSelectClient.innerHTML = [
            '<option value="">-- Selecciona una Categoría --</option>',
            ...categorias.map(categoria => `<option value="${categoria.id_categoria}">${categoria.nombre}</option>`)
        ].join('');
    } catch (error) {
        console.error('Error al cargar categorías:', error);
    }
}

