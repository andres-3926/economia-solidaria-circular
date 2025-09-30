<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $numero_documento = $_SESSION['numero_documento'];
    $foto = $_FILES['foto'];

    $permitidos = ['image/jpeg', 'image/png', 'image/jpg'];
    if (in_array($foto['type'], $permitidos) && $foto['size'] <= 2*1024*1024) {
        $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
        $nombre_archivo = $numero_documento . '_' . time() . '.' . $ext;
        $ruta = 'uploads/' . $nombre_archivo;

        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($foto['tmp_name'], $ruta)) {
            $stmt = $conn->prepare("UPDATE usuarios SET foto = ? WHERE numero_documento = ?");
            $stmt->bind_param("ss", $nombre_archivo, $numero_documento);
            $stmt->execute();
            $stmt->close();
            header("Location: perfil.php?mensaje=✅ Foto actualizada correctamente");
            exit;
        } else {
            header("Location: perfil.php?mensaje=❌ Error al subir la foto");
            exit;
        }
    } else {
        header("Location: perfil.php?mensaje=❌ Archivo no permitido o demasiado grande (máx 2MB)");
        exit;
    }
} else {
    header("Location: perfil.php");
    exit;
}
?>