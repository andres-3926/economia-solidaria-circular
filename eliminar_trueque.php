<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Permitir que el administrador o el dueño del trueque lo oculte (no eliminar)
    if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador') {
        $sql = "UPDATE trueques SET estado = 'inhabilitado' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    } else {
        // Solo permite ocultar trueques propios
        $numero_documento = $_SESSION['numero_documento'];
        $sql = "UPDATE trueques SET estado = 'inhabilitado' WHERE id = ? AND numero_documento = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $id, $numero_documento);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: perfil.php?mensaje=✅ Trueque eliminado correctamente&tab=trueques");
exit;
?> 