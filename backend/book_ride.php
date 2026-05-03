<?php
header("Content-Type: application/json");
include "connect.php";

$data = json_decode(file_get_contents("php://input"), true);

$user_id = intval($data['user_id'] ?? 0);
$ride_id = intval($data['ride_id'] ?? 0);
// 🚫 Prevent booking own ride
$sql = "SELECT user_id FROM rides WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ride_id);
$stmt->execute();

$result = $stmt->get_result();
$ride = $result->fetch_assoc();

if ($ride && $ride['user_id'] == $user_id) {
    echo json_encode(["error" => "You cannot book your own ride ❌"]);
    exit;
}

if (!$user_id || !$ride_id) {
    echo json_encode(["error" => "Missing data"]);
    exit;
}

// check duplicate
$check = $conn->query("SELECT id FROM bookings WHERE user_id=$user_id AND ride_id=$ride_id");

if ($check && $check->num_rows > 0) {
    echo json_encode(["error" => "Already booked"]);
    exit;
}

// insert
$sql = "INSERT INTO bookings (user_id, ride_id) VALUES ($user_id, $ride_id)";

if ($conn->query($sql)) {
    echo json_encode(["message" => "Booking added"]);
} else {
    echo json_encode(["error" => $conn->error]);
}
?>