<?php
require('fpdf186/fpdf.php');
session_start();


// Validar que el usuario esté autenticado por número de documento
if (!isset($_SESSION['numero_documento'])) {
    header('Location: login.php');
    exit;
}


// Obtener el número de documento desde la sesión
$documento = isset($_SESSION['numero_documento']) ? $_SESSION['numero_documento'] : '';

// Consultar el nombre real del emprendedor en la base de datos
include('conexion.php');
$nombre = 'Emprendedor/a';
if (!empty($documento)) {
    $stmt = $conn->prepare("SELECT nombre_completo FROM usuarios WHERE numero_documento = ? LIMIT 1");
    $stmt->bind_param("s", $documento);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $nombre = $row['nombre_completo'];
    }
    $stmt->close();
}


// Ajustar zona horaria a Colombia
date_default_timezone_set('America/Bogota');
$fecha = date('d/m/Y');
$hora = date('H:i');

// Crear PDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Colores y fuentes
$pdf->SetFillColor(67, 190, 22);
$pdf->SetTextColor(0, 17, 34);
$pdf->SetFont('Arial', 'B', 28);

// Título principal
$pdf->Cell(0, 20, utf8_decode('CERTIFICADO DE APROBACIÓN'), 0, 1, 'C');
$pdf->Ln(5);



// Eliminar medalla/emoji, no mostrar nada aquí

// Nombre y documento del usuario





$pdf->SetFont('Arial', 'B', 22);
$pdf->Cell(0, 12, utf8_decode('Otorgado a: ' . $nombre), 0, 1, 'C');
$pdf->Ln(2);
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(0, 8, utf8_decode('Número de documento: ' . $documento), 0, 1, 'C');
$pdf->Ln(12); // Más espacio antes del bloque de felicitación

// Texto de felicitación





$pdf->SetFont('Arial', 'B', 16);
$pdf->MultiCell(0, 8, utf8_decode("¡Felicitaciones, querido emprendedor!"), 0, 'C');
$pdf->Ln(14); // Más espacio antes del bloque verde
$pdf->SetFont('Arial', '', 13);
$pdf->MultiCell(0, 6, utf8_decode(
    "Has interactuado exitosamente con cada interfaz de la página 'Aprende', dentro del aplicativo desarrollado en el marco del proyecto 'Reciclando Juntas, Produciendo Futuro'."
), 0, 'C');
$pdf->Ln(8);
$pdf->MultiCell(0, 6, utf8_decode(
    "Este proceso fortaleció tus conocimientos en gestión de residuos sólidos, economía circular, reciclaje, bioabonos y aprovechamiento de residuos orgánicos propios de tus oficios."
), 0, 'C');
$pdf->Ln(18); // Más espacio antes del bloque rojo

// Proyecto y SENA




$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 6, utf8_decode('Proyecto: Reciclando Juntas, Produciendo Futuro'), 0, 1, 'C');
$pdf->Ln(10);

// Fecha y hora


$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, utf8_decode('Fecha de generación: ' . $fecha . ' - ' . $hora), 0, 1, 'C');

// Logo SENA (opcional)
if (file_exists('img/logo_sena.png')) {
    $pdf->Image('img/logo_sena.png', 10, 10, 40, 0);
}

$pdf->Output('D', 'Certificado_Economia_Solidaria.pdf');
exit;
?>
