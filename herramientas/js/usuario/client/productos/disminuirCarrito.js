import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";

export function disminuirCarrito(callbackAfterAdd = null) {  // ← Acepta un callback opcional
    document.addEventListener('click', async (event) => {
        const btn = event.target.closest('[data_id_producto_mermar]');
        if (!btn) return;
        
        const productoId = btn.getAttribute('data_id_producto_mermar');
        try {
            const response = await axios.post(
                `${rutaAbsoluta}/CarritoController.php`, 
                new URLSearchParams({
                    action: 'disminuirCarrito',
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
            console.error('Error al disminuir el producto al carrito:', error);
            iziToast.error({ title: 'Error al disminuir el producto' });
        }
    });
}