<?php
// Indicamos que este archivo devolverá datos en formato JSON
header('Content-Type: application/json');

// URL directa al JSON de datos financieros de Yahoo para el par USD/MXN (Dólar a Peso Mexicano)
$url = 'https://query1.finance.yahoo.com/v8/finance/chart/MXN=X';

// Iniciamos cURL
$ch = curl_init();

// Configuramos cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// Un User-Agent básico
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
// Importante en XAMPP para que no falle por certificados
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

// Ejecutamos la petición
$respuesta_json = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($respuesta_json) {
    // Convertimos la respuesta de texto JSON a un arreglo de PHP
    $data = json_decode($respuesta_json, true);
    
    // Verificamos que la estructura esperada exista en el JSON
    if (isset($data['chart']['result'][0]['meta']['regularMarketPrice'])) {
        
        // Extraemos el precio exacto del mercado en tiempo real
        $precio = $data['chart']['result'][0]['meta']['regularMarketPrice'];
        
        // Lo dejamos en 2 decimales para el cotizador
        $precio_final = number_format((float)$precio, 2, '.', '');
        
        echo json_encode([
            'success' => true,
            'precio' => $precio_final
        ]);
        
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Estructura de Yahoo Finance no reconocida.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Error de conexión cURL: ' . $error
    ]);
}
?>