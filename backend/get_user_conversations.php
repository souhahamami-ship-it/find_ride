<?php
include "connect.php";
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 0);

$user_id = intval($_GET['user_id'] ?? 0);

if (!$user_id) {
    echo json_encode([]);
    exit;
}

// Simpler query — no subquery, no complex GROUP BY
$sql = "
    SELECT
        m.ride_id,
        IF(m.sender_id = ?, m.receiver_id, m.sender_id) AS other_id,
        u.first_name,
        u.last_name,
        m.message AS last_message,
        m.created_at AS last_time
    FROM messages m
    JOIN users u
        ON u.id = IF(m.sender_id = ?, m.receiver_id, m.sender_id)
    WHERE (m.sender_id = ? OR m.receiver_id = ?)
    AND m.id = (
        SELECT MAX(m2.id)
        FROM messages m2
        WHERE m2.ride_id = m.ride_id
          AND (
                (m2.sender_id = ? AND m2.receiver_id = IF(m.sender_id = ?, m.receiver_id, m.sender_id))
             OR (m2.receiver_id = ? AND m2.sender_id = IF(m.sender_id = ?, m.receiver_id, m.sender_id))
          )
    )
    GROUP BY m.ride_id, other_id
    ORDER BY m.id DESC
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["error" => $conn->error]);
    exit;
}

$stmt->bind_param("iiiiiiii",
    $user_id, $user_id,
    $user_id, $user_id,
    $user_id, $user_id,
    $user_id, $user_id
);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        "ride_id"      => (int)$row["ride_id"],
        "other_id"     => (int)$row["other_id"],
        "name"         => trim($row["first_name"] . " " . $row["last_name"]),
        "last_message" => $row["last_message"] ?? "",
        "time"         => date("H:i", strtotime($row["last_time"]))
    ];
}

echo json_encode($data);
?>