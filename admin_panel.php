<?php
session_start();
include("conexion.php");

// Verifica que el usuario sea administrador
if (!isset($_SESSION['numero_documento'])) {
    header("Location: login.php");
    exit;
}

// Consulta el rol del usuario actual
$sql = "SELECT rol FROM usuarios WHERE numero_documento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['numero_documento']);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

if (!$admin || $admin['rol'] !== 'administrador') {
    echo "<div style='color:red; text-align:center; margin-top:2rem;'>Acceso denegado. Solo los administradores pueden acceder a este panel.</div>";
    exit;
}

// Cambiar rol si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numero_documento'], $_POST['nuevo_rol'])) {
    $numero_documento = $_POST['numero_documento'];
    $nuevo_rol = $_POST['nuevo_rol'];
    $update = $conn->prepare("UPDATE usuarios SET rol = ? WHERE numero_documento = ?");
    $update->bind_param("ss", $nuevo_rol, $numero_documento);
    $update->execute();
    $update->close();

    // Si el nuevo rol es emprendedor, marca la notificación como leída
    if ($nuevo_rol === 'emprendedor') {
        // Obtener el id del usuario
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE numero_documento = ?");
        $stmt->bind_param("s", $numero_documento);
        $stmt->execute();
        $stmt->bind_result($usuario_id);
        $stmt->fetch();
        $stmt->close();

        // Marcar la notificación como leída
        $stmt = $conn->prepare("UPDATE notificaciones SET leida = 1 WHERE usuario_id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: admin_panel.php?mensaje= ✅ Rol actualizado correctamente");
    exit;
}

// Obtener todos los usuarios
$usuarios = $conn->query("SELECT numero_documento, celular, nombre_completo, correo, rol FROM usuarios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <?php
    // Mostrar notificaciones de usuarios esperando habilitación
    $notificaciones = $conn->query("SELECT n.*, u.nombre_completo FROM notificaciones n JOIN usuarios u ON n.usuario_id = u.id WHERE n.leida=0 AND u.rol != 'administrador' ORDER BY n.fecha DESC");
    while ($notif = $notificaciones->fetch_assoc()) {
        echo "<div class='alert alert-warning mb-3'>".$notif['mensaje']."</div>";
    }
    ?>
    <h2 class="mb-4 text-success">Panel de Administración de Usuarios</h2>
    <?php if (isset($_GET['mensaje'])): ?>        
        <div id="toast-alert" style="
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4caf50;
            color: #fff;
            padding: 0.7rem 1.2rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
            font-size: 1rem;
            font-weight: 500;
            z-index: 1060;
            opacity: 0;
            transform: translateY(-30%);
            transition: opacity 0.5s, transform 0.5s;
        ">
            <?php echo htmlspecialchars($_GET['mensaje']); ?>
        </div>
        <script>
            window.onload = function() {
                const toast = document.getElementById('toast-alert');
                toast.style.opacity = '1';
                toast.style.transform = 'translateY(0)';
                setTimeout(function() {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-30%)';
                }, 3500);
            };
        </script>
    <?php endif; ?>
    <table class="table table-bordered table-hover">
        <thead class="table-success">
            <tr>
                <th>Celular</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol actual</th>
                <th>Cambiar rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $usuarios->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['celular']); ?></td>
                <td><?php echo htmlspecialchars($row['nombre_completo']); ?></td>
                <td><?php echo htmlspecialchars($row['correo']); ?></td>
                <td><?php echo htmlspecialchars($row['rol']); ?></td>
                <td>
                    <?php if ($row['rol'] !== 'administrador'): ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="numero_documento" value="<?php echo htmlspecialchars($row['numero_documento']); ?>">
                        <select name="nuevo_rol" class="form-select form-select-sm d-inline w-auto">
                            <option value="usuario" <?php if($row['rol']=='usuario') echo 'selected'; ?>>Usuario</option>
                            <option value="emprendedor" <?php if($row['rol']=='emprendedor') echo 'selected'; ?>>Emprendedor</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                    </form>
                    <?php else: ?>
                        <span class="text-muted">No editable</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="usuario_pdf.php?numero_documento=<?php echo urlencode($row['numero_documento']); ?>" class="btn btn-outline-danger btn-sm" target="_blank">
                        Descargar PDF
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="perfil.php" class="btn btn-success mt-3">Volver al Perfil</a>
</div>
</body>
</html>