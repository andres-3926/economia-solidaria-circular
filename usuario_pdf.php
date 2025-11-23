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

// Consultar resultados de retos
$sql_retos = "SELECT 
                r.*,
                DATE_FORMAT(r.fecha_realizacion, '%d/%m/%Y %H:%i:%s') as fecha_formateada
              FROM retos_usuarios r
              WHERE r.numero_documento = ?
              ORDER BY r.fecha_realizacion DESC";
$stmt_retos = $conn->prepare($sql_retos);
$stmt_retos->bind_param("s", $numero_documento);
$stmt_retos->execute();
$result_retos = $stmt_retos->get_result();
$retos = $result_retos->fetch_all(MYSQLI_ASSOC);
$stmt_retos->close();

$conn->close();

// Generar PDF
require('libs/fpdf.php');

class PDF extends FPDF {
    function Header() {
        // Logo o encabezado
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(0, 125, 62);
        $this->Cell(0, 12, 'Reporte de Usuario', 0, 1, 'C');
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 6, 'Sistema de Economia Solidaria y Circular - SENA', 0, 1, 'C');
        $this->Ln(5);
    }
    
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . ' - Generado el ' . date('d/m/Y H:i'), 0, 0, 'C');
    }
    
    function SectionTitle($title) {
        $this->SetFont('Arial', 'B', 13);
        $this->SetFillColor(67, 190, 22);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 9, $title, 0, 1, 'L', true);
        $this->Ln(3);
    }
    
    function DataRow($label, $value, $color = false) {
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(0);
        if ($color) {
            $this->SetFillColor(245, 245, 245);
            $this->Cell(70, 8, $label, 1, 0, 'L', true);
        } else {
            $this->Cell(70, 8, $label, 1, 0, 'L');
        }
        $this->SetFont('Arial', '', 10);
        if ($color) {
            $this->Cell(0, 8, $value, 1, 1, 'L', true);
        } else {
            $this->Cell(0, 8, $value, 1, 1, 'L');
        }
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// SECCIÓN 1: INFORMACIÓN PERSONAL DEL USUARIO
$pdf->SectionTitle('Informacion Personal del Usuario');

// Número de Documento
$pdf->DataRow('Numero de Documento:', $usuario['numero_documento'], true);

// Nombre Completo
$nombre_completo = '';
if (isset($usuario['nombre_completo']) && !empty($usuario['nombre_completo'])) {
    $nombre_completo = $usuario['nombre_completo'];
} elseif (isset($usuario['nombres']) && isset($usuario['apellidos'])) {
    $nombre_completo = trim($usuario['nombres'] . ' ' . $usuario['apellidos']);
}
$pdf->DataRow('Nombre Completo:', $nombre_completo ?: 'N/A');

// Celular
$celular = isset($usuario['celular']) && !empty($usuario['celular']) ? $usuario['celular'] : 'N/A';
$pdf->DataRow('Celular:', $celular, true);

// Correo Electrónico
$correo = '';
if (isset($usuario['correo_electronico']) && !empty($usuario['correo_electronico'])) {
    $correo = $usuario['correo_electronico'];
} elseif (isset($usuario['correo']) && !empty($usuario['correo'])) {
    $correo = $usuario['correo'];
}
$pdf->DataRow('Correo Electronico:', $correo ?: 'N/A');

// Comuna
$comuna = isset($usuario['comuna']) && !empty($usuario['comuna']) ? $usuario['comuna'] : 'N/A';
$pdf->DataRow('Comuna:', $comuna, true);

// Barrio o Sector
$barrio = '';
if (isset($usuario['barrio']) && !empty($usuario['barrio'])) {
    $barrio = $usuario['barrio'];
} elseif (isset($usuario['sector']) && !empty($usuario['sector'])) {
    $barrio = $usuario['sector'];
} elseif (isset($usuario['barrio_sector']) && !empty($usuario['barrio_sector'])) {
    $barrio = $usuario['barrio_sector'];
}
$pdf->DataRow('Barrio o Sector:', $barrio ?: 'N/A');

// Dirección
$direccion = isset($usuario['direccion']) && !empty($usuario['direccion']) ? $usuario['direccion'] : 'N/A';
$pdf->DataRow('Direccion:', $direccion, true);

// Emprendimiento (nombre del emprendimiento)
$emprendimiento = '';
if (isset($usuario['emprendimiento']) && !empty($usuario['emprendimiento'])) {
    $emprendimiento = $usuario['emprendimiento'];
} elseif (isset($usuario['nombre_emprendimiento']) && !empty($usuario['nombre_emprendimiento'])) {
    $emprendimiento = $usuario['nombre_emprendimiento'];
}
$pdf->DataRow('Emprendimiento:', $emprendimiento ?: 'N/A');

// Fecha de Registro
$fecha_registro = 'N/A';
if (isset($usuario['fecha_registro']) && !empty($usuario['fecha_registro'])) {
    $fecha_registro = date('d/m/Y', strtotime($usuario['fecha_registro']));
} elseif (isset($usuario['fecha_creacion']) && !empty($usuario['fecha_creacion'])) {
    $fecha_registro = date('d/m/Y', strtotime($usuario['fecha_creacion']));
}
$pdf->DataRow('Fecha de Registro:', $fecha_registro, true);

// Rol
$rol = isset($usuario['rol']) ? ucfirst(trim($usuario['rol'])) : 'N/A';
$pdf->DataRow('Rol:', $rol);

$pdf->Ln(8);

// SECCIÓN 2: RESULTADOS DE RETOS - QUIZ DE RESIDUOS
$pdf->SectionTitle('Resultados de Retos - Quiz de Residuos');

if (count($retos) > 0) {
    // Estadísticas generales
    $total_intentos = count($retos);
    $total_aprobados = array_sum(array_column($retos, 'aprobado'));
    $promedio_acierto = array_sum(array_column($retos, 'porcentaje_acierto')) / $total_intentos;
    
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(220, 240, 255);
    $pdf->SetTextColor(0, 61, 130);
    $pdf->Cell(0, 8, 'Resumen General de Intentos', 1, 1, 'C', true);
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(0);
    $pdf->Cell(47.5, 7, 'Total Intentos: ' . $total_intentos, 1, 0, 'C');
    $pdf->Cell(47.5, 7, 'Aprobados: ' . $total_aprobados, 1, 0, 'C');
    $pdf->Cell(47.5, 7, 'Reprobados: ' . ($total_intentos - $total_aprobados), 1, 0, 'C');
    $pdf->Cell(47.5, 7, 'Promedio: ' . number_format($promedio_acierto, 1) . '%', 1, 1, 'C');
    $pdf->Ln(6);
    
    // Preguntas y respuestas correctas del quiz
    $preguntas = [
        1 => "Cascaras de platano",
        2 => "Borra de cafe",
        3 => "Aceite de cocina usado",
        4 => "Retazos de tela",
        5 => "Carton o papel kraft",
        6 => "Hilos sobrantes"
    ];
    
    $respuestas_correctas = [
        1 => "Organico para compost",
        2 => "Organico para compost",
        3 => "Reutilizable para artesanias",
        4 => "Reutilizable para artesanias",
        5 => "Reciclable (plastico, vidrio, papel)",
        6 => "Reutilizable para artesanias"
    ];
    
    // Detalle de cada intento
    $intento_num = 1;
    foreach ($retos as $reto) {
        // Verificar si necesita nueva página
        if ($pdf->GetY() > 245) {
            $pdf->AddPage();
        }
        
        // Título del intento
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(67, 190, 22);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 8, 'Intento #' . $intento_num . ' - ' . $reto['fecha_formateada'], 0, 1, 'L', true);
        $pdf->SetTextColor(0);
        $pdf->Ln(2);
        
        // Información del intento
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetFillColor(250, 250, 250);
        $pdf->Cell(95, 7, 'Fecha y Hora: ' . $reto['fecha_formateada'], 1, 0, 'L', true);
        $pdf->Cell(95, 7, 'Tiempo Empleado: ' . $reto['tiempo_segundos'] . ' segundos', 1, 1, 'L', true);
        
        $pdf->Cell(63.33, 7, 'Correctas: ' . $reto['respuestas_correctas'] . '/' . $reto['total_preguntas'], 1, 0, 'C');
        $pdf->Cell(63.33, 7, 'Porcentaje: ' . number_format($reto['porcentaje_acierto'], 1) . '%', 1, 0, 'C');
        
        // Estado (Aprobado/No Aprobado)
        if ($reto['aprobado']) {
            $pdf->SetFillColor(212, 237, 218);
            $pdf->SetTextColor(21, 87, 36);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(63.34, 7, 'APROBADO', 1, 1, 'C', true);
        } else {
            $pdf->SetFillColor(248, 215, 218);
            $pdf->SetTextColor(114, 28, 36);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(63.34, 7, 'NO APROBADO', 1, 1, 'C', true);
        }
        $pdf->SetTextColor(0);
        $pdf->Ln(3);
        
        // Respuestas detalladas pregunta por pregunta
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 6, 'Respuestas Detalladas:', 0, 1, 'L');
        $pdf->Ln(1);
        
        for ($i = 1; $i <= 6; $i++) {
            $respuesta_usuario = isset($reto["respuesta_$i"]) ? $reto["respuesta_$i"] : 'Sin respuesta';
            $es_correcta = ($respuesta_usuario === $respuestas_correctas[$i]);
            
            // Número y pregunta
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->Cell(12, 6, "P$i:", 1, 0, 'C', true);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(0, 6, $preguntas[$i], 1, 1, 'L');
            
            // Estado de la respuesta (Correcta/Incorrecta)
            if ($es_correcta) {
                $pdf->SetTextColor(21, 87, 36);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(20, 5, 'CORRECTA', 0, 0, 'L');
            } else {
                $pdf->SetTextColor(114, 28, 36);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(20, 5, 'INCORRECTA', 0, 0, 'L');
            }
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(0, 5, 'Respuesta del usuario: ' . $respuesta_usuario, 0, 'L');
            
            // Mostrar respuesta correcta si falló
            if (!$es_correcta) {
                $pdf->SetTextColor(0, 100, 0);
                $pdf->Cell(20, 5, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->MultiCell(0, 5, 'Respuesta correcta: ' . $respuestas_correctas[$i], 0, 'L');
                $pdf->SetTextColor(0);
            }
            $pdf->Ln(2);
        }
        
        $pdf->Ln(6);
        $intento_num++;
    }
    
} else {
    // Si no hay retos realizados
    $pdf->SetFont('Arial', 'I', 11);
    $pdf->SetTextColor(128);
    $pdf->SetFillColor(255, 243, 205);
    $pdf->Cell(0, 10, 'Este usuario aun no ha realizado el quiz de residuos.', 1, 1, 'C', true);
    $pdf->SetTextColor(0);
}

// Pie de página final
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetTextColor(100);
$pdf->Cell(0, 5, 'Documento generado el: ' . date('d/m/Y H:i:s'), 0, 1, 'R');
$pdf->Cell(0, 5, 'Sistema de Economia Solidaria y Circular - SENA', 0, 1, 'R');

// Generar y descargar PDF
$pdf->Output('D', 'Usuario_' . $usuario['numero_documento'] . '_' . date('Y-m-d_His') . '.pdf');
?>