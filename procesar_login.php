<?php
session_start();
include("conexion.php");

// Verificar que se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Capturar los datos del formulario
    $documento = $_POST['documento'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    // Validar que no estén vacíos
    if (empty($documento) || empty($contrasena)) {
        echo "⚠️ Debes ingresar numero de documento y contraseña.";
        exit;
    }

    // Preparar la consulta para buscar el usuario
    $stmt = $conn->prepare("SELECT id, nombre_completo, contrasena, habilitado, rol FROM usuarios WHERE numero_documento = ?");
    $stmt->bind_param("s", $documento);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificar la contraseña con password_verify
        if (password_verify($contrasena, $usuario['contrasena'])) {
            $_SESSION['numero_documento'] = $documento;
            $_SESSION['rol'] = $usuario['rol'];
            
            // Notificación para el administrador si el usuario no está habilitado
            if (
                isset($usuario['habilitado']) && 
                $usuario['habilitado'] == 0 && 
                strtolower(trim($usuario['rol'])) != 'administrador'
                ) {
                // Verifica si ya existe una notificación para este usuario sin leer
                $sql_check = "SELECT id FROM notificaciones WHERE usuario_id=? AND leida=0";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->bind_param("i", $usuario['id']);
                $stmt_check->execute();
                $stmt_check->store_result();
                if ($stmt_check->num_rows == 0) {
                    // Si no existe, la crea
                    $mensaje = "El usuario {$usuario['nombre_completo']} está esperando habilitación como emprendedor.";
                    $sql_notif = "INSERT INTO notificaciones (usuario_id, mensaje) VALUES (?, ?)";
                    $stmt_notif = $conn->prepare($sql_notif);
                    $stmt_notif->bind_param("is", $usuario['id'], $mensaje);
                    $stmt_notif->execute();
                    $stmt_notif->close();
                }
                 $stmt_check->close();
            }
             //Redirigir al dashboard
            header("Location: index.php");
            exit;
        } else {
            header('Location: login.php?error=❌ Contraseña incorrecta.');
            exit;
        }
    } else {
        header('Location: login.php?error=❌ No existe un usuario con ese numero de documento.');
        exit;
    }

    $stmt->close();
} else {
    header('Location: login.php?error=⚠️ Acceso no válido.');
    exit;
}

$conn->close();
?>
