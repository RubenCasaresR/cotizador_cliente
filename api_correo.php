<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Metodo no permitido']);
    exit;
}

$d = json_decode(file_get_contents('php://input'), true);

$correo = trim($d['correo'] ?? '');
$nombre = trim($d['nombre'] ?? '');
$folio  = trim($d['folio'] ?? '');
$pdfBase64 = $d['pdfBase64'] ?? '';

if (!$correo || !$nombre || !$folio || !$pdfBase64) {
    echo json_encode(['success' => false, 'error' => 'Faltan datos requeridos']);
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Correo electronico no valido']);
    exit;
}

if (strpos($pdfBase64, 'data:application/pdf;base64,') === 0) {
    $pdfBase64 = substr($pdfBase64, 28);
}

$pdfData = base64_decode($pdfBase64, true);
if ($pdfData === false) {
    echo json_encode(['success' => false, 'error' => 'Error al decodificar el PDF']);
    exit;
}

$asunto = "Cotizacion $folio - USD/MXN";
$boundary = "boundary_" . md5(uniqid(mt_rand(), true));

$cabeceras  = "MIME-Version: 1.0\r\n";
$cabeceras .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
$cabeceras .= "From: no-reply@cotizadordivisas.com\r\n";
$cabeceras .= "Reply-To: no-reply@cotizadordivisas.com\r\n";

$cuerpo  = "--$boundary\r\n";
$cuerpo .= "Content-Type: text/plain; charset=utf-8\r\n";
$cuerpo .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
$cuerpo .= "Hola $nombre,\n\n";
$cuerpo .= "Adjunto encontraras la cotizacion $folio con los detalles de la operacion cambiaria.\n\n";
$cuerpo .= "Este documento tiene una vigencia de 30 minutos a partir de su emision.\n\n";
$cuerpo .= "Saludos,\nEquipo de Divisas\n";
$cuerpo .= "\r\n--$boundary\r\n";
$cuerpo .= "Content-Type: application/pdf; name=\"Cotizacion_$folio.pdf\"\r\n";
$cuerpo .= "Content-Disposition: attachment; filename=\"Cotizacion_$folio.pdf\"\r\n";
$cuerpo .= "Content-Transfer-Encoding: base64\r\n\r\n";
$cuerpo .= chunk_split($pdfBase64, 76, "\r\n");
$cuerpo .= "\r\n--$boundary--";

$ok = mail($correo, $asunto, $cuerpo, $cabeceras);

if ($ok) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error al enviar el correo']);
}
