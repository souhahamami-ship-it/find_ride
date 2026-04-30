<?php
include "connect.php";

$ride = $_GET['ride_id'];
$user1 = $_GET['user1'];
$user2 = $_GET['user2'];

$sql = "SELECT * FROM messages 
        WHERE ride_id = ?
        AND ((sender_id = ? AND receiver_id = ?) 
        OR (sender_id = ? AND receiver_id = ?))
        ORDER BY created_at ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiii", $ride, $user1, $user2, $user2, $user1);
$stmt->execute();

$result = $stmt->get_result();

$messages = [];
while($row = $result->fetch_assoc()){
    $messages[] = $row;
}

echo json_encode($messages);
?>