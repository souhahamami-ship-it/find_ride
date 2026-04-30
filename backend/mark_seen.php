<?php
include "connect.php";

$data = json_decode(file_get_contents("php://input"), true);

$user = $data['user_id'];
$other = $data['other_id'];
$ride = $data['ride_id'];

$sql = "UPDATE messages 
        SET status = 'seen'
        WHERE receiver_id = ? AND sender_id = ? AND ride_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user, $other, $ride);
$stmt->execute();

echo json_encode(["success"=>true]);
?>