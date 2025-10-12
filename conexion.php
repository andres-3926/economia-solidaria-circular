<?php
$host = "127.0.0.1";
$usuario = "andres_echeverri";
$clave = "";
$bd = "reciclandojuntas_db";

$conn = new mysqli($host, $usuario, $clave, $bd);

if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}else {
    echo "Conexión exitosa a la base de datos.";
}
?>