import rutaAbsoluta from "../rutaAbsoluta/rutaAbsoluta.js";
export async function registrarUsuario() {
    const nombre = document.querySelector("#nombre").value.trim();
    const email = document.querySelector("#emailRegistro").value.trim();
    const password = document.querySelector("#passwordRegistro").value.trim();
    const telefono = document.querySelector("#telefonoRegistro").value.trim();
    const response = await axios.post(`${rutaAbsoluta}/UsuarioController.php`, new URLSearchParams({
        action: 'registrarUsuario',
        nombre,
        email,
        telefono,
        password,
    }));
    if(response.data.result=="1"){
        iziToast.success({title: response.data.message,});
        setTimeout(() => {
            const modalElement = document.getElementById('modalRegistroUsuario');
            const modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
        }, 2000);
    }else{
        iziToast.error({title: response.data.message,});
    }
}

function limpiarFormulario() {
    document.querySelector("#nombre").value = "";
    document.querySelector("#emailRegistro").value = "";
    document.querySelector("#passwordRegistro").value = "";
    document.querySelector("#telefonoRegistro").value = "";
}

document.addEventListener("DOMContentLoaded", () => {
    const modalRegistro = document.getElementById("modalRegistroUsuario");
    modalRegistro.addEventListener("hidden.bs.modal", () => {
        limpiarFormulario();
    });
});