<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir y sanitizar los datos del formulario
    $tipo_documento = isset($_POST['tipo_documento']) ? trim($_POST['tipo_documento']) : '';
    $numero_documento = isset($_POST['numero_documento']) ? trim($_POST['numero_documento']) : '';
    $nombre_completo = isset($_POST['nombre_completo']) ? trim($_POST['nombre_completo']) : '';
    $celular = isset($_POST['celular']) ? trim($_POST['celular']) : '';
    $correo = isset($_POST['email']) ? trim($_POST['email']) : '';
    $contraseña = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';
    $emprendimiento = isset($_POST['emprendimiento']) ? trim($_POST['emprendimiento']) : '';
    $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
    $comuna = isset($_POST['comuna']) ? trim($_POST['comuna']) : '';
    $barrio = isset($_POST['barrio']) ? trim($_POST['barrio']) : '';

    // validar que emprendimiento y direccion no estén vacíos
    if (empty($emprendimiento) || empty($direccion)) {
        echo "❌ Debes ingresar el nombre del emprendimiento y la dirección.";
        exit();
    }


    // Validar que no exista el usuario por número de documento o correo
    $query_check = "SELECT id FROM usuarios WHERE numero_documento = ? OR correo = ? LIMIT 1";
    if ($stmt_check = $conn->prepare($query_check)) {
        $stmt_check->bind_param("ss", $numero_documento, $correo);
        $stmt_check->execute();
        $stmt_check->store_result();
        if ($stmt_check->num_rows > 0) {
            $mensaje = urlencode("❌ Ya existe un usuario con ese número de documento o correo.");
            header("Location: registro.php?mensaje=$mensaje&from=registro");
            $stmt_check->close();
            $conn->close();
            exit();
        }
        $stmt_check->close();
    } else {
    $mensaje = urlencode("Error al validar usuario existente: " . $conn->error);
    header("Location: registro.php?mensaje=$mensaje&from=registro");
    $conn->close();
    exit();
    }

    // Encriptar la contraseña
    $contrasena_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Preparar la consulta con backticks para columnas con caracteres especiales
    $query = "INSERT INTO usuarios (`numero_documento`, `tipo_documento`, `nombre_completo`, `celular`, `correo`, `contrasena`, `emprendimiento`, `direccion`, `comuna`, `barrio`) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la sentencia
    if ($stmt = $conn->prepare($query)) {
        // Vincular los parámetros
        $stmt->bind_param("ssssssssss", $numero_documento, $tipo_documento, $nombre_completo, $celular, $correo, $contrasena_hash, $emprendimiento, $direccion, $comuna, $barrio);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Registro exitoso, redirigir al login
            header("Location: login.php?mensaje= ✅ ¡Registro exitoso!");
            exit();
        } else {
            // Error al insertar
            $mensaje = urlencode("Error al registrar el usuario: " . $stmt->error);
            header("Location: registro.php?mensaje=$mensaje&from=registro");
        }

        $stmt->close();
    } else {
    $mensaje = urlencode("Error en la preparación de la consulta: " . $conn->error);
    header("Location: registro.php?mensaje=$mensaje&from=registro");
    }

    $conn->close();
} else {
    // Si alguien accede directamente a este archivo, redirigir al formulario
    header("Location: login.php");
    exit();
}
?>
