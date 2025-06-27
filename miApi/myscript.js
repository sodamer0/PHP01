async function listarProductos() {
    try {
        const response = await fetch('api.php?recurso=productos');
        if (!response.ok) throw new Error('Error en la solicitud');
            const productos = await response.json();
            let html = '<table><tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th></tr>';
            productos.forEach(p => {
            html += `<tr id="row-${p.id}">
                <td>${p.id}</td>
                <td>${p.nombre}</td>
                <td>${p.precio}</td>
                <td>${p.stock}</td>
             </tr>`;
            });
            html += '</table>';
            document.getElementById('result').innerHTML = html;
            document.getElementById('result').className = 'result success';
        } catch (error) {
            document.getElementById('result').innerHTML = `<p class="error">${error.message}</p>`;
            document.getElementById('result').className = 'result error';
        }
    }

    async function crearProducto(event) { // Función para crear un Producto
    event.preventDefault(); // Prevenir el envío del formulario
        // Obtener los datos del formulario
    const data = {
            nombre: document.getElementById('nombre').value,
            precio: parseFloat(document.getElementById('precio').value),
            stock: parseInt(document.getElementById('stock').value)
        };
        try {
            const response = await fetch('api.php?recurso=productos', { // Enviar los datos al servidor
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },// Especificar el tipo de contenido
            body: JSON.stringify(data) // Convertir los datos a JSON
            });
            if (!response.ok) { // Verificar si la respuesta es correcta
                const error = await response.json(); // Si no, lanzar un error
                throw new Error(error.error);
                }
                const producto = await response.json(); // Convertir la respuesta a JSON
                document.getElementById('result').innerHTML = `<p class="success">Producto creado: ${producto.nombre}</p>`; // Mostrar mensaje de éxito
                document.getElementById('result').className = 'result success'; // Cambiar la clase del resultado
                listarProductos();//
            } catch (error) {
                document.getElementById('result').innerHTML = `<p class="error">${error.message}</p>`;
                document.getElementById('result').className = 'result error';
            }
        }


   async function buscarProducto() { // Función para buscar un Producto por ID
    const id = document.getElementById('buscarId').value; // Obtener el ID del campo de entrada

    try {
        const response = await fetch(`api.php?recurso=productos&id=${id}`); // Enviar una solicitud GET al servidor con el ID
        // Verificar si la respuesta es correcta
        if (!response.ok) throw new Error('Error en la solicitud');

        const producto = await response.json(); // Convertir la respuesta a JSON
        // Verificar si se encontró el producto
        const row = document.getElementById(`row-${producto.id}`); // Obtener la fila de la tabla correspondiente al producto
        if (row) { // Si se encontró la fila
            row.innerHTML = `<td>${producto.id}</td><td>${producto.nombre}</td><td>${producto.precio}</td><td>${producto.stock}</td>`;
            document.getElementById('result').innerHTML = `<p class="success">Producto encontrado:</p>`;
            document.getElementById('result').className = 'result success';
        } else { // Si no se encontró la fila
            document.getElementById('result').innerHTML = `<p class="error">Producto no encontrado.</p>`;
            document.getElementById('result').className = 'result error';
        }
    } catch (error) { // Manejar errores
        // Mostrar un mensaje de error si no se encuentra el producto o si hay un problema con
        document.getElementById('result').innerHTML = `<p class="error">${error.message}</p>`;
        document.getElementById('result').className = 'result error';
    }
}

// Asignar eventos a los botones y formularios
document.getElementById('formProducto').addEventListener('submit', crearProducto);
