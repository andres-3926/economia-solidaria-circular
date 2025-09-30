<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento'])) {
    header("Location: login.php");
    exit;
}

$numero_documento = $_SESSION['numero_documento'];

// Obtener datos del trueque
if (!isset($_GET['id'])) {
    header("Location: perfil.php?mensaje=❌ Trueque no especificado");
    exit;
}
$id = intval($_GET['id']);

$is_admin = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador');
if ($is_admin) {
    $sql = "SELECT * FROM trueques WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
} else {
    $sql = "SELECT * FROM trueques WHERE id = ? AND numero_documento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $numero_documento);
}
$stmt->execute();
$result = $stmt->get_result();
$trueque = $result->fetch_assoc();
$stmt->close();

if (!$trueque) {
    header("Location: perfil.php?mensaje=❌ Trueque no encontrado o no autorizado");
    exit;
}

// Procesar actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $is_admin = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador');
    $fecha_expiracion = null;
    if ($is_admin && isset($_POST['fecha_expiracion']) && !empty($_POST['fecha_expiracion'])) {
        $fecha_expiracion = $_POST['fecha_expiracion'];
        // Validar que no sea mayor a 30 días desde hoy
        $max_fecha = date('Y-m-d', strtotime('+30 days'));
        if ($fecha_expiracion > $max_fecha) {
            $fecha_expiracion = $max_fecha;
        }
        // Cargar los valores actuales para no sobrescribirlos
        $que_ofreces = $trueque['que_ofreces'];
        $que_necesitas = $trueque['que_necesitas'];
        $descripcion = $trueque['descripcion'];
        $barrio = $trueque['barrio'];
        $estado = $trueque['estado'];
    } else {
        $que_ofreces = $_POST['que_ofreces'];
        $que_necesitas = $_POST['que_necesitas'];
        $descripcion = $_POST['descripcion'];
        $barrio = $_POST['barrio'];
        $estado = $_POST['estado'];
    }

    if ($is_admin) {
        $sql = "UPDATE trueques SET que_ofreces=?, que_necesitas=?, descripcion=?, barrio=?, estado=?, fecha_expiracion=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $que_ofreces, $que_necesitas, $descripcion, $barrio, $estado, $fecha_expiracion, $id);
    } else {
        $sql = "UPDATE trueques SET que_ofreces=?, que_necesitas=?, descripcion=?, barrio=?, estado=? WHERE id=? AND numero_documento=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $que_ofreces, $que_necesitas, $descripcion, $barrio, $estado, $id, $numero_documento);
    }
    $stmt->execute();
    $stmt->close();

    header("Location: perfil.php?mensaje=✅ Trueque actualizado correctamente&tab=trueques");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Trueque</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Editar Trueque</h3>
    <?php if ($is_admin): ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Fecha de expiración (máx. 30 días)</label>
                <input type="date" name="fecha_expiracion" class="form-control"
                    min="<?php echo date('Y-m-d'); ?>"
                    max="<?php echo date('Y-m-d', strtotime('+30 days')); ?>"
                    value="<?php echo !empty($trueque['fecha_expiracion']) ? htmlspecialchars($trueque['fecha_expiracion']) : ''; ?>">
                <small class="text-muted">El trueque se despublicará automáticamente después de esta fecha.</small>
            </div>
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar cambios</button>
            <a href="perfil.php" class="btn btn-secondary ms-2">Cancelar</a>
        </form>
    <?php else: ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-bold">¿Qué ofreces?</label>
                <input type="text" name="que_ofreces" class="form-control" value="<?php echo htmlspecialchars($trueque['que_ofreces']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">¿Qué necesitas a cambio?</label>
                <input type="text" name="que_necesitas" class="form-control" value="<?php echo htmlspecialchars($trueque['que_necesitas']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Descripción breve</label>
                <textarea name="descripcion" class="form-control" rows="2" required><?php echo htmlspecialchars($trueque['descripcion']); ?></textarea>
            </div>
            <div class="mb-3 text-center">
                <label class="form-label fw-bold d-block">Foto</label>
                <img id="preview-img" src="uploads/<?php echo htmlspecialchars($trueque['foto']); ?>" alt="Previsualización"
                    style="width: 120px; height: 120px; border: 3px solid #43be16; object-fit: cover; margin-bottom: 10px;">
                <input type="file" name="foto" class="form-control mt-2" accept="image/*" onchange="previewImage(event)">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Barrio</label>
                <input type="text" name="barrio" class="form-control" value="<?php echo htmlspecialchars($trueque['barrio']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Estado</label>
                <select name="estado" class="form-select">
                    <option value="activo" <?php if($trueque['estado']=='activo') echo 'selected'; ?>>Publicar</option>
                    <option value="pendiente" <?php if($trueque['estado']=='pendiente') echo 'selected'; ?>>Pendiente</option>
                    <option value="cancelado" <?php if($trueque['estado']=='cancelado') echo 'selected'; ?>>Cancelar</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar cambios</button>
            <a href="perfil.php" class="btn btn-secondary ms-2">Cancelar</a>
        </form>
    <?php endif; ?>
</div>
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('preview-img').src = reader.result;
    }
    if(event.target.files[0]){
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>
</body>
</html>