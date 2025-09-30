<?php
$host = "localhost";
$usuario = "root";
$clave = "";
$bd = "reciclandojuntas_db";

$conn = new mysqli($host, $usuario, $clave, $bd);

if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}
?>