import { registrarUsuario } from "./registroUsuario.js";
import { loginUsuario } from "./loginUsuario.js";
import { recuperarContrasena } from "./recuperarConstrasena.js";

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

    //RECUPERAR CONTRASEÑA
    const btnRecuperarContrasena = document.querySelector("#btnRecuperarContrasena");
    if(btnRecuperarContrasena){
        // btnRecuperarContrasena.addEventListener("click", () => {
        //     iziToast.warning({ title: 'Recuperar Contraseña', message: 'Por favor, ingrese su correo electrónico para recuperar su contraseña.' });
        // });
        btnRecuperarContrasena.addEventListener("click", recuperarContrasena)
    }
   
});