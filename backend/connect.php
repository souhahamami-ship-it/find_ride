<?php
// ❌ ما تحط حتى space قبل هذا

mysqli_report(MYSQLI_REPORT_OFF);

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "find_ride";
$port = 3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    header("Content-Type: application/json");
    echo json_encode([
        "error" => "DB connection failed"
    ]);
    exit;
}
?>