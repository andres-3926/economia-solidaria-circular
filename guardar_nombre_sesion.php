<?php
session_start();
if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
    $_SESSION['nombre'] = $_POST['nombre'];
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Nombre vacío']);
}
?>
