import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";
export async function realizarPedido() {
    const btnFinalizarCompra = document.querySelector('#btnFinalizar');
    btnFinalizarCompra.addEventListener('click', async () => {
        let idCarritoPedido =  btnFinalizarCompra.getAttribute('data-id-carrito');
        if(!idCarritoPedido){return}
        const response = await axios.post(`${rutaAbsoluta}/PedidoController.php`, new URLSearchParams({
            action: 'realizarPedido',
            id_carrito: idCarritoPedido
        }));
        if (response.data.result == "1") {
            iziToast.success({ title: response.data.message });
        } else {
            iziToast.error({ title: response.data.message });
        }
    })
}