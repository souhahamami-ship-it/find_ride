<?php
include "connect.php";

$user_id = $_GET['user_id'];

$sql = "
SELECT 
    m.ride_id,
    IF(m.sender_id = $user_id, m.receiver_id, m.sender_id) AS other_id,
    u.first_name,
    u.last_name,
    MAX(m.created_at) as last_time,
    SUBSTRING_INDEX(GROUP_CONCAT(m.message ORDER BY m.created_at DESC), ',', 1) AS last_message
FROM messages m
JOIN users u 
    ON u.id = IF(m.sender_id = $user_id, m.receiver_id, m.sender_id)
WHERE m.sender_id = $user_id OR m.receiver_id = $user_id
GROUP BY ride_id, other_id
ORDER BY last_time DESC
";

$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = [
        "ride_id" => $row["ride_id"],
        "other_id" => $row["other_id"],
        "name" => $row["first_name"] . " " . $row["last_name"],
        "last_message" => $row["last_message"],
        "time" => date("H:i", strtotime($row["last_time"]))
    ];
}

echo json_encode($data);
?>