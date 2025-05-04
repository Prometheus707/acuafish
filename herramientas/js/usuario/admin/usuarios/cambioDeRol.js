import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";
export async function cambiarRol(callbackAfterAdd = null) {
    document.addEventListener('click', async function(e) {
        if (e.target.classList.contains('btn-cambiar-rol')) {
            const id_usuario = e.target.getAttribute('data-id-usuario');
            const rol_nuevo = e.target.getAttribute('data-rol');
            const response = await axios.post(`${rutaAbsoluta}/UsuarioController.php`, new URLSearchParams({
                action: 'cambiarRol',
                id_usuario: id_usuario,
                rol_nuevo: rol_nuevo
            }));
            if (response.data.result == "1") {
                iziToast.success({ title: response.data.message });
                if (callbackAfterAdd) callbackAfterAdd();  // ← Ejecuta el callback si existe
            }
            else {
                iziToast.error({ title: response.data.message });
            }
        }
    });
}