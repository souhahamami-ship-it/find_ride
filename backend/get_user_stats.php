<?php
include "connect.php";

$user_id = $_GET['user_id'];

$sql = "SELECT COUNT(*) as total FROM rides WHERE user_id=$user_id";
$total = $conn->query($sql)->fetch_assoc()['total'];

echo json_encode([
    "totalTrips" => $total,
    //"rating" => 0, // mock or calculate later
    //"responseRate" => "0%"
]);
?>