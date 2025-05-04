import {listarCarrito} from "./listarCarrito.js";
import {añadirCarrito} from "./añadirCarrito.js";
import {disminuirCarrito} from "./disminuirCarrito.js";
document.addEventListener("DOMContentLoaded", () => {
    // Cargar carrito de compras
    listarCarrito();

    //agregar carrito
   añadirCarrito(listarCarrito);
   
   // Eliminar producto del carrito
    disminuirCarrito(listarCarrito);

});

