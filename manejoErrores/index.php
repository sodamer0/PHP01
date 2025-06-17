<?php
require_once 'config/errores.php';
require_once 'clases/Producto.php';

$mensaje = '';
$producto = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['crear'])) {
            $nombre = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, [
            'options' => ['regexp' => '/^[a-zA-Z\s]+$/'] // Solo letras y espacios
            ]);
            $precio = floatval($_POST['precio']);
            $stock = intval($_POST['stock']);

            $producto = new Producto($nombre, $precio, $stock);
            $mensaje .= "<p class='success'>Producto creado: {$producto->nombre}, Precio: {$producto->getPrecio()}, Stock: {$producto->getStock()}</p>";
            $mensaje .= "<p>Total productos creados: " . Producto::getTotalProductos() . "</p>";

        } elseif (isset($_POST['reducir'])) {
            $producto = new Producto("Laptop", 1000, 10);
            $mensaje .= "<p class='success'>Producto de ejemplo creado: {$producto->nombre}, Stock: {$producto->getStock()}</p>";

            $cantidad = intval($_POST['cantidad']);
            $producto->disminuirStock($cantidad);
            $mensaje .= "<p class='success'>Stock actualizado: {$producto->getStock()}</p>";

        } elseif (isset($_POST['descuento'])) {
            $producto = new Producto("Laptop", 1000, 10);
            $mensaje .= "<p class='success'>Producto de ejemplo creado: {$producto->nombre}, Precio: {$producto->getPrecio()}</p>";

            $porcentaje = $_POST['porcentaje'];
            $descuento = $producto->calcularDescuento($porcentaje);
            $mensaje .= "<p class='success'>Descuento calculado: $descuento</p>";

        }

    } catch (PrecioInvalidoException $e) {
        $mensaje .= "<p class='error'>Error en el precio: {$e->getMessage()} (Archivo: {$e->getFile()}, Línea: {$e->getLine()})</p>";
    } catch (StockInsuficienteException $e) {
        $mensaje .= "<p class='error'>Error en el stock: {$e->getMessage()} (Archivo: {$e->getFile()}, Línea: {$e->getLine()})</p>";
    } catch (NombreDemasiadoLargoException $e) {
        $mensaje .= "<p class='error'>Error en el nombre: {$e->getMessage()} (Archivo: {$e->getFile()}, Línea: {$e->getLine()})</p>";
    } catch (InvalidArgumentException $e) {
        $mensaje .= "<p class='error'>Error en los datos: {$e->getMessage()} (Archivo: {$e->getFile()}, Línea: {$e->getLine()})</p>";
    } catch (Exception $e) {
        $mensaje .= "<p class='error'>Error inesperado: {$e->getMessage()} (Archivo: {$e->getFile()}, Línea: {$e->getLine()})</p>";
    } finally {
        $mensaje .= "<p><strong>Final: Bloque finally ejecutado.</strong></p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ejercicio: Depuración y Excepciones</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        .success { color: green; }
        .form-container { margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; }
        .debug { background-color: #f0f0f0; padding: 10px; }
    </style>
</head>
<body>
    <h2>Tienda Online: Gestión de Productos</h2>

    <div class="form-container">
        <h3>Crear Producto</h3>
        <form method="POST" action="">
            <label>Nombre: <input type="text" name="nombre"></label><br>
            <label>Precio: <input type="number" name="precio" step="0.01"></label><br>
            <label>Stock: <input type="number" name="stock"></label><br>
            <button type="submit" name="crear">Crear Producto</button>
        </form>
    </div>

    <div class="form-container">
        <h3>Reducir Stock</h3>
        <form method="POST" action="">
            <label>Cantidad: <input type="number" name="cantidad"></label><br>