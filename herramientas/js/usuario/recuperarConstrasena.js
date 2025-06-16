import rutaAbsoluta from "../rutaAbsoluta/rutaAbsoluta.js"
export async function recuperarContrasena() {
    const emailRecuperar = document.querySelector("#emailRecuperarContraseña").value.trim();
    // Mostrar overlay de carga
    const overlay = document.getElementById("overlay-cargando");
    overlay.classList.remove("d-none");
    overlay.classList.add("d-flex");
    try {
        const response = await axios.post(`${rutaAbsoluta}/UsuarioController.php`, new URLSearchParams({
            action: 'recuperarContrasena',
            email: emailRecuperar,
        }));
        if(response.data.result == "1") {
            iziToast.success({ title: response.data.message, });
        }
        else {
            iziToast.error({ title: response.data.message, });
        }
    } catch (error) {
        iziToast.error({ title: "Error al recuperar la contraseña" });
    } finally {
        // Ocultar overlay de carga
        overlay.classList.remove("d-flex");
        overlay.classList.add("d-none");
    }
}