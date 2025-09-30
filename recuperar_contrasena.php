<?php
session_start();
include("conexion.php");

// Verificar que se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $documento = $_POST['documento_recuperar'] ?? '';

    // Validar que no esté vacío
    if (empty($documento)) {
        $mensaje = "⚠️ Debes ingresar tu número de documento.";
        header("Location: login.php?mensaje=" . urlencode($mensaje));
        exit;
    }

    // Buscar el usuario en la base de datos
    $stmt = $conn->prepare("SELECT celular, contrasena FROM usuarios WHERE numero_documento = ?");
    $stmt->bind_param("s", $documento);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Aquí podrías enviar la contraseña por correo o mostrar un mensaje temporal
        // Para este ejemplo solo mostramos un mensaje
        $mensaje = " ✅ Usuario encontrado. Número de celular asociado: " . $usuario['celular'];
        header("Location: login.php?mensaje=" . urlencode($mensaje));
        exit;
    } else {
        $mensaje = "❌ No existe un usuario con ese número de documento.";
        header("Location: login.php?mensaje=" . urlencode($mensaje));
        exit;
    }

    $stmt->close();
} else {
    $mensaje = "⚠️ Acceso no válido.";
    header("Location: login.php?mensaje=" . urlencode($mensaje));
    exit;
}

$conn->close();
?>
