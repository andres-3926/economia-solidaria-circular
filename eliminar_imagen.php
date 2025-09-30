<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['imagen_id'])) {
    $imagen_id = intval($_POST['imagen_id']);

    // Obtener el usuario actual
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE numero_documento = ?");
    $stmt->bind_param("s", $_SESSION['numero_documento']);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
    $stmt->close();

    if ($usuario) {
        // Verificar que la imagen pertenezca al usuario
        $stmt = $conn->prepare("SELECT ruta_imagen FROM imagenes_emprendimiento WHERE id = ? AND usuario_id = ?");
        $stmt->bind_param("ii", $imagen_id, $usuario['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $img = $result->fetch_assoc();
        $stmt->close();

        if ($img) {
            // Eliminar el archivo físico
            if (file_exists($img['ruta_imagen'])) {
                unlink($img['ruta_imagen']);
            }
            // Eliminar el registro de la base de datos
            $stmt = $conn->prepare("DELETE FROM imagenes_emprendimiento WHERE id = ?");
            $stmt->bind_param("i", $imagen_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

header("Location: perfil.php?mensaje= ✅ ¡Imagen eliminada!");
exit;
?>