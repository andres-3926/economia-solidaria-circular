<?php
session_start();
include("conexion.php");

// Verificar que se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $documento = trim($_POST['documento_recuperar'] ?? '');
    $nombre_completo = trim($_POST['nombre_recuperar'] ?? '');
    $celular = trim($_POST['celular_recuperar'] ?? '');

    // Validar que no estén vacíos
    if (empty($documento) || empty($nombre_completo) || empty($celular)) {
        $mensaje = "⚠️ Todos los campos son obligatorios para verificar tu identidad.";
        header("Location: login.php?error=" . urlencode($mensaje));
        exit;
    }

    // CORRECCIÓN: Buscar usuario SIN restricción de habilitado
    // o incluir tanto habilitado = 0 como habilitado = 1
    $stmt = $conn->prepare("SELECT id, numero_documento, nombre_completo, celular, correo FROM usuarios WHERE numero_documento = ? AND nombre_completo = ? AND celular = ?");
    $stmt->bind_param("sss", $documento, $nombre_completo, $celular);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        
        // Generar código temporal de 6 dígitos
        $codigo_temporal = sprintf('%06d', rand(100000, 999999));
        
        // Guardar en sesión
        $_SESSION['reset_code'] = $codigo_temporal;
        $_SESSION['reset_user_id'] = $usuario['id'];
        $_SESSION['reset_timestamp'] = time(); // Para expirar en 10 minutos
        $_SESSION['reset_documento'] = $documento;
        
        // Redirigir a página de restablecimiento
        header("Location: restablecer_password.php?found=1");
        exit;
        
    } else {
        $mensaje = "❌ Los datos ingresados no coinciden con ningún usuario registrado. Verifica tu información.";
        header("Location: login.php?error=" . urlencode($mensaje));
        exit;
    }

    $stmt->close();
} else {
    $mensaje = "⚠️ Acceso no válido.";
    header("Location: login.php?error=" . urlencode($mensaje));
    exit;
}

$conn->close();
?>
