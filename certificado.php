<?php
require('fpdf186/fpdf.php');
session_start();

// Obtener el nombre del usuario desde la sesión
$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Emprendedor/a';

// Fecha y hora actual
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

// Medalla (puedes cambiar por una imagen si tienes una medalla.png en img/)
if (file_exists('img/medalla.png')) {
    $pdf->Image('img/medalla.png', 120, 35, 50, 50);
    $pdf->Ln(55);
} else {
    $pdf->SetFont('Arial', '', 60);
    $pdf->Cell(0, 40, utf8_decode('🏅'), 0, 1, 'C');
}
$pdf->Ln(5);

// Nombre del usuario
$pdf->SetFont('Arial', 'B', 22);
$pdf->Cell(0, 15, utf8_decode('Otorgado a: ' . $nombre), 0, 1, 'C');
$pdf->Ln(5);

// Texto de felicitación
$pdf->SetFont('Arial', '', 16);
$pdf->MultiCell(0, 10, utf8_decode(
    "¡Felicitaciones, querido emprendedor!\n\n" .
    "Has alcanzado con éxito el curso básico sobre Economía Solidaria y Circular para Unidades Productivas de Cali, desarrollado por el CGTS del SENA Regional Valle en el marco del proyecto 'Reciclando Juntas, Produciendo Futuro'.\n\n" .
    "Este curso te ha permitido aprender sobre la gestión de residuos sólidos en economías populares de Cali, con enfoque de economía circular, reciclaje, preparación de bioabono y el aprovechamiento de residuos orgánicos generados en los procesos de tus propios oficios."
), 0, 'C');
$pdf->Ln(8);

// Proyecto y SENA
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode('SENA - Regional Valle'), 0, 1, 'C');
$pdf->Cell(0, 10, utf8_decode('Proyecto: Reciclando Juntas, Produciendo Futuro'), 0, 1, 'C');
$pdf->Ln(8);

// Fecha y hora
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode('Fecha de generación: ' . $fecha . ' - ' . $hora), 0, 1, 'C');

// Logo SENA (opcional)
if (file_exists('img/logo_sena.png')) {
    $pdf->Image('img/logo_sena.png', 10, 10, 40, 0);
}

$pdf->Output('D', 'Certificado_Economia_Solidaria.pdf');
exit;
?>
