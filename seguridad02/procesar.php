<?php
session_start();
$nombre = $_POST['nombre'] ?? '';
echo "Hola, $nombre";