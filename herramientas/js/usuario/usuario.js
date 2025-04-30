import { registrarUsuario } from "./registroUsuario.js";
import { loginUsuario } from "./loginUsuario.js";

document.addEventListener("DOMContentLoaded", () => {
    const btnGuardarUsuario = document.querySelector("#btnRegistrarUsuario");
    const btnIniciarSesion = document.querySelector("#btnIniciarSesion");
    const btnAbrirModal = document.querySelector("#abrirModalRegistro");
    const modalRegistro = document.querySelector("#modalRegistroUsuario");
    
    //REGISTRAR USUARIO
    if(btnGuardarUsuario){
        btnGuardarUsuario.addEventListener("click", registrarUsuario)
    }
    //INICIAR SESION
    if(btnIniciarSesion){
        btnIniciarSesion.addEventListener("click", loginUsuario)
    }
   
});