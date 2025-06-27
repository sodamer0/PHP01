<?php
header('Content-Type: application/json; charset=utf-8');

$products = [  //array de arrays
    [
        "id" => 1,
        "nombre" => "Laptop",
        "precio" => 1000,
        "stock" => 10
    ],
    [
        "id" => 2,
        "nombre" => "Teléfono",
        "precio" => 500,
        "stock" => 20
    ],
    [
        "id" => 3,
        "nombre" => "coche",
        "precio" => 2200,
        "stock" => 2
    ]
];

echo json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>