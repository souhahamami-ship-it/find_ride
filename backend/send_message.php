<?php
include "connect.php";

$data = json_decode(file_get_contents("php://input"), true);

$sender = $data['sender_id'];
$receiver = $data['receiver_id'];
$ride = $data['ride_id'];
$message = $data['message'];

$sql = "INSERT INTO messages (sender_id, receiver_id, ride_id, message, status)
        VALUES (?, ?, ?, ?, 'sent')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiis", $sender, $receiver, $ride, $message);

$stmt->execute();

echo json_encode(["success" => true]);
?>