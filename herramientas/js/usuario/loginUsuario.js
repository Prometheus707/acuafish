import rutaAbsoluta from "../rutaAbsoluta/rutaAbsoluta.js"
export async function loginUsuario() {
    const emailLogin = document.querySelector("#emailLogin").value.trim();
    const passwordLogin = document.querySelector("#passwordLogin").value.trim();
    const response = await axios.post(`${rutaAbsoluta}/UsuarioController.php`, new URLSearchParams({
        action: 'loginUsuario',
        email: emailLogin,
        password: passwordLogin,
    }));
    if(response.data.result == "1") {
        if(response.data.payload.rol == "1"){
            iziToast.success({ title: response.data.message, });
            setTimeout(() => {     
                window.location.href = "archivo/Views/client/menuClient.php";
            }, 2000);
        }else if(response.data.payload.rol == "2"){ 
            iziToast.success({ title: response.data.message, });
            setTimeout(() => {     
                window.location.href = "archivo/Views/admin/menuAdmin.php";
            }, 2000);
        }
    }
    else {
        iziToast.error({ title: response.data.message, });
    }
}