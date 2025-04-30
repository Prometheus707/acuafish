// Validar si un campo está vacío
export function validarCampoVacio(valor, nombre) {
    if (!valor.trim()) {
        iziToast.error({
            title: "Campo obligatorio",
            message: `El campo "${nombre}" no puede estar vacío.`,
            position: "topRight",
        });
        return false;
    }
    return true;
}

// Validar formato de correo electrónico
export function validarCorreo(valor) {
    validarCampoVacio(valor, "Correo electrónico");
    const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexCorreo.test(valor)) {
        iziToast.error({
            title: "Correo inválido",
            message: "Por favor, ingresa un correo electrónico válido.",
            position: "topRight",
        });
        return false;
    }
    return true;
}

// Validar longitud mínima
export function validarLongitud(valor, nombre, minLength) {
    if (valor.length < minLength) {
        iziToast.error({
            title: "Campo inválido",
            message: `El campo "${nombre}" debe tener al menos ${minLength} caracteres.`,
            position: "topRight",
        });
        return false;
    }
    return true;
}