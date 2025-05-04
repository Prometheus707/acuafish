import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";
export async function listarUsuarios() {
    const response = await axios.post(`${rutaAbsoluta}/UsuarioController.php`, new URLSearchParams({
        action: 'listarUsuarios'
    }));
    if(response.data.result == "1"){
        const lista_clientes = document.getElementById('lista_clientes');
        const usuarios = response.data.payload || [];
        lista_clientes.innerHTML = '';
        if(usuarios.length === 0){
            lista_clientes.innerHTML = `<tr>
                <td colspan="4" class="text-center">No hay usuarios registrados.</td>
            </tr>`;
            return;
        }
        lista_clientes.innerHTML = usuarios.map(usuario => `
            <tr>
                <td>${usuario.nombre}</td>
                <td>${usuario.email}</td>
                <td>
                    <span class="badge ${usuario.rol_usuario == 2 ? 'bg-primary' : 'bg-secondary'}">
                        ${usuario.rol_usuario == 2 ? 'Administrador' : 'Cliente'}
                    </span>
                </td>
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-${usuario.rol_usuario == 2 ? 'warning' : 'primary'} btn-cambiar-rol"
                        data-id-usuario="${usuario.id_usuario}"
                        data-rol="${usuario.rol_usuario == 2 ? 1 : 2}">
                        Cambiar a ${usuario.rol_usuario == 2 ? 'Cliente' : 'Administrador'}
                    </button>
                </td>
            </tr>
        `).join('');
    }
    else{
        iziToast.error({title: response.data.message});
    }
}

export async function buscarUsuarios(filtro){
    const response = await axios.post(`${rutaAbsoluta}/UsuarioController.php`, new URLSearchParams({
        action: 'buscarUsuarios',
        filtro: filtro
    }));
    const lista_clientes = document.getElementById('lista_clientes');
    if(response.data.result == "1"){
        const usuarios = response.data.payload || [];
        lista_clientes.innerHTML = usuarios.map(usuario => `
            <tr>
                <td>${usuario.nombre}</td>
                <td>${usuario.email}</td>
                <td>
                    <span class="badge ${usuario.rol_usuario == 2 ? 'bg-primary' : 'bg-secondary'}">
                        ${usuario.rol_usuario == 2 ? 'Administrador' : 'Cliente'}
                    </span>
                </td>
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-${usuario.rol_usuario == 2 ? 'warning' : 'primary'} btn-cambiar-rol"
                        data-id-usuario="${usuario.id_usuario}"
                        data-rol="${usuario.rol_usuario == 2 ? 1 : 2}">
                        Cambiar a ${usuario.rol_usuario == 2 ? 'Cliente' : 'Administrador'}
                    </button>
                </td>
            </tr>
        `).join('');
    } else {
        lista_clientes.innerHTML = `<tr>
            <td colspan="4" class="text-center">No hay usuarios encontrados.</td>
        </tr>`;
    }
}