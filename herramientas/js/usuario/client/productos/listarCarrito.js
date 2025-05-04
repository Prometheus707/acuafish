import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";
export async function listarCarrito() {
    try {
        const response = await axios.post(`${rutaAbsoluta}/CarritoController.php`, new URLSearchParams({
            action: 'listarCarrito',
        }));
        const productos = response.data.payload || [];
        const tbody = document.querySelector('table tbody');
        tbody.innerHTML = '';
        let total = 0;
        productos.forEach(item => {
            const subtotal = item.cantidad * item.precio_unitario;
            total += subtotal;
            tbody.innerHTML += `
                <tr>
                    <td>${item.nombre_producto}</td>
                    <td>${item.cantidad}</td>
                    <td>$${item.precio_unitario.toLocaleString()}</td>
                    <td>$${subtotal.toLocaleString()}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary" data_id_producto_mermar="${item.id_producto_fk}">-</button>
                        <button class="btn btn-sm btn-outline-secondary" data-id-producto = "${item.id_producto_fk}">+</button>
                    </td>
                </tr>
            `;
        });
        // Actualiza el total en el tfoot
        document.querySelector('tfoot strong').textContent = `$${total.toLocaleString()}`;
        // Obtener el ID del carrito
        let id_carrito = null;
        if (productos.length > 0) {
            id_carrito = productos[0].id_carrito_fk;
        }
        const btnFinalizarCompra = document.querySelector('#btnFinalizar');
        if(btnFinalizarCompra){
            btnFinalizarCompra.setAttribute('data-id-carrito',id_carrito)
        }
    } catch (error) {
        console.error('Error al cargar el carrito:', error);
    }
}