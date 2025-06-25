<?php

require_once 'Productos.php'; // Cargar a clase Producto

header('Content-Type: application/json'); // Indicar que o contido da miña resposta (por exemplo, desde unha API) é un obxecto JSON , non HTML, nin texto plano, nin XML.
// Configurar o cabeceiro de resposta para indicar que a resposta é JSON

// Estas liñas de código son fundamentais para capturar a información da solicitude HTTP que chega ao servidor.

$metodo = $_SERVER['REQUEST_METHOD']; // Obter o método HTTP da solicitude (GET, POST, PUT, DELETE, etc.)

$recurso = $_GET['recurso'] ?? ''; // Obter o recurso solicitado desde a URL (por exemplo, 'productos.json')

$id = $_GET['id'] ?? null; // Obter o ID do recurso solicitado, se existe.

function cargarProductos(){ // Función para cargar os produtos desde o arquivo JSON

    $json = file_get_contents('productos.json'); // Ler o contido do arquivo JSON que contén os produtos

    $data = json_decode($json, true); // Decodificar o JSON a un array asociativo: converte o código JSON en datos que se poden manipular en PHP.
    // O segundo parámetro 'true' indica que se devolve un array asociativo en vez dun obxecto PHP.


    return array_map(function($item_array) { // Función para converter cada elemento do array a un obxecto Producto

        return new Producto($item_array['id'], $item_array['nombre'], $item_array['precio'], $item_array['stock']);

    }, $data);
}

function guardarProductos($productos) { // Función para gardar os obxectos Producto no arquivo JSON

    $array = array_map(fn($item_array) => $item_array->toArray(), $productos); // Converter cada obxecto Producto a un array asociativo usando a función toArray()

    file_put_contents('productos.json', json_encode($array, JSON_PRETTY_PRINT)); // Codificar o array a JSON e gardalo no arquivo 'productos.json'. O segundo parámetro JSON_PRETTY_PRINT formatea o JSON para que sexa máis lexible.
}

$productos = cargarProductos();

try {
    if ($recurso !== 'productos') { // Verificar se o recurso solicitado é o arquivo 'productos'
        throw new Exception("Recurso no encontrado");
    }

    switch ($metodo) { // Procesar a solicitude segundo o método HTTP que se vai a utilizar
        case 'GET':
            if ($id) { // Se se especifica un ID, buscar o produto correspondente
                foreach ($productos as $producto) { // Recorrer a lista de produtos no array $productos para atopar o que coincide co ID
                    if ($producto->id == $id) {
                        echo json_encode($producto->toArray()); // Devolver o produto como un obxecto JSON
                        exit;
                    }
                }
                throw new Exception("Producto no encontrado");
            } else { // Se non se especifica un ID, devolver a lista completa de produtos
                $lista = array_map(fn($p) => $p->toArray(), $productos); // Converter cada obxecto Producto a un array asociativo usando a función toArray()
                echo json_encode($lista); // Devolver a lista de produtos como un obxecto JSON
            }
            break;

        case 'POST': // Se se utiliza o método POST, engadir un novo produto
            $data = json_decode(file_get_contents('php://input'), true); // Ler o corpo da solicitude e decodificar o JSON a un array asociativo
            if (!isset($data['nombre'], $data['precio'], $data['stock'])) { // Verificar se os campos obrigatorios están presentes
                throw new InvalidArgumentException("Faltan datos requeridos");
            }
            $nuevoId = count($productos) + 1; // Calcular un novo ID baseado no número de produtos existentes
            $producto = new Producto($nuevoId, $data['nombre'], $data['precio'], $data['stock']); // Crear un novo obxecto Producto co ID, nome, prezo e stock proporcionados
            $productos[] = $producto; // Engadir o novo produto á lista de produtos
            guardarProductos($productos); // Gardar a lista actualizada de produtos no arquivo JSON
            http_response_code(201); // Establecer o código de resposta HTTP a 201 (Creado)
            echo json_encode($producto->toArray()); // Devolver o novo produto como un obxecto JSON
            break;

        default:
            throw new Exception("Método no soportado");
        }

    } catch (PrecioInvalidoException $e) { // Excepción personalizada para erros de Precio
        http_response_code(400); // Establecer o código de resposta HTTP a 400 (Bad Request)
        echo json_encode(['error' => "Error en el precio: " . $e->getMessage()]); // Devolver un obxecto JSON co erro
    } catch (InvalidArgumentException $e) { // Excepción para erros de argumentos inválidos
        http_response_code(400);
        echo json_encode(['error' => "Error en los datos: " . $e->getMessage()]); //
    } catch (Exception $e) { // Excepción xeral para outros erros
        http_response_code($e->getMessage() === "Recurso no encontrado" ? 404 : 405);
        echo json_encode(['error' => $e->getMessage()]); //
    }


?>