<?php
header('Content-Type: application/json; charset=utf-8');

$products = [
    ["id" => 1, "nombre" => "Laptop", "precio" => 1000, "stock" => 10],
    ["id" => 2, "nombre" => "Teléfono", "precio" => 500, "stock" => 20],
    ["id" => 3, "nombre" => "coche", "precio" => 2200, "stock" => 2]
];

$response = [
    "status" => "success",
    "data" => $products
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>