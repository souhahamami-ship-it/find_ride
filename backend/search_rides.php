<?php
header("Content-Type: application/json");
include "connect.php";

$departure = $_GET['departure'] ?? "";
$destination = $_GET['destination'] ?? "";
$date = $_GET['date'] ?? "";
$seats = $_GET['seats'] ?? "";
$maxPrice = $_GET['maxPrice'] ?? "";
$condition = $_GET['condition'] ?? "";
$vehicle = $_GET['vehicle'] ?? "";

$sql = "SELECT rides.*, users.first_name, users.last_name 
        FROM rides 
        JOIN users ON rides.user_id = users.id 
        WHERE 1=1";

// FILTERS
if ($departure != "") {
    $sql .= " AND rides.departure LIKE '%$departure%'";
}

if ($destination != "") {
    $sql .= " AND rides.destination LIKE '%$destination%'";
}

if ($date != "") {
    $sql .= " AND rides.date = '$date'";
}

if ($seats != "" && $seats != "Any") {
    if ($seats == "4+") {
        $sql .= " AND rides.seats >= 4";
    } else {
        $sql .= " AND rides.seats >= $seats";
    }
}

if ($maxPrice != "") {
    $sql .= " AND rides.price <= $maxPrice";
}

if ($vehicle != "" && $vehicle != "Any") {
    $sql .= " AND rides.vehicle LIKE '%$vehicle%'";
}

if ($condition != "" && $condition != "Any") {
    $sql .= " AND rides.conditions LIKE '%$condition%'";
}

// EXECUTE
$result = $conn->query($sql);

$rides = [];

while ($row = $result->fetch_assoc()) {
    $rides[] = $row;
}

echo json_encode($rides);
?>