<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero_documento = $_SESSION['numero_documento'];
    $nombre_completo = trim($_POST['nombre_completo'] ?? '');
    $celular = trim($_POST['celular'] ?? '');
    $barrio = trim($_POST['barrio'] ?? '');
    $emprendimiento = trim($_POST['emprendimiento'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');

    // Puedes agregar validaciones aquí si lo deseas

    $sql = "UPDATE usuarios SET nombre_completo = ?, celular = ?, barrio = ?, emprendimiento = ?, direccion = ? WHERE numero_documento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nombre_completo, $celular, $barrio, $emprendimiento, $direccion, $numero_documento);

    if ($stmt->execute()) {
        $mensaje = urlencode("✅ Perfil actualizado correctamente.");
    } else {
        $mensaje = urlencode("❌ Error al actualizar el perfil.");
    }
    $stmt->close();
    $conn->close();

    header("Location: perfil.php?mensaje=$mensaje");
    exit;
} else {
    header("Location: perfil.php");
    exit;
}
?>