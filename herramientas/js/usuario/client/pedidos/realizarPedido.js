// import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";
// export async function realizarPedido() {
//     const btnFinalizarCompra = document.querySelector('#btnFinalizar');
//     btnFinalizarCompra.addEventListener('click', async () => {
//         let idCarritoPedido =  btnFinalizarCompra.getAttribute('data-id-carrito');
//         if(!idCarritoPedido){return}
//         const response = await axios.post(`${rutaAbsoluta}/PedidoController.php`, new URLSearchParams({
//             action: 'realizarPedido',
//             id_carrito: idCarritoPedido
//         }));
//         if (response.data.result == "1") {
//             iziToast.success({ title: response.data.message });
//         } else {
//             iziToast.error({ title: response.data.message });
//         }
//     })
// }
  

import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";
export async function realizarPedido() {
    const btnFinalizarCompra = document.querySelector('#btnFinalizar');
    btnFinalizarCompra.addEventListener('click', async () => {
        let idCarritoPedido = btnFinalizarCompra.getAttribute('data-id-carrito');
        if(!idCarritoPedido){return}
        // Aquí puedes obtener el monto y el título del pedido según tu lógica
        const monto = 10000; // Cambia esto por el valor real del pedido
        const titulo = "Pedido de prueba"; // Cambia esto por el nombre real del pedido

        const response = await axios.post(`${rutaAbsoluta}/PagoController.php`, new URLSearchParams({
            action: 'crearPago',
            id_carrito: idCarritoPedido,
            monto: monto,
            titulo: titulo
        }));

        if (response.data.init_point) {
            // Abre la página de Mercado Pago en una nueva pestaña
            window.open(response.data.init_point, '_blank');
        } else if (response.data.result == "1") {
            // Si el pago es exitoso, realiza el pedido
            await axios.post(`${rutaAbsoluta}/PedidoController.php`, new URLSearchParams({
                action: 'realizarPedido',
                id_carrito: idCarritoPedido
            }));
        } else {
            iziToast.error({ title: 'Error al crear el pago' });
        }
    })
}
