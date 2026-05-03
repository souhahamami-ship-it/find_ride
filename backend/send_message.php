<?php
include "connect.php";

header("Content-Type: application/json");

// ✅ ONLY use POST (FormData)
$sender   = $_POST['sender_id'] ?? 0;
$receiver = $_POST['receiver_id'] ?? 0;
$ride     = $_POST['ride_id'] ?? 0;
$message  = $_POST['message'] ?? '';

// debug
if(!$sender || !$receiver || !$ride || !$message){
    echo json_encode([
        "error" => "Missing data",
        "_POST" => $_POST
    ]);
    exit;
}

// insert
$sql = "INSERT INTO messages (sender_id, receiver_id, ride_id, message)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if(!$stmt){
    echo json_encode(["error"=>$conn->error]);
    exit;
}

$stmt->bind_param("iiis", $sender, $receiver, $ride, $message);

if(!$stmt->execute()){
    echo json_encode(["error"=>$stmt->error]);
    exit;
}

echo json_encode(["success"=>true]);
?>