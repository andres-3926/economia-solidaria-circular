<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_documento = $_SESSION['numero_documento'];
    $categoria = $_POST['categoria'];
    $subcategoria = $_POST['subcategoria'];
    $que_ofreces = $_POST['que_ofreces'];
    $que_necesitas = $_POST['que_necesitas'];
    $descripcion = $_POST['descripcion'];
    $barrio = $_POST['barrio'];    
    $fecha = date('Y-m-d H:i:s');
    
    //Determinar el estado según el boton presionado
    if (isset($_POST['accion'])) {
    if ($_POST['accion'] === 'publicar') {
        $estado = 'activo';
    } elseif ($_POST['accion'] === 'pendiente') {
        $estado = 'pendiente';
    } elseif ($_POST['accion'] === 'cancelado') {
        $estado = 'cancelado';
    } else {
        $estado = 'pendiente';
    }
    } else {
    $estado = 'pendiente';
    }
    
    $sql = "INSERT INTO trueques (numero_documento, categoria, subcategoria, que_ofreces, que_necesitas, descripcion, barrio, fecha_publicacion, estado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $numero_documento, $categoria, $subcategoria, $que_ofreces, $que_necesitas, $descripcion, $barrio, $fecha, $estado);
    $stmt->execute();
    $id_trueque = $conn->insert_id;
    $stmt->close();

    // Validar máximo 3 imágenes
    if (!empty($_FILES['imagenes']['name'][0]) && $id_trueque) {
        if (count($_FILES['imagenes']['name']) > 3) {
            // Borra el trueque recién creado si hay demasiadas imágenes
            $conn->query("DELETE FROM trueques WHERE id = $id_trueque");
            die('Solo puedes subir un máximo de 3 imágenes por trueque.');
        }
        $ruta_base = "uploads/trueques/";
        if (!is_dir($ruta_base)) {
            mkdir($ruta_base, 0777, true);
        }
        foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
            $nombre_archivo = uniqid() . "_" . basename($_FILES['imagenes']['name'][$key]);
            $ruta_destino = $ruta_base . $nombre_archivo;
            if (move_uploaded_file($tmp_name, $ruta_destino)) {
                $stmt = $conn->prepare("INSERT INTO imagenes_trueque (trueque_id, ruta_imagen) VALUES (?, ?)");
                $stmt->bind_param("is", $id_trueque, $ruta_destino);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    $mensaje = ($estado === 'pendiente') ? "✅ Trueque guardado como pendiente" : "✅ Trueque publicado exitosamente";
    header("Location: perfil.php?mensaje=" . urlencode($mensaje) . "&tab=trueques");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar Trueque</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Publicar un nuevo Trueque</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label fw-bold">¿Qué ofreces?</label>
            <input type="text" name="que_ofreces" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">¿Qué necesitas a cambio?</label>
            <input type="text" name="que_necesitas" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Descripción breve</label>
            <textarea name="descripcion" class="form-control" rows="2" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Imágenes del Trueque (máximo 3)</label>
            <input type="file" name="imagenes[]" class="form-control" accept="image/*" multiple>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Barrio</label>
            <input type="text" name="barrio" class="form-control" required>
        </div>       
        <div class="d-flex gap-2">
        <button type="submit" name="accion" value="publicar" class="btn btn-success">
                <i class="fa fa-check"></i> Publicar Trueque
            </button>
            <button type="submit" name="accion" value="pendiente" class="btn btn-warning text-white">
                <i class="fa fa-save"></i> Guardar como Pendiente
            </button>
            <a href="perfil.php" class="btn btn-secondary ms-2">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>