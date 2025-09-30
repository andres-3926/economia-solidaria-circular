<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento']) || empty($_POST['pregunta']) || empty($_POST['trueque_id'])) {
    header("Location: index.php");
    exit;
}

// Obtener el id del usuario logueado
$sql_usuario = "SELECT id FROM usuarios WHERE numero_documento = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("s", $_SESSION['numero_documento']);
$stmt_usuario->execute();
$res_usuario = $stmt_usuario->get_result();
$usuario = $res_usuario->fetch_assoc();
$stmt_usuario->close();

if ($usuario) {
    $usuario_id = $usuario['id'];
    $trueque_id = intval($_POST['trueque_id']);
    $pregunta = trim($_POST['pregunta']);

    $sql = "INSERT INTO preguntas_trueques (trueque_id, usuario_id, pregunta) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $trueque_id, $usuario_id, $pregunta);
    $stmt->execute();
    $stmt->close();
}

header("Location: trueques.php?id=" . intval($_POST['trueque_id']) . "&mensaje=Pregunta publicada");
exit;
?>