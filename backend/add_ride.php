<?php

ob_start();
header("Content-Type: application/json");

include "connect.php";

// read JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    ob_clean();
    echo json_encode(["error" => "No data received"]);
    exit;
}

// values
$user_id = intval($data['user_id'] ?? 0);
$departure = $conn->real_escape_string($data['departure'] ?? '');
$destination = $conn->real_escape_string($data['destination'] ?? '');
$date = $conn->real_escape_string($data['date'] ?? '');
$time = $conn->real_escape_string($data['time'] ?? '');
$seats = intval($data['seats'] ?? 0);
$price = intval($data['price'] ?? 0);
$vehicle = $conn->real_escape_string($data['category'] ?? '');
$conditions = $conn->real_escape_string(json_encode($data['preferences'] ?? []));
$notes = $conn->real_escape_string($data['notes'] ?? '');

// validation
if (!$user_id || !$departure || !$destination || !$date || !$time) {
    ob_clean();
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}

// insert
$sql = "INSERT INTO rides 
(user_id, departure, destination, date, time, seats, price, vehicle, conditions, notes)
VALUES 
('$user_id', '$departure', '$destination', '$date', '$time', '$seats', '$price', '$vehicle', '$conditions', '$notes')";

if ($conn->query($sql)) {
    ob_clean();
    echo json_encode(["message" => "Ride added successfully 🚗"]);
} else {
    ob_clean();
    echo json_encode(["error" => $conn->error]);
}
?>