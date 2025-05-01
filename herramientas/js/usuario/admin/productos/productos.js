import {enviarProducto} from "./agregarProductos.js"
import {cargarCategorias, mostrarSeccionEspecifica, cargarEspecies, cargarTipoPez, cargarTipoAccesorio} from "./select.js "
import {listarProductos} from "./listarProductosMenu.js";
import {inicializarEdicionProducto, editarProducto} from "./editarProducto.js";
import {eliminarProducto} from "./eliminarProducto.js";
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
        const btnActualizar = document.getElementById('btnActualizarProducto');
        const btnGuardarProducto = document.getElementById('btnGuardarProducto');
        const urlImagen = document.getElementById('div_imagen_url');
        const select_categoria = document.getElementById('categoria_id');
        if(select_categoria){
            select_categoria.disabled = false; 
        }
        if (urlImagen) {
            urlImagen.classList.remove('d-none');
        }
        if (btnActualizar) {
            btnActualizar.classList.add('d-none');
        }
        if (btnGuardarProducto) {
            btnGuardarProducto.classList.remove('d-none');
        }
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

    inicializarEdicionProducto();
    //editar producto
    const btnActualizarProducto = document.getElementById('btnActualizarProducto');
    if(btnActualizarProducto){
        btnActualizarProducto.addEventListener('click', editarProducto)
    };

    //eliminar producto
    eliminarProducto();


});