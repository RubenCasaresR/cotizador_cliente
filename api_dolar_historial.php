<?php
header('Content-Type: application/json');

$range = $_GET['range'] ?? '1d';

$intervalMap = [
    '1d' => '1m',
    '5d' => '5m',
    '1mo' => '30m',
];

$interval = $intervalMap[$range] ?? '5m';

$url = "https://query1.finance.yahoo.com/v8/finance/chart/MXN=X?range={$range}&interval={$interval}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$respuesta = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if (!$respuesta) {
    echo json_encode(['success' => false, 'error' => $error]);
    exit;
}

$data = json_decode($respuesta, true);

if (!isset($data['chart']['result'][0])) {
    echo json_encode(['success' => false, 'error' => 'No se encontraron datos']);
    exit;
}

$result = $data['chart']['result'][0];
$timestamps = $result['timestamp'] ?? [];
$quotes = $result['indicators']['quote'][0] ?? [];
$closes = $quotes['close'] ?? [];

$points = [];
for ($i = 0; $i < count($timestamps); $i++) {
    if (isset($closes[$i]) && $closes[$i] !== null) {
        $points[] = [
            'time' => $timestamps[$i],
            'close' => round($closes[$i], 4),
        ];
    }
}

echo json_encode(['success' => true, 'points' => $points, 'range' => $range]);
