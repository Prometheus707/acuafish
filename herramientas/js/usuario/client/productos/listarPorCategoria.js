import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";
export async function listarPorCategoria() {
    // Agregar evento de cambio al select de categorías
    const categoriaSelectClient = document.getElementById('categoriaSelectClient');
    categoriaSelectClient.addEventListener('change');
    
}
