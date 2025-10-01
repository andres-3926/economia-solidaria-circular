<?php
include("conexion.php");
session_start();

if(isset($_POST['trueque_id'], $_POST['de_usuario_id'], $_POST['para_usuario_id'], $_POST['mensaje'])) {
    $trueque_id = intval($_POST['trueque_id']);
    $de_usuario_id = intval($_POST['de_usuario_id']);
    $para_usuario_id = intval($_POST['para_usuario_id']);
    $mensaje = trim($_POST['mensaje']);
    $respuesta_a_id = isset($_POST['respuesta_a_id']) && $_POST['respuesta_a_id'] !== '' ? intval($_POST['respuesta_a_id']) : null;

    if($mensaje !== '' && $de_usuario_id && $trueque_id) {
        $stmt = $conn->prepare("INSERT INTO mensajes_trueque (trueque_id, de_usuario_id, para_usuario_id, mensaje, respuesta_a_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisi", $trueque_id, $de_usuario_id, $para_usuario_id, $mensaje, $respuesta_a_id);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: trueques.php?id=" . intval($_POST['trueque_id']) . "#mensajes");
exit;