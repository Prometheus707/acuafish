import rutaAbsoluta, {} from "../../../rutaAbsoluta/rutaAbsoluta.js";
export async function eliminarProducto() {
    document.addEventListener('click', async function(e) {
        const btn = e.target.closest('[data-id-producto-delete]');
        if (btn) {
            const id = btn.getAttribute('data-id-producto-delete');
            const response = await axios.post(`${rutaAbsoluta}/ProductoController.php`, new URLSearchParams({
                action: 'eliminarProducto',
                idProductoEliminar: id
            }));
            if (response.data.result == "1") {
                iziToast.success({message: response.data.message });
            } else {
                iziToast.error({ title: 'Error', message: response.data.message });
            }
        }
    });
}
