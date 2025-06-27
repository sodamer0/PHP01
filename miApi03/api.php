<?php



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'vendor/autoload.php'; // Cargar el autoloader de Composer
require_once 'Productos.php'; // Cargar la clase Producto

// Inicializar Flight
Flight::init(); 

// Configurar cabeceras CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json'); // Indicar que el contenido de la respuesta es JSON
// (por ejemplo, desde una API) es un objeto JSON, no HTML, ni texto plano, ni XML.

// Funciones para cargar y guardar productos
function cargarProductos() {
    $file = __DIR__ . '/productos.json';
    if (!file_exists($file)) {
        return [];
    }
    
    $json = file_get_contents($file);
    if ($json === false) {
        throw new Exception('No se pudo leer el archivo de productos');
    }
    
    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Error al decodificar el JSON: ' . json_last_error_msg());
    }
    
    // Convertir a array de objetos Producto
    $productos = [];
    foreach ($data as $item) {
        $productos[] = new Producto(
            $item['id'] ?? 0,
            $item['nombre'] ?? '',
            $item['precio'] ?? 0,
            $item['stock'] ?? 0
        );
    }
    
    return $productos;
}

function guardarProductos($productos) { // Función para guardar los productos en el archivo JSON
    $array = array_map(fn($p) => $p->toArray(), $productos); // Convertir cada objeto Producto a un array asociativo
    file_put_contents('productos.json', json_encode($array, JSON_PRETTY_PRINT)); // Codificar el array a JSON y guardar en el archivo 'productos.json'
}


// Ruta raíz para verificar que la API está funcionando
Flight::route('GET /', function() {
    echo 'API de Productos funcionando correctamente';
});

// Ruta GET /productos -> lista todos los productos
Flight::route('GET /productos', function() {
    try {
        $productos = cargarProductos();
        Flight::json($productos);
    } catch (Exception $e) {
        Flight::halt(500, json_encode(['error' => $e->getMessage()]));
    }
});

// Ruta GET /productos/@id -> producto por id
Flight::route('GET /productos/@id', function($id) {// Ruta GET /productos/@id -> producto por id
    $productos = cargarProductos(); // Cargar los productos desde el archivo JSON
    foreach ($productos as $producto) { // Recorrer los productos
        if ($producto->id == $id) { // Si el producto coincide con el id
            Flight::json($producto->toArray()); // Devolver el producto como un array JSON
            return;
        }
    }// Devolver un error si el producto no se encuentra
    Flight::halt(404, json_encode(['error' => 'Producto no encontrado'])); 
});
//

// Ruta POST /productos -> crear producto
Flight::route('POST /productos', function() { // Ruta POST /productos -> crear producto
    $data = json_decode(file_get_contents('php://input'), true); // Leer el contenido del archivo JSON

    try { // Try catch para manejar errores
        if (!isset($data['nombre'], $data['precio'], $data['stock'])) { // Si faltan datos requeridos
            throw new InvalidArgumentException("Faltan datos requeridos"); // Lanza una excepción
        }

        $productos = cargarProductos(); // Cargar los productos desde el archivo JSON
        $nuevoId = count($productos) + 1; // Generar un nuevo id

        $producto = new Producto($nuevoId, $data['nombre'], $data['precio'], $data['stock']); // Crear un nuevo producto
        $productos[] = $producto; // Agregar el producto al array
        guardarProductos($productos); // Guardar los productos en el archivo JSON

        Flight::json($producto->toArray(), 201); // Devolver el producto creado

    } catch (PrecioInvalidoException $e) { // Si el precio es inválido
        Flight::halt(400, json_encode(['error' => "Error en el precio: " . $e->getMessage()])); // Lanza una excepción
    } catch (InvalidArgumentException $e) { // Si los datos son inválidos
        Flight::halt(400, json_encode(['error' => "Error en los datos: " . $e->getMessage()])); // Lanza una excepción
    } catch (Exception $e) { // Si hay un error
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }
});

Flight::start(); // Iniciar la aplicación

