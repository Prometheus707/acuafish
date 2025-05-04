import rutaAbsoluta from "../../../rutaAbsoluta/rutaAbsoluta.js";
import rutaImagenes from "../../../rutaAbsoluta/rutaImagenes.js";
export async function listarPorCategoria() {
    const categoriaSelectClient = document.getElementById('categoriaSelectClient');
    const contenedorProductos = document.getElementById('productosContainer');
    categoriaSelectClient.addEventListener('change', async (event) => {
        const categoriaId = event.target.value;
        try {
            const response = await axios.post(`${rutaAbsoluta}/ProductoController.php`, new URLSearchParams({
                action: 'listarProductos',
                categoriaId: categoriaId
            }));
            const productos = response.data.payload || [];
            contenedorProductos.innerHTML = productos.map(producto => {
                // Si la ruta ya es absoluta, úsala tal cual, si no, concatena
                let imagenSrc = '';
                if (producto.imagen_url) {
                    imagenSrc = rutaImagenes + producto.imagen_url;
                }
                return `
                <div class="col producto-card" data-categoria="${producto.categoria}">
                    <div class="card h-100">
                        ${producto.imagen_url
                             ? `<img src="${imagenSrc}" class="card-img-top obj
                                ect-fit-cover bg-light" style="height: 150px; object-fit: cover;" alt="${producto.nombre}">`
                            : `<div class="d-flex align-items-center justify-content-center bg-light" style="height: 150px;">
                                    <i class="bi bi-image text-secondary" style="font-size: 2.5rem;"></i>
                               </div>`
                        }
                        <div class="card-body">
                            <h5 class="card-title mb-1">${producto.nombre}</h5>
                            <span class="badge rounded-pill bg-info text-dark mb-2" title="Stock disponible">
                                ${producto.stock} en stock
                            </span>
                            <p class="card-text">${producto.descripcion}</p>
                            <div class="d-flex justify-content-between align-items-end mt-3">
                                <span class="fw-bold">$${producto.precio}</span>
                                <button class="btn btn-primary btn-sm" data-id-producto="${producto.id_productos}">Añadir</button>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            }).join('');
        } catch (error) {
            console.error('Error al cargar productos por categoría:', error);
        }
    });
    // Esto solo se ejecuta una vez al cargar la página
    categoriaSelectClient.dispatchEvent(new Event('change'));
}