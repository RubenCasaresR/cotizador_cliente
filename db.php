<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "cotizador_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Error de conexión']));
}
?>