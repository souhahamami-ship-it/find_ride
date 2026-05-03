<?php
include "connect.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$booking_id = $data['booking_id'] ?? 0;

if(!$booking_id){
    echo json_encode(["success"=>false, "error"=>"No ID"]);
    exit;
}

$sql = "DELETE FROM bookings WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);

$stmt->execute();

echo json_encode([
    "success" => true,
    "affected" => $stmt->affected_rows
]);
echo json_encode([
    "success" => true,
    "affected" => $stmt->affected_rows,
    "received_id" => $booking_id
]);
?>