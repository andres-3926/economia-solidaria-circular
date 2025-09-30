<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento']) || empty($_POST['respuesta']) || empty($_POST['pregunta_id'])) {
    header("Location: index.php");
    exit;
}

// Verifica que el usuario sea el dueño del trueque de la pregunta
$sql = "SELECT t.numero_documento FROM preguntas_trueques p JOIN trueques t ON p.trueque_id = t.id WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_POST['pregunta_id']);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

if ($row && $row['numero_documento'] == $_SESSION['numero_documento']) {
    $respuesta = trim($_POST['respuesta']);
    $pregunta_id = intval($_POST['pregunta_id']);
    $sql = "UPDATE preguntas_trueques SET respuesta=?, fecha_respuesta=NOW() WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $respuesta, $pregunta_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: trueques.php?id=" . intval($_POST['trueque_id']) . "&mensaje=Respuesta publicada");
exit;
?>