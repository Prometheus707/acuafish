import rutaAbsoluta, {} from "../../../rutaAbsoluta/rutaAbsoluta.js";
export async function listarProductos(categoriaId) {
    const response = await axios.post(`${rutaAbsoluta}/ProductoController.php`, new URLSearchParams({
        action: 'listarProductos',
        categoriaId: categoriaId
    }));
    if(response.data.result == "1"){
        const lista_productos = document.getElementById('lista_productos');
        const productos = response.data.payload || [];
        lista_productos.innerHTML = '';
        if(productos.length === 0){
            lista_productos.innerHTML = `<tr>
                <td colspan="6" class="text-center">No hay productos para esta categoría.</td>
            </tr>`;
            return;
        }
        lista_productos.innerHTML = productos.map(producto => `
            <tr>
                <td>${producto.nombre}</td>
                <td>${producto.descripcion}</td>
                <td>$${producto.precio}</td>
                <td>${producto.stock}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary me-1" data-id-producto-update=${producto.id_productos}><i class="fa-solid fa-edit"></i></button>
                    <button class="btn btn-sm btn-outline-danger" data-id-producto-delete=${producto.id_productos}><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
        `).join('');
    }
    else{
        iziToast.error({title: response.data.message,});
    }
}