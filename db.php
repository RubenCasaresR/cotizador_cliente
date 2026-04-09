<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "cotizador_db";
// $host = "sql111.infinityfree.com";
// $user = "if0_41605402";
// $pass = "nHJuwGMtJr";
// $db   = "if0_41605402_cotizador";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Error de conexión']));
}
?>


