<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "UPDATE trueques SET estado = 'activo' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: perfil.php?mensaje=✅ Trueque activado correctamente&tab=trueques");
exit;
?>
