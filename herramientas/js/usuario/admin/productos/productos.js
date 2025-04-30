import {enviarProducto} from "./agregarProductos.js"
import {cargarCategorias, mostrarSeccionEspecifica, cargarEspecies, cargarTipoPez, cargarTipoAccesorio} from "./select.js "
import {listarProductos} from "./listarProductosMenu.js";
import {inicializarEdicionProducto} from "./editarProducto.js";
document.addEventListener("DOMContentLoaded", () => {
    function limpiarFormularioProducto() {
        const modal = document.getElementById('modalNuevoProducto');
        // Limpia todos los campos generales
        modal.querySelectorAll('input, textarea, select').forEach(el => {
            if (el.tagName === 'SELECT') {
                el.selectedIndex = 0;
            } else {
                el.value = '';
            }
        });
        modal.querySelectorAll('.seccion-especifica').forEach(sec => sec.classList.add('d-none'));
    }

    document.getElementById('abrirModalAProducto').addEventListener('click', () => {
        limpiarFormularioProducto();
       
    });

    //listar productos en el menu
    const select_categoria_menu = document.getElementById('select_categoria_menu');
    if(select_categoria_menu){
        select_categoria_menu.addEventListener('change', () => {
            const categoriaId = select_categoria_menu.value;
            listarProductos(categoriaId);
        });
    }
 
    //cargar categorias en los select
    cargarCategorias();
    cargarEspecies();
    cargarTipoPez();
    cargarTipoAccesorio();

    // aparecer o desaparecer secciones dependiendo de la categoria
    const categoriaSelect = document.getElementById('categoria_id');
    categoriaSelect.addEventListener('change', ()=> {
       mostrarSeccionEspecifica(categoriaSelect.value);
    });

    //guardar producto
    const btnGuardarProducto = document.getElementById('btnGuardarProducto');
    if(btnGuardarProducto){
        btnGuardarProducto.addEventListener('click', enviarProducto)
    };


    document.getElementById('btnNuevoProducto').addEventListener('click', () => {
        limpiarFormularioProducto();
        const modal = new bootstrap.Modal(document.getElementById('modalNuevoProducto'));
        modal.show();
    });
    
   
    //editar producto
    inicializarEdicionProducto();


});