import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";

export default async function listarPedidos() {
    try {
        const response = await axios.post(`${rutaAbsoluta}/PedidoController.php`, new URLSearchParams({
            action: 'listarPedidos'
        }));
        const pedidosObj = response.data.payload || {};
        const pedidos = Object.values(pedidosObj); // Convertir el objeto en un array
        const tbody = document.querySelector('#lista_pedidos');
        tbody.innerHTML = '';
        pedidos.forEach(pedido => {
            const detalles = pedido.detalles.map(detalle => `
                <li>${detalle.nombre_producto} - Cantidad: ${detalle.cantidad}, Subtotal: $${detalle.subtotal.toLocaleString()}</li>
            `).join('');
            
            tbody.innerHTML += `
                <tr>
                    <td>${pedido.id_pedido}</td>
                    <td>${pedido.nombre_usuario} (${pedido.correo_usuario})</td>
                    <td>${pedido.estado_pedido}</td>
                    <td>$${pedido.total.toLocaleString()}</td>
                    <td>${pedido.fecha_pedido}</td>
                    <td>
                        <ul>${detalles}</ul>
                    </td>
                </tr>
            `;
        });
    } catch (error) {
        console.error('Error al cargar los pedidos:', error);
    }
}