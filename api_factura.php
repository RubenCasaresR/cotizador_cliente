<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$usuarioWeb = 'rubencasares';
$passwordWeb = '123456789';
$server = 'https://apisandbox.facturama.mx';

$action = $_GET['action'] ?? '';

function llamarFacturama($url, $method = 'GET', $postData = null) {
    global $usuarioWeb, $passwordWeb;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, $usuarioWeb . ':' . $passwordWeb);
    $headers = ['Content-Type: application/json'];
    if ($postData !== null) {
        $json = json_encode($postData);
        $headers[] = 'Content-Length: ' . strlen($json);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error) {
        return ['success' => false, 'error' => 'Error cURL: ' . $error];
    }
    $data = json_decode($response, true);
    if ($httpCode < 200 || $httpCode >= 300) {
        return ['success' => false, 'http_code' => $httpCode, 'error' => $data ?? $response];
    }
    return ['success' => true, 'data' => $data];
}

switch ($action) {

    case 'consultar':
        $id = $_GET['id'] ?? '';
        $uuid = $_GET['uuid'] ?? '';

        if ($id) {
            $result = llamarFacturama("$server/cfdi/$id?type=issued");
            if (!$result['success']) {
                echo json_encode($result);
                exit;
            }
            echo json_encode(['success' => true, 'factura' => $result['data']]);
            exit;
        }

        if ($uuid) {
            $result = llamarFacturama("$server/cfdi?type=issued&keyword=" . urlencode($uuid) . '&status=all');
            if (!$result['success']) {
                echo json_encode($result);
                exit;
            }
            $lista = $result['data'];
            if (empty($lista)) {
                echo json_encode(['success' => false, 'error' => 'No se encontró ninguna factura con ese UUID']);
                exit;
            }
            $item = $lista[0];
            if (isset($item['Complement']['TaxStamp']['Uuid'])) {
                $foundUuid = strtoupper($item['Complement']['TaxStamp']['Uuid']);
                $searchUuid = strtoupper($uuid);
                $match = null;
                foreach ($lista as $c) {
                    $cu = strtoupper($c['Complement']['TaxStamp']['Uuid'] ?? '');
                    if ($cu === $searchUuid) {
                        $match = $c;
                        break;
                    }
                }
                if (!$match) {
                    $match = $item;
                }
            } else {
                $match = $item;
            }
            $internalId = $match['Id'] ?? '';
            if (!$internalId) {
                echo json_encode(['success' => true, 'factura' => $match]);
                exit;
            }
            $detail = llamarFacturama("$server/cfdi/$internalId?type=issued");
            if (!$detail['success']) {
                echo json_encode(['success' => true, 'factura' => $match]);
                exit;
            }
            echo json_encode(['success' => true, 'factura' => $detail['data']]);
            exit;
        }

        echo json_encode(['success' => false, 'error' => 'Debe proporcionar id o uuid']);
        break;

    case 'listar':
        $q = $_GET['q'] ?? '';
        $tipo = $_GET['tipo'] ?? 'issued';
        $status = $_GET['status'] ?? 'all';
        $url = "$server/cfdi?type=" . urlencode($tipo) . '&status=' . urlencode($status);
        if ($q) {
            $url .= '&keyword=' . urlencode($q);
        }
        $result = llamarFacturama($url);
        if (!$result['success']) {
            echo json_encode($result);
            exit;
        }
        $lista = $result['data'] ?? [];
        $output = array_map(function($item) {
            return [
                'Id' => $item['Id'] ?? '',
                'Serie' => $item['Serie'] ?? '',
                'Folio' => $item['Folio'] ?? '',
                'Fecha' => $item['Date'] ?? '',
                'Receptor' => $item['Receiver']['Name'] ?? '',
                'ReceptorRfc' => $item['Receiver']['Rfc'] ?? '',
                'Total' => $item['Total'] ?? 0,
                'Moneda' => $item['Currency'] ?? '',
                'Uuid' => $item['Complement']['TaxStamp']['Uuid'] ?? '',
                'Emisor' => $item['Issuer']['TaxName'] ?? $item['Issuer']['Name'] ?? '',
            ];
        }, $lista);
        echo json_encode(['success' => true, 'facturas' => $output, 'total' => count($output)]);
        break;

    case 'descargar':
        $id = $_GET['id'] ?? '';
        $formato = $_GET['formato'] ?? 'xml';
        if (!in_array($formato, ['xml', 'pdf', 'html'])) {
            $formato = 'xml';
        }
        if (!$id) {
            echo json_encode(['success' => false, 'error' => 'Debe proporcionar el id de la factura']);
            exit;
        }
        $result = llamarFacturama("$server/cfdi/$formato/issued/$id");
        if (!$result['success']) {
            echo json_encode($result);
            exit;
        }
        $fileData = $result['data'];
        $content = $fileData['Content'] ?? '';
        $contentType = $fileData['ContentType'] ?? $formato;
        $contentEncoding = $fileData['ContentEncoding'] ?? 'base64';
        echo json_encode([
            'success' => true,
            'archivo' => [
                'content' => $content,
                'contentType' => $contentType,
                'contentEncoding' => $contentEncoding,
                'formato' => $formato
            ]
        ]);
        break;

    case 'estatus':
        $uuid = $_GET['uuid'] ?? '';
        $emisorRfc = $_GET['emisor_rfc'] ?? '';
        $receptorRfc = $_GET['receptor_rfc'] ?? '';
        $total = $_GET['total'] ?? '';
        if (!$uuid || !$emisorRfc || !$receptorRfc || !$total) {
            echo json_encode(['success' => false, 'error' => 'Faltan parámetros: uuid, emisor_rfc, receptor_rfc, total']);
            exit;
        }
        $url = "$server/cfdi/status/?uuid=" . urlencode($uuid)
            . '&issuerRfc=' . urlencode($emisorRfc)
            . '&receiverRfc=' . urlencode($receptorRfc)
            . '&total=' . urlencode($total);
        $result = llamarFacturama($url);
        echo json_encode($result);
        break;

    case 'catalogo':
        $tipo = $_GET['tipo'] ?? '';
        $keyword = $_GET['keyword'] ?? '';
        $mapa = [
            'paymentForms' => '/api/catalogs/PaymentForms',
            'paymentMethods' => '/api/catalogs/PaymentMethods',
            'cfdiUses' => '/api/catalogs/CfdiUses',
            'fiscalRegimens' => '/api/catalogs/FiscalRegimens',
            'productCodes' => '/api/catalogs/ProductsOrServices',
            'currencies' => '/api/catalogs/Currencies',
            'cfdiTypes' => '/api/catalogs/CfdiTypes',
            'units' => '/api/catalogs/Units',
            'postalCodes' => '/api/catalogs/PostalCodes',
        ];
        $path = $mapa[$tipo] ?? '';
        if (!$path) {
            echo json_encode(['success' => false, 'error' => 'Tipo de catálogo no válido']);
            exit;
        }
        $url = $server . $path;
        if ($keyword) {
            $url .= '?keyword=' . urlencode($keyword);
        }
        $result = llamarFacturama($url);
        echo json_encode($result);
        break;

    case 'emisor':
        $result = llamarFacturama("$server/api/TaxEntity");
        if (!$result['success']) {
            echo json_encode($result);
            exit;
        }
        $info = $result['data'];
        echo json_encode(['success' => true, 'emisor' => [
            'Rfc' => $info['Rfc'] ?? '',
            'Name' => $info['Name'] ?? '',
            'FiscalRegime' => $info['FiscalRegime'] ?? '',
            'TaxZipCode' => $info['TaxZipCode'] ?? '',
        ]]);
        break;

    case 'crear':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Método no permitido. Use POST']);
            exit;
        }
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            echo json_encode(['success' => false, 'error' => 'Datos JSON inválidos']);
            exit;
        }
        $result = llamarFacturama("$server/api/3/cfdis", 'POST', $input);
        if (!$result['success']) {
            echo json_encode($result);
            exit;
        }
        echo json_encode(['success' => true, 'factura' => $result['data']]);
        break;

    default:
        echo json_encode([
            'success' => false,
            'error' => 'Acción no válida. Use: consultar, listar, descargar, estatus, catalogo, emisor, crear',
            'ejemplos' => [
                'api_factura.php?action=consultar&id=ABC123',
                'api_factura.php?action=consultar&uuid=XXXX-XXXX-XXXX-XXXX',
                'api_factura.php?action=listar&q=escuela',
                'api_factura.php?action=descargar&id=ABC123&formato=xml',
                'api_factura.php?action=estatus&uuid=...&emisor_rfc=...&receptor_rfc=...&total=...',
                'api_factura.php?action=catalogo&tipo=paymentForms',
                'api_factura.php?action=emisor',
                'POST api_factura.php?action=crear'
            ]
        ]);
        break;
}
