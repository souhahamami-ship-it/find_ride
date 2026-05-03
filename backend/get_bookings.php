<?php
include "connect.php";

header("Content-Type: application/json");
error_reporting(0);

$user_id = $_GET['user_id'] ?? 0;

$sql = "
SELECT 
    b.id,
    b.ride_id,
    b.status,

    r.departure,
    r.destination,
    r.date,
    r.time,

    u.id AS driver_id,
    u.first_name,
    u.last_name

FROM bookings b
LEFT JOIN rides r ON b.ride_id = r.id
LEFT JOIN users u ON r.user_id = u.id
WHERE b.user_id = ?
ORDER BY b.id DESC
";

$stmt = $conn->prepare($sql);

if(!$stmt){
    echo json_encode(["error"=>$conn->error]);
    exit;
}

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = [
        "id" => $row["id"],
        "ride_id" => $row["ride_id"],
        "status" => $row["status"],

        "departure" => $row["departure"] ?? "Unknown",
        "destination" => $row["destination"] ?? "Unknown",
        "date" => $row["date"] ?? "",
        "time" => $row["time"] ?? "",

        "driver_id" => $row["driver_id"] ?? 0,
        "driver_name" => trim(($row["first_name"] ?? "") . " " . ($row["last_name"] ?? "")) ?: "Driver"
    ];
}

echo json_encode($data);
exit;
?>