import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";

export function añadirCarrito(callbackAfterAdd = null) {  // ← Acepta un callback opcional
    document.addEventListener('click', async (event) => {
        const btn = event.target.closest('[data-id-producto]');
        if (!btn) return;
        
        const productoId = btn.getAttribute('data-id-producto');
        try {
            const response = await axios.post(
                `${rutaAbsoluta}/CarritoController.php`, 
                new URLSearchParams({
                    action: 'agregarCarrito',
                    id_producto: productoId
                })
            );
            
            if (response.data.result == "1") {
                iziToast.success({ title: response.data.message });
                if (callbackAfterAdd) callbackAfterAdd();  // ← Ejecuta el callback si existe
            } else {
                iziToast.error({ title: response.data.message });
            }
        } catch (error) {
            console.error('Error al añadir el producto al carrito:', error);
            iziToast.error({ title: 'Error al añadir el producto' });
        }
    });
}