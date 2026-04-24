<?php
header("Content-Type: application/json");
include "connect.php";

if (!isset($_GET['user_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = intval($_GET['user_id']);

$result = $conn->query("SELECT * FROM rides WHERE user_id=$user_id");

if (!$result) {
    echo json_encode(["error" => $conn->error]);
    exit;
}

$rides = [];

while ($row = $result->fetch_assoc()) {
    $rides[] = $row;
}

echo json_encode($rides);
?>