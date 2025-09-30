<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento'])) {
    header("Location: login.php");
    exit;
}

// Obtener el usuario
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE numero_documento = ?");
$stmt->bind_param("s", $_SESSION['numero_documento']);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

if (!$usuario) {
    header("Location: perfil.php?error=Usuario no encontrado");
    exit;
}

$usuario_id = $usuario['id'];

// Guardar la reseña
if (isset($_POST['resena']) && trim($_POST['resena']) !== '') {
    $resena = trim($_POST['resena']);
    $stmt = $conn->prepare("UPDATE usuarios SET resena = ? WHERE id = ?");
    $stmt->bind_param("si", $resena, $usuario_id);
    $stmt->execute();
    $stmt->close();
}

// Subir imágenes
if (!empty($_FILES['imagenes']['name'][0])) {
    $ruta_base = "uploads/productos/";
    if (!is_dir($ruta_base)) {
        mkdir($ruta_base, 0777, true);
    }
    foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
        $nombre_archivo = basename($_FILES['imagenes']['name'][$key]);
        $ruta_destino = $ruta_base . uniqid() . "_" . $nombre_archivo;
        if (move_uploaded_file($tmp_name, $ruta_destino)) {
            $stmt = $conn->prepare("INSERT INTO imagenes_emprendimiento (usuario_id, ruta_imagen) VALUES (?, ?)");
            $stmt->bind_param("is", $usuario_id, $ruta_destino);
            $stmt->execute();
            $stmt->close();
        }
    }
}

header("Location: perfil.php?mensaje= ✅ ¡Reseña e imágenes actualizadas!");
exit;
?>