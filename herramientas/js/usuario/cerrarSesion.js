import rutaAbsoluta from "../rutaAbsoluta/rutaAbsoluta.js"
document.addEventListener('DOMContentLoaded', () => {
    const btnCerrarSesion = document.getElementById('btnCerrarSesion');
    if (btnCerrarSesion) {
        btnCerrarSesion.addEventListener('click', async () => {
            try {
                const response = await axios.post(`${rutaAbsoluta}/UsuarioController.php`, new URLSearchParams({
                    action: 'cerrarSesion',
                }));
                if (response.data.result == "1") {
                    window.location.reload();
                } else {
                    iziToast.error({ title: response.data.message });
                }
            } catch (error) {
                console.error('Error al cerrar sesión:', error);
            }
        });
    }
});