<?php
session_start();
include("conexion.php");

header('Content-Type: application/json');

// Verificar autenticación
if (!isset($_SESSION['numero_documento'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

// Verificar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    // Capturar datos
    $numero_documento = $_SESSION['numero_documento'];
    $respuesta_1 = isset($_POST['respuesta_1']) ? trim($_POST['respuesta_1']) : '';
    $respuesta_2 = isset($_POST['respuesta_2']) ? trim($_POST['respuesta_2']) : '';
    $respuesta_3 = isset($_POST['respuesta_3']) ? trim($_POST['respuesta_3']) : '';
    $respuesta_4 = isset($_POST['respuesta_4']) ? trim($_POST['respuesta_4']) : '';
    $respuesta_5 = isset($_POST['respuesta_5']) ? trim($_POST['respuesta_5']) : '';
    $respuesta_6 = isset($_POST['respuesta_6']) ? trim($_POST['respuesta_6']) : '';
    $respuestas_correctas = isset($_POST['respuestas_correctas']) ? intval($_POST['respuestas_correctas']) : 0;
    $total_preguntas = isset($_POST['total_preguntas']) ? intval($_POST['total_preguntas']) : 0;
    $porcentaje_acierto = isset($_POST['porcentaje_acierto']) ? floatval($_POST['porcentaje_acierto']) : 0;
    $tiempo_segundos = isset($_POST['tiempo_segundos']) ? intval($_POST['tiempo_segundos']) : 0;
    
    // ✅ NUEVO: Capturar metadatos del quiz
    $titulo_quiz = isset($_POST['titulo_quiz']) ? trim($_POST['titulo_quiz']) : '';
    $tipo_quiz = isset($_POST['tipo_quiz']) ? trim($_POST['tipo_quiz']) : '';
    $instrucciones = isset($_POST['instrucciones']) ? trim($_POST['instrucciones']) : '';
    
    // ✅ CALCULAR APROBACIÓN DINÁMICA SEGÚN TOTAL DE PREGUNTAS
    if ($total_preguntas === 3) {
        // Página 12: 3 preguntas → necesita 3 correctas
        $minimo_requerido = 3;
        $aprobado = ($respuestas_correctas >= 3) ? 1 : 0;
    } else {
        // Página 6: 6 preguntas → necesita 4 correctas
        $minimo_requerido = 4;
        $aprobado = ($respuestas_correctas >= 4) ? 1 : 0;
    }
    
    // ✅ PREPARAR CONSULTA CON METADATOS
    $sql = "INSERT INTO retos_usuarios (
                numero_documento, 
                respuesta_1, 
                respuesta_2, 
                respuesta_3, 
                respuesta_4, 
                respuesta_5, 
                respuesta_6, 
                respuestas_correctas, 
                total_preguntas, 
                porcentaje_acierto, 
                tiempo_segundos, 
                titulo_quiz,
                tipo_quiz,
                instrucciones,
                aprobado
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Error al preparar consulta: ' . $conn->error);
    }
    
    $stmt->bind_param(
        "ssssssiiidisssi",
        $numero_documento,
        $respuesta_1,
        $respuesta_2,
        $respuesta_3,
        $respuesta_4,
        $respuesta_5,
        $respuesta_6,
        $respuestas_correctas,
        $total_preguntas,
        $porcentaje_acierto,
        $tiempo_segundos,
        $titulo_quiz,
        $tipo_quiz,
        $instrucciones,
        $aprobado
    );
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Reto guardado exitosamente',
            'data' => [
                'id' => $stmt->insert_id,
                'aprobado' => $aprobado,
                'correctas' => $respuestas_correctas,
                'total' => $total_preguntas,
                'minimo_requerido' => $minimo_requerido,
                'porcentaje' => $porcentaje_acierto,
                'titulo_quiz' => $titulo_quiz
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