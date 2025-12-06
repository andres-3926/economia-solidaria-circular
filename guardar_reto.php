<?php
session_start();
include("conexion.php");

header('Content-Type: application/json');

if (!isset($_SESSION['numero_documento'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    $numero_documento = $_SESSION['numero_documento'];
    
    // ✅ DETECTAR TIPO DE QUIZ
    $tipo_quiz = isset($_POST['tipo_quiz']) ? trim($_POST['tipo_quiz']) : 'actividad_quiz';
    $titulo_quiz = isset($_POST['titulo_quiz']) ? trim($_POST['titulo_quiz']) : 'Quiz sin título';
    
    // ✅ PREPARAR DATOS SEGÚN EL TIPO
    $pagina = isset($_POST['pagina']) ? intval($_POST['pagina']) : null;
    if ($tipo_quiz === 'reto_compostaje') {
        // RETO 4: Compostaje con selección múltiple
        $datos_respuestas = [
            'items_seleccionados' => $_POST['items_seleccionados'] ?? '',
            'items_texto' => $_POST['items_texto'] ?? '',
            'total_seleccionados' => intval($_POST['total_seleccionados'] ?? 0),
            'minimo_requerido' => intval($_POST['minimo_requerido'] ?? 3),
            'aprobado' => $_POST['aprobado'] ?? 'NO',
            'pagina' => $pagina
        ];
    } else {
        // QUIZ TRADICIONALES (Página 6, 12, etc.)
        $respuestas = [];
        $respuestas_correctas = intval($_POST['respuestas_correctas'] ?? 0);
        $total_preguntas = intval($_POST['total_preguntas'] ?? 0);
        // Capturar todas las respuestas
        for ($i = 1; $i <= 6; $i++) {
            if (isset($_POST['respuesta_' . $i]) && !empty($_POST['respuesta_' . $i])) {
                $respuestas['pregunta_' . $i] = [
                    'respuesta_usuario' => trim($_POST['respuesta_' . $i]),
                    'es_correcta' => isset($_POST['correcta_' . $i]) ? ($_POST['correcta_' . $i] === '1') : false
                ];
            }
        }
        // Calcular aprobación
        $minimo_requerido = ($total_preguntas === 3) ? 3 : 4;
        $aprobado = ($respuestas_correctas >= $minimo_requerido) ? 'SI' : 'NO';
        $datos_respuestas = [
            'respuestas' => $respuestas,
            'respuestas_correctas' => $respuestas_correctas,
            'total_preguntas' => $total_preguntas,
            'porcentaje_acierto' => floatval($_POST['porcentaje_acierto'] ?? 0),
            'tiempo_segundos' => intval($_POST['tiempo_segundos'] ?? 0),
            'minimo_requerido' => $minimo_requerido,
            'aprobado' => $aprobado,
            'instrucciones' => $_POST['instrucciones'] ?? '',
            'pagina' => $pagina
        ];
    }
    $datos_respuestas = json_encode($datos_respuestas);
    
    // ✅ GUARDAR EN resultados_quiz (TABLA PRINCIPAL)
    $sql = "INSERT INTO resultados_quiz 
            (numero_documento, titulo_quiz, tipo_quiz, datos_respuestas, fecha_completado) 
            VALUES (?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Error al preparar consulta: ' . $conn->error);
    }
    
    $stmt->bind_param("ssss", $numero_documento, $titulo_quiz, $tipo_quiz, $datos_respuestas);
    
    if ($stmt->execute()) {
        $insert_id = $stmt->insert_id;
        
        echo json_encode([
            'success' => true,
            'message' => 'Reto guardado exitosamente',
            'data' => [
                'id' => $insert_id,
                'titulo' => $titulo_quiz,
                'tipo' => $tipo_quiz
            ]
        ]);
    } else {
        throw new Exception('Error al ejecutar: ' . $stmt->error);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

$conn->close();
?>