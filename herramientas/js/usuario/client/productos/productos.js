import {cargarCategoriasClient} from "./select.js";
import {listarPorCategoria} from "./listarPorCategoria.js";
import {añadirCarrito} from "./añadirCarrito.js";
import { listarCarrito } from "./listarCarrito.js";
document.addEventListener("DOMContentLoaded", () => {
    // Cargar categorías en el select al cargar la página
    cargarCategoriasClient();

    // Agregar evento de cambio al select de categorías
    listarPorCategoria();

    //agregar carrito
    añadirCarrito();


});