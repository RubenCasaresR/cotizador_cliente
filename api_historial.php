<?php
$pais = $_GET['pais'] ?? 'usa';
if ($pais === 'china') { include 'db_china.php'; } else { include 'db.php'; }

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

if ($action == 'guardar' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $d = json_decode(file_get_contents('php://input'), true);

    if (isset($d['id']) && !empty($d['id'])) {
        $stmt = $conn->prepare("UPDATE cotizaciones SET cliente_nombre=?, cliente_correo=?, usd=?, tc=?, comision_pct=?, comision_monto=?, total=? WHERE id=?");
        $stmt->bind_param("ssdddddi", $d['cliente_nombre'], $d['cliente_correo'], $d['usd'], $d['tc'], $d['comision_pct'], $d['comision_monto'], $d['total'], $d['id']);
    }
    else {
        $stmt = $conn->prepare("INSERT INTO cotizaciones (folio, tipo, cliente_nombre, cliente_correo, usd, tc, comision_pct, comision_monto, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssddddd", $d['folio'], $d['tipo'], $d['cliente_nombre'], $d['cliente_correo'], $d['usd'], $d['tc'], $d['comision_pct'], $d['comision_monto'], $d['total']);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}

if ($action == 'eliminar' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $d = json_decode(file_get_contents('php://input'), true);

    $stmt = $conn->prepare("UPDATE cotizaciones SET activo = 0 WHERE id = ?");
    $stmt->bind_param("i", $d['id']);

    echo json_encode(['success' => $stmt->execute()]);
}

if ($action == 'listar') {
    $cliente = $_GET['cliente'] ?? '';

    if ($cliente) {
        $stmt = $conn->prepare("SELECT * FROM cotizaciones WHERE activo = 1 AND cliente_nombre LIKE ? ORDER BY fecha_hora DESC LIMIT 1000");
        $like = "%$cliente%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("SELECT * FROM cotizaciones WHERE activo = 1 ORDER BY fecha_hora DESC LIMIT 1000");
    }

    $data = [];
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}
?>
