<?php
include "connect.php";
header("Content-Type: application/json");
error_reporting(0);

$ride_id = intval($_GET['ride_id'] ?? 0);
$user1   = intval($_GET['user1']   ?? 0);
$user2   = intval($_GET['user2']   ?? 0);

if (!$ride_id || !$user1 || !$user2) {
    echo json_encode([]);
    exit;
}

$sql = "
    SELECT sender_id, receiver_id, message, created_at
    FROM messages
    WHERE ride_id = ?
      AND (
            (sender_id = ? AND receiver_id = ?)
         OR (sender_id = ? AND receiver_id = ?)
      )
    ORDER BY created_at ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiii", $ride_id, $user1, $user2, $user2, $user1);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        "sender_id"  => $row["sender_id"],
        "message"    => $row["message"],
        "created_at" => $row["created_at"]
    ];
}

echo json_encode($data);
?>