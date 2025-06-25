async function listarProductos() {
    try {
        const response = await fetch('api.php?recurso=productos');
        if (!response.ok) throw new Error('Error en la solicitud');
            const productos = await response.json();
            let html = '<table><tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th></tr>';
            productos.forEach(p => {
            html += `<tr><td>${p.id}</td><td>${p.nombre}</td><td>${p.precio}</td><td>${p.stock}</td></tr>`;
            });
            html += '</table>';
            document.getElementById('result').innerHTML = html;
            document.getElementById('result').className = 'result success';
        } catch (error) {
            document.getElementById('result').innerHTML = `<p class="error">${error.message}</p>`;
            document.getElementById('result').className = 'result error';
        }
    }

    async function crearProducto(event) {
    event.preventDefault();
    const data = {
            nombre: document.getElementById('nombre').value,
            precio: parseFloat(document.getElementById('precio').value),
            stock: parseInt(document.getElementById('stock').value)
        };
        try {
            const response = await fetch('api.php?recurso=productos', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
            });
            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.error);
                }
                const producto = await response.json();
                document.getElementById('result').innerHTML = `<p class="success">Producto creado: ${producto.nombre}</p>`;
                document.getElementById('result').className = 'result success';
                listarProductos();
            } catch (error) {
                document.getElementById('result').innerHTML = `<p class="error">${error.message}</p>`;
                document.getElementById('result').className = 'result error';
            }
        }

    listarProductos();