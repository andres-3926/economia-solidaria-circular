<?php
require('fpdf186/fpdf.php');
session_start();

// Subclase FPDF con métodos para marco redondeado y medalla
class PDF_Certificado extends FPDF {
    // Dibuja un rectángulo con esquinas redondeadas
    function RoundedRect($x, $y, $w, $h, $r, $style = '') {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
        $xc = $x+$w-$r ; $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k, ($hp-$y)*$k ));
        $this->_Arc($xc+$r*$MyArc, $yc-$r, $xc+$r, $yc-$r*$MyArc, $xc+$r, $yc);
        $xc = $x+$w-$r ; $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k, ($hp-$yc)*$k));
        $this->_Arc($xc+$r, $yc+$r*$MyArc, $xc+$r*$MyArc, $yc+$r, $xc, $yc+$r);
        $xc = $x+$r ; $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k, ($hp-($y+$h))*$k));
        $this->_Arc($xc-$r*$MyArc, $yc+$r, $xc-$r, $yc+$r*$MyArc, $xc-$r, $yc);
        $xc = $x+$r ; $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $x*$k, ($hp-$yc)*$k ));
        $this->_Arc($xc-$r, $yc-$r*$MyArc, $xc-$r*$MyArc, $yc-$r, $xc, $yc-$r);
        $this->_out($op);
    }
    function _Arc($x1, $y1, $x2, $y2, $x3, $y3) {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ',
            $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k,
            $x3*$this->k, ($h-$y3)*$this->k));
    }
    // Dibuja una medalla simple (círculo dorado con estrella blanca)
    function DrawMedal($x, $y, $r) {
        $this->SetFillColor(255, 215, 0); // dorado
        $this->SetDrawColor(184, 134, 11); // borde dorado oscuro
        $this->Ellipse($x, $y, $r, $r, 'F');
        $this->Ellipse($x, $y, $r, $r, 'D');
        $this->SetFillColor(255,255,255);
        $this->Ellipse($x, $y, $r-6, $r-6, 'F');
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(184, 134, 11);
        $this->SetXY($x-10, $y-7);
        $this->Cell(20, 14, utf8_decode('★'), 0, 0, 'C');
        $this->SetTextColor(0, 17, 34);
    }
    // Dibuja una elipse (o círculo) usando Bezier
    function Ellipse($x, $y, $rx, $ry, $style='D') {
        $k = $this->k;
        $h = $this->h;
        $lx = 4/3*(sqrt(2)-1)*$rx;
        $ly = 4/3*(sqrt(2)-1)*$ry;
        $op = ($style=='F') ? 'f' : (($style=='FD' || $style=='DF') ? 'B' : 'S');
        $x0 = $x; $y0 = $y;
        $this->_out(sprintf('%.2F %.2F m', ($x+$rx)*$k, ($h-($y))*$k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x+$rx)*$k, ($h-($y-$ly))*$k,
            ($x+$lx)*$k, ($h-($y-$ry))*$k,
            $x*$k, ($h-($y-$ry))*$k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x-$lx)*$k, ($h-($y-$ry))*$k,
            ($x-$rx)*$k, ($h-($y-$ly))*$k,
            ($x-$rx)*$k, ($h-($y))*$k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x-$rx)*$k, ($h-($y+$ly))*$k,
            ($x-$lx)*$k, ($h-($y+$ry))*$k,
            $x*$k, ($h-($y+$ry))*$k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c %s',
            ($x+$lx)*$k, ($h-($y+$ry))*$k,
            ($x+$rx)*$k, ($h-($y+$ly))*$k,
            ($x+$rx)*$k, ($h-($y))*$k,
            $op));
    }
}


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


$pdf = new PDF_Certificado('L', 'mm', 'A4');
$pdf->AddPage();
// Dibuja un marco decorativo (rectángulo con esquinas redondeadas)
$pdf->SetLineWidth(2);
$pdf->SetDrawColor(67, 190, 22); // Verde
$pdf->RoundedRect(8, 8, 281, 191, 8, 'D');




// Colores y fuentes
$pdf->SetFillColor(67, 190, 22);
$pdf->SetTextColor(0, 17, 34);
// Imagen de medalla como fondo, antes del texto, misma posición y tamaño
$pdf->Image('img/medalla_1.jpg', 30, 40, 55, 0); // (x, y, width, height=auto)
$pdf->SetFont('Arial', 'B', 28); // ¡IMPORTANTE! Establecer fuente antes de cualquier Cell
// Título principal (se imprime encima de la imagen)
// Título principal (se imprime encima de la imagen)
$pdf->SetY(32);
$pdf->Cell(0, 20, utf8_decode('CERTIFICADO DE APROBACIÓN'), 0, 1, 'C');
$pdf->Ln(2); // Menos espacio después del título



// Eliminar medalla/emoji, no mostrar nada aquí

// Nombre y documento del usuario






$pdf->SetFont('Arial', 'B', 22);
$pdf->Cell(0, 12, utf8_decode('Otorgado a: ' . $nombre), 0, 1, 'C');
$pdf->SetFont('Arial', '', 15);
$pdf->Cell(0, 8, utf8_decode('Número de documento: ' . $documento), 0, 1, 'C');
$pdf->Ln(8); // Menos espacio antes del bloque de felicitación

// Texto de felicitación





$pdf->SetFont('Arial', 'B', 16);
$pdf->MultiCell(0, 8, utf8_decode("¡Felicitaciones, querido emprendedor!"), 0, 'C');
$pdf->Ln(14); // Más espacio antes del bloque verde
$pdf->SetFont('Arial', '', 13);
$pdf->MultiCell(0, 6, utf8_decode(
    "Has interactuado exitosamente con las diferentes sesiones de la página 'Aprende', dentro del aplicativo desarrollado en el marco del proyecto 'Reciclando Juntas, Produciendo Futuro'."
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
