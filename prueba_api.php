<?php
header('Content-Type: application/json');

$apiKey = "PI2O5IRF7FQV3EHY"; 
$from_symbol = "USD";
$to_symbol = "MXN";

$url = "https://www.alphavantage.co/query?function=CURRENCY_EXCHANGE_RATE&from_currency={$from_symbol}&to_currency={$to_symbol}&apikey={$apiKey}";

// Usar cURL es más seguro en muchos servidores que file_get_contents
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (isset($data['Realtime Currency Exchange Rate'])) {
    $info = $data['Realtime Currency Exchange Rate'];
    echo json_encode([
        "precio" => number_format((float)$info['5. Exchange Rate'], 4),
        "hora"   => date("H:i:s"),
        "status" => "success"
    ]);
} else {
    // Esto te dirá exactamente qué está pasando (ej. "Límite de API alcanzado")
    $errorMsg = isset($data['Note']) ? $data['Note'] : "Error desconocido o límite excedido";
    echo json_encode([
        "precio" => "Error",
        "hora"   => date("H:i:s"),
        "error"  => $errorMsg
    ]);
}