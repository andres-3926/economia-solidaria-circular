<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Solo permite eliminar trueques del usuario logueado
    $numero_documento = $_SESSION['numero_documento'];
    $sql = "DELETE FROM trueques WHERE id = ? AND numero_documento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $numero_documento);
    $stmt->execute();
    $stmt->close();
}

header("Location: perfil.php?mensaje=✅ Trueque eliminado correctamente&tab=trueques");
exit;
?> 