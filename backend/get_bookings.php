<?php
header("Content-Type: application/json");
include "connect.php";

$user_id = intval($_GET['user_id']);

$sql = "SELECT rides.* 
        FROM bookings 
        JOIN rides ON bookings.ride_id = rides.id
        WHERE bookings.user_id = $user_id";

$result = $conn->query($sql);

$bookings = [];

while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

echo json_encode($bookings);
?>