<?php
include "connect.php";

header("Content-Type: application/json");
error_reporting(0);

$ride_id = intval($_GET['ride_id'] ?? 0);

if (!$ride_id) {
    echo json_encode([]);
    exit;
}

// Get everyone who booked THIS specific ride (by ride_id, not user_id)
$sql = "
    SELECT 
        b.id,
        b.ride_id,
        b.status,
        b.seats_booked,

        r.date,

        u.id   AS passenger_id,
        u.first_name,
        u.last_name

    FROM bookings b
    LEFT JOIN rides r ON b.ride_id = r.id
    LEFT JOIN users u ON b.user_id = u.id   -- ← passenger, not driver
    WHERE b.ride_id = ?
    ORDER BY b.id DESC
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["error" => $conn->error]);
    exit;
}

$stmt->bind_param("i", $ride_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        "id"             => $row["id"],
        "ride_id"        => $row["ride_id"],
        "status"         => $row["status"] ?? "pending",
        "seats_booked"   => $row["seats_booked"] ?? 1,
        "date"           => $row["date"] ?? "",
        "passenger_id"   => $row["passenger_id"],
        "passenger_name" => trim(($row["first_name"] ?? "") . " " . ($row["last_name"] ?? "")) ?: "Passenger"
    ];
}

echo json_encode($data);
?>