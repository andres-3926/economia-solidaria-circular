<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento'])) {
    header("Location: login.php");
    exit;
}

$numero_documento = $_SESSION['numero_documento'];
$instagram = $_POST['instagram'] ?? '';
$facebook = $_POST['facebook'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$correo = $_POST['correo'] ?? '';
$emprendimiento = $_POST['emprendimiento'] ?? '';

$sql = "UPDATE usuarios SET instagram=?, facebook=?, direccion=?, correo=?, emprendimiento=? WHERE numero_documento=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $instagram, $facebook, $direccion, $correo, $emprendimiento, $numero_documento);
$stmt->execute();
$stmt->close();

header("Location: perfil.php?mensaje=✅ Enlaces actualizados correctamente&tab=enlaces");
exit;