<?php
require('libs/fpdf.php');
include("conexion.php");
session_start();

// Solo permitir acceso al administrador
if (!isset($_SESSION['numero_documento'])) {
    die("Acceso denegado.");
}
$sql = "SELECT rol FROM usuarios WHERE numero_documento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['numero_documento']);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();
if (!$admin || strtolower(trim($admin['rol'])) !== 'administrador') {
    die("Acceso denegado.");
}

// Obtener el usuario por documento (GET)
if (!isset($_GET['numero_documento'])) {
    die("Usuario no especificado.");
}
$doc = $_GET['numero_documento'];
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE numero_documento = ?");
$stmt->bind_param("s", $doc);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

if (!$usuario) {
    die("Usuario no encontrado.");
}

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Datos del Usuario',0,1,'C');
$pdf->SetFont('Arial','',12);

foreach ($usuario as $campo => $valor) {
    $pdf->Cell(50,10,ucwords(str_replace('_',' ',$campo)).":",0,0);
    $pdf->Cell(0,10,$valor,0,1);
}

$pdf->Output('I', 'usuario_'.$usuario['numero_documento'].'.pdf');
?>