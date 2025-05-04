import { listarUsuarios, buscarUsuarios } from "./listarUsuarios.js"
import { cambiarRol } from "./cambioDeRol.js";
document.addEventListener("DOMContentLoaded", function () {
    listarUsuarios();
    // Agregar evento de búsqueda
    const inputBusqueda = document.getElementById('busquedaUsuario');
    if(inputBusqueda){
        inputBusqueda.addEventListener('input', function() {
            const filtro = this.value.trim();
            if(filtro === ""){
                listarUsuarios();
            } else {
                buscarUsuarios(filtro);
            }
        });
    }
    //cambiar rol
    cambiarRol(listarUsuarios);
})