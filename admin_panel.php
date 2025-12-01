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

// Cambiar rol o estado si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['numero_documento'], $_POST['nuevo_rol'])) {
        $numero_documento = $_POST['numero_documento'];
        $nuevo_rol = $_POST['nuevo_rol'];
        $update = $conn->prepare("UPDATE usuarios SET rol = ? WHERE numero_documento = ?");
        $update->bind_param("ss", $nuevo_rol, $numero_documento);
        $update->execute();
        $update->close();

        // Si el nuevo rol es emprendedor, marca la notificación como leída
        if ($nuevo_rol === 'emprendedor') {
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE numero_documento = ?");
            $stmt->bind_param("s", $numero_documento);
            $stmt->execute();
            $stmt->bind_result($usuario_id);
            $stmt->fetch();
            $stmt->close();
            $stmt = $conn->prepare("UPDATE notificaciones SET leida = 1 WHERE usuario_id = ?");
            $stmt->bind_param("i", $usuario_id);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: admin_panel.php?mensaje= ✅ Rol actualizado correctamente");
        exit;
    }
    // Habilitar/Inhabilitar usuario
    if (isset($_POST['numero_documento_estado'], $_POST['accion_estado'])) {
        $numero_documento = $_POST['numero_documento_estado'];
        $accion = $_POST['accion_estado'];
        // Si el botón es inhabilitar, el rol pasa a 'usuario'. Si es habilitar, el rol pasa a 'emprendedor'.
        if ($accion === 'inhabilitar') {
            $nuevo_rol = 'usuario';
            // Ocultar trueques publicados por el emprendedor
            $stmt = $conn->prepare("UPDATE trueques SET estado = 'inhabilitado' WHERE numero_documento = ?");
            $stmt->bind_param("s", $numero_documento);
            $stmt->execute();
            $stmt->close();
        } else {
            $nuevo_rol = 'emprendedor';
            // Opcional: puedes habilitar los trueques si lo deseas
            $stmt = $conn->prepare("UPDATE trueques SET estado = 'activo' WHERE numero_documento = ?");
            $stmt->bind_param("s", $numero_documento);
            $stmt->execute();
            $stmt->close();
        }
        $update = $conn->prepare("UPDATE usuarios SET rol = ? WHERE numero_documento = ?");
        $update->bind_param("ss", $nuevo_rol, $numero_documento);
        $update->execute();
        $update->close();
        header("Location: admin_panel.php?mensaje= ✅ Estado actualizado correctamente");
        exit;
    }
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
<body style="padding-top:75px;">
<div class="container mt-5">
    <?php
    // Mostrar notificaciones de usuarios esperando habilitación
    $notificaciones = $conn->query("SELECT n.*, u.nombre_completo FROM notificaciones n JOIN usuarios u ON n.usuario_id = u.id WHERE n.leida=0 AND u.rol != 'administrador' ORDER BY n.fecha DESC");
    while ($notif = $notificaciones->fetch_assoc()) {
        echo "<div class='alert alert-warning mb-3'>".$notif['mensaje']."</div>";
    }
    ?>
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-2 px-lg-5">
            <h2 class="m-0 text-shadow titulo-navbar text-break" style="color: #43be16;"><i class="fa-solid fa-recycle fa-beat fa-xl me-2"></i>Economía Solidaria y Circular</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link fw-bold">Inicio</a>
                <a href="trueques.php" class="nav-item nav-link fw-bold">Trueques</a>
                <a href="aprende.php" class="nav-item nav-link fw-bold">Aprende</a>
                <?php
                if (isset($_SESSION['numero_documento'])) {
                    $nombre_usuario = '';
                    $sql_nombre = "SELECT nombre_completo FROM usuarios WHERE numero_documento = ?";
                    $stmt_nombre = $conn->prepare($sql_nombre);
                    $stmt_nombre->bind_param("s", $_SESSION['numero_documento']);
                    $stmt_nombre->execute();
                    $res_nombre = $stmt_nombre->get_result();
                    if ($row_nombre = $res_nombre->fetch_assoc()) {
                        $nombre_usuario = $row_nombre['nombre_completo'];
                    }
                    $stmt_nombre->close();
                    echo '<a href="perfil.php" class="nav-item nav-link fw-bold" style="color:#43be16 !important;font-weight:bold !important;">'.($nombre_usuario ? htmlspecialchars($nombre_usuario) : 'Perfil').'</a>';
                }
                ?>
            </div>
        </div>
    </nav>
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
                    <form method="POST" style="display:inline; margin-left:5px;">
                        <input type="hidden" name="numero_documento_estado" value="<?php echo htmlspecialchars($row['numero_documento']); ?>">
                        <?php if ($row['rol'] === 'usuario'): ?>
                            <button type="submit" name="accion_estado" value="habilitar" class="btn btn-success btn-sm">Habilitar</button>
                        <?php elseif ($row['rol'] === 'emprendedor'): ?>
                            <button type="submit" name="accion_estado" value="inhabilitar" class="btn btn-danger btn-sm">Inhabilitar</button>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="perfil.php" class="btn btn-success mt-3">Volver al Perfil</a>
</div>
</body>
</html>