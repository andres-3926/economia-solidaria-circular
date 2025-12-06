<?php
include('conexion.php');
session_start();

if (!isset($_SESSION['numero_documento'])) {
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

$documento = $_SESSION['numero_documento'];

// Páginas de quiz que deben estar aprobadas
$paginas_quiz = [6, 12, 17]; // Páginas de quiz que deben estar aprobadas (ajusta estos índices según tus quizzes reales)
$aprobados = 0;

foreach ($paginas_quiz as $pagina) {
    // Buscar en resultados_quiz por tipo_quiz y datos_respuestas
    $stmt = $conn->prepare('SELECT datos_respuestas FROM resultados_quiz WHERE numero_documento = ? AND datos_respuestas LIKE ? ORDER BY fecha_completado DESC');
    $like = '%"aprobado":"SI"%';
    $stmt->bind_param('ss', $documento, $like);
    $stmt->execute();
    $res = $stmt->get_result();
    $aprobado_encontrado = false;
    while ($row = $res->fetch_assoc()) {
        $datos = json_decode($row['datos_respuestas'], true);
        // Solo cuenta si el registro tiene 'aprobado' en 'SI' y el campo 'pagina' coincide exactamente
        if (isset($datos['aprobado']) && $datos['aprobado'] === 'SI' && isset($datos['pagina']) && intval($datos['pagina']) === $pagina) {
            $aprobado_encontrado = true;
            break;
        }
    }
    if ($aprobado_encontrado) {
        $aprobados++;
    }
    $stmt->close();
}

if ($aprobados === count($paginas_quiz)) {
    echo json_encode(['certificado' => 'permitido']);
} else {
    echo json_encode(['certificado' => 'denegado', 'aprobados' => $aprobados, 'total' => count($paginas_quiz)]);
}
exit;
