<?php
session_start();
$nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
echo "Hola, $nombre";