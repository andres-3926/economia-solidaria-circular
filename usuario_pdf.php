<?php
session_start();
include("conexion.php");

// Verificar que sea administrador
if (!isset($_SESSION['numero_documento'])) {
    header("Location: login.php");
    exit;
}

$sql_admin = "SELECT rol FROM usuarios WHERE numero_documento = ?";
$stmt_admin = $conn->prepare($sql_admin);
$stmt_admin->bind_param("s", $_SESSION['numero_documento']);
$stmt_admin->execute();
$result_admin = $stmt_admin->get_result();
$admin = $result_admin->fetch_assoc();
$stmt_admin->close();

if (!$admin || strtolower(trim($admin['rol'])) !== 'administrador') {
    die("Acceso denegado. Solo los administradores pueden acceder.");
}

// Obtener documento del usuario
if (!isset($_GET['numero_documento'])) {
    die("Usuario no especificado.");
}

$numero_documento = $_GET['numero_documento'];

// Consultar información del usuario
$sql = "SELECT * FROM usuarios WHERE numero_documento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $numero_documento);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

if (!$usuario) {
    die("Usuario no encontrado.");
}

// ✅ CONSULTAR TODOS LOS RESULTADOS DE QUIZ (TABLA NUEVA)
$sql_quiz = "SELECT * FROM resultados_quiz WHERE numero_documento = ? ORDER BY fecha_completado DESC LIMIT 3";
$stmt_quiz = $conn->prepare($sql_quiz);
$stmt_quiz->bind_param("s", $numero_documento);
$stmt_quiz->execute();
$result_quiz = $stmt_quiz->get_result();
$quiz_nuevos = $result_quiz->fetch_all(MYSQLI_ASSOC);
$stmt_quiz->close();



$conn->close();

// Generar PDF
require('libs/fpdf.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(67, 190, 22);
        $this->Cell(0, 12, utf8_decode('ECONOMÍA SOLIDARIA CIRCULAR'), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(0, 61, 130);
        $this->Cell(0, 8, 'Reporte de Actividades del Usuario', 0, 1, 'C');
        $this->Ln(5);
    }
    
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' - Generado: ' . date('d/m/Y H:i'), 0, 0, 'C');
    }
    
    function SectionTitle($title) {
        $this->SetFont('Arial', 'B', 13);
        $this->SetFillColor(67, 190, 22);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 10, utf8_decode('  ' . $title), 0, 1, 'L', true);
        $this->Ln(3);
    }
    
    function DataRow($label, $value, $color = false) {
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(0);
        if ($color) {
            $this->SetFillColor(245, 245, 245);
            $this->Cell(60, 7, utf8_decode($label), 1, 0, 'L', true);
        } else {
            $this->Cell(60, 7, utf8_decode($label), 1, 0, 'L');
        }
        $this->SetFont('Arial', '', 10);
        if ($color) {
            $this->Cell(0, 7, utf8_decode($value), 1, 1, 'L', true);
        } else {
            $this->Cell(0, 7, utf8_decode($value), 1, 1, 'L');
        }
    }
}

$pdf = new PDF();
$pdf->SetMargins(15, 15, 15);
$pdf->AddPage();

// ============================================
// SECCIÓN 1: INFORMACIÓN DEL USUARIO
// ============================================
$pdf->SectionTitle('INFORMACION DEL USUARIO');

$nombre_completo = '';
if (isset($usuario['nombre_completo']) && !empty($usuario['nombre_completo'])) {
    $nombre_completo = $usuario['nombre_completo'];
} elseif (isset($usuario['nombres']) && isset($usuario['apellidos'])) {
    $nombre_completo = trim($usuario['nombres'] . ' ' . $usuario['apellidos']);
}

$pdf->DataRow('Nombre Completo:', $nombre_completo ?: 'N/A', true);
$pdf->DataRow('Documento:', $usuario['numero_documento']);
$pdf->DataRow('Celular:', $usuario['celular'] ?? 'N/A', true);

$correo = '';
if (isset($usuario['correo_electronico']) && !empty($usuario['correo_electronico'])) {
    $correo = $usuario['correo_electronico'];
} elseif (isset($usuario['correo']) && !empty($usuario['correo'])) {
    $correo = $usuario['correo'];
}
$pdf->DataRow('Correo:', $correo ?: 'N/A');

$pdf->DataRow('Comuna:', $usuario['comuna'] ?? 'N/A', true);

$barrio = '';
if (isset($usuario['barrio']) && !empty($usuario['barrio'])) {
    $barrio = $usuario['barrio'];
} elseif (isset($usuario['sector']) && !empty($usuario['sector'])) {
    $barrio = $usuario['sector'];
} elseif (isset($usuario['barrio_sector']) && !empty($usuario['barrio_sector'])) {
    $barrio = $usuario['barrio_sector'];
}
$pdf->DataRow('Barrio:', $barrio ?: 'N/A');

$pdf->DataRow('Direccion:', $usuario['direccion'] ?? 'N/A', true);

$emprendimiento = '';
if (isset($usuario['emprendimiento']) && !empty($usuario['emprendimiento'])) {
    $emprendimiento = $usuario['emprendimiento'];
} elseif (isset($usuario['nombre_emprendimiento']) && !empty($usuario['nombre_emprendimiento'])) {
    $emprendimiento = $usuario['nombre_emprendimiento'];
}
$pdf->DataRow('Emprendimiento:', $emprendimiento ?: 'N/A');

$fecha_registro = 'N/A';
if (isset($usuario['fecha_registro']) && !empty($usuario['fecha_registro'])) {
    $fecha_registro = date('d/m/Y', strtotime($usuario['fecha_registro']));
} elseif (isset($usuario['fecha_creacion']) && !empty($usuario['fecha_creacion'])) {
    $fecha_registro = date('d/m/Y', strtotime($usuario['fecha_creacion']));
}
$pdf->DataRow('Fecha Registro:', $fecha_registro, true);

$pdf->DataRow('Rol:', strtoupper($usuario['rol'] ?? 'N/A'));

$pdf->Ln(8);

// ============================================
// SECCIÓN 2: RESULTADOS DE QUIZ Y RETOS (TABLA NUEVA)
// ============================================
if (count($quiz_nuevos) > 0) {
    $pdf->SectionTitle('QUIZ Y RETOS REALIZADOS');
    
    $contador = 1;
    
    foreach ($quiz_nuevos as $quiz) {
        $datos = json_decode($quiz['datos_respuestas'], true);
        
        // Verificar si necesita nueva página
        if ($pdf->GetY() > 240) {
            $pdf->AddPage();
        }
        
        // Título del quiz
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 61, 130);
        $pdf->MultiCell(0, 6, utf8_decode("Quiz #{$contador}: {$quiz['titulo_quiz']}"));
        
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell(0, 5, utf8_decode('Tipo: ' . $quiz['tipo_quiz'] . ' | Fecha: ' . date('d/m/Y H:i', strtotime($quiz['fecha_completado']))), 0, 1);
        $pdf->Ln(2);
        
        // Mostrar resultados y estado para cualquier tipo de quiz
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(240, 240, 240);
        if (isset($datos['respuestas_correctas']) && isset($datos['total_preguntas'])) {
            $pdf->Cell(70, 7, utf8_decode('Respuestas correctas:'), 1, 0, 'L', true);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 7, $datos['respuestas_correctas'] . ' / ' . $datos['total_preguntas'], 1, 1, 'L', true);
        }
        if (isset($datos['porcentaje_acierto'])) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(70, 7, utf8_decode('Porcentaje de acierto:'), 1, 0, 'L', true);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 7, number_format($datos['porcentaje_acierto'], 1) . '%', 1, 1, 'L', true);
        }
        if (isset($datos['minimo_requerido'])) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(70, 7, utf8_decode('Mínimo para aprobar:'), 1, 0, 'L', true);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 7, $datos['minimo_requerido'], 1, 1, 'L', true);
        }
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(70, 7, utf8_decode('Estado:'), 1, 0, 'L', true);
        if (isset($datos['aprobado']) && $datos['aprobado'] === 'SI') {
            $pdf->SetFillColor(67, 190, 22);
            $pdf->SetTextColor(255);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('✓ APROBADO'), 1, 1, 'C', true);
        } else {
            $pdf->SetFillColor(231, 76, 60);
            $pdf->SetTextColor(255);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(0, 7, utf8_decode('✗ NO APROBADO'), 1, 1, 'C', true);
            // Mensaje adicional si no aprobó
            if (isset($datos['minimo_requerido']) && isset($datos['total_preguntas'])) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetTextColor(231, 76, 60);
                $pdf->MultiCell(0, 7, utf8_decode('Necesitas ' . $datos['minimo_requerido'] . ' respuestas correctas de ' . $datos['total_preguntas'] . ' para aprobar.'), 0, 'L');
                $pdf->SetTextColor(0);
            }
        }
        $pdf->SetTextColor(0);
        // Aquí podrías agregar otros tipos de quiz si existen
        $contador++;
    } // Fin foreach quiz_nuevos
} // Fin if count quiz_nuevos

// Si no hay resultados
if (count($quiz_nuevos) == 0) {
    $pdf->SetFont('Arial', 'I', 11);
    $pdf->SetTextColor(128);
    $pdf->SetFillColor(255, 243, 205);
    $pdf->Cell(0, 10, utf8_decode('Este usuario aun no ha realizado ningun quiz.'), 1, 1, 'C', true);
    $pdf->SetTextColor(0);
}

// Pie de página final
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetTextColor(100);
$pdf->Cell(0, 5, utf8_decode('Documento generado: ' . date('d/m/Y H:i:s')), 0, 1, 'R');
$pdf->Cell(0, 5, utf8_decode('Sistema de Economia Solidaria y Circular - SENA'), 0, 1, 'R');

// Generar y descargar PDF
$pdf->Output('D', 'Usuario_' . $usuario['numero_documento'] . '_' . date('Y-m-d_His') . '.pdf');
?>