<?php
include 'db.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

// GUARDAR O ACTUALIZAR COTIZACIÓN
if ($action == 'guardar' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $d = json_decode(file_get_contents('php://input'), true);
    
    // Si viene con un ID, es una EDICIÓN
    if (isset($d['id']) && !empty($d['id'])) {
        $stmt = $conn->prepare("UPDATE cotizaciones SET usd=?, tc=?, comision_pct=?, comision_monto=?, total=? WHERE id=?");
        $stmt->bind_param("dddddi", $d['usd'], $d['tc'], $d['comision_pct'], $d['comision_monto'], $d['total'], $d['id']);
    } 
    // Si no tiene ID, es una cotización NUEVA
    else {
        $stmt = $conn->prepare("INSERT INTO cotizaciones (folio, tipo, usd, tc, comision_pct, comision_monto, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssddddd", $d['folio'], $d['tipo'], $d['usd'], $d['tc'], $d['comision_pct'], $d['comision_monto'], $d['total']);
    }
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}

// ELIMINAR (SOFT DELETE)
if ($action == 'eliminar' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $d = json_decode(file_get_contents('php://input'), true);
    
    // Cambiamos 'activo' a 0 en lugar de usar DELETE FROM
    $stmt = $conn->prepare("UPDATE cotizaciones SET activo = 0 WHERE id = ?");
    $stmt->bind_param("i", $d['id']);
    
    echo json_encode(['success' => $stmt->execute()]);
}

// OBTENER HISTORIAL (Solo activos)
if ($action == 'listar') {
    // Aumentamos el límite para que el Data Table tenga información que buscar y paginar
    $result = $conn->query("SELECT * FROM cotizaciones WHERE activo = 1 ORDER BY fecha_hora DESC LIMIT 1000");
    $data = [];
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}
?>