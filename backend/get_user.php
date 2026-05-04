<?php
header("Content-Type: application/json");
include "connect.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["error" => "Missing ID"]);
    exit;
}

$id = intval($_GET['id']);

// ✅ Add phone (and any other fields you need)
$sql = "SELECT id, first_name, last_name, email, phone, user_type FROM users WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    echo json_encode(["error" => "User not found"]);
    exit;
}

$user = $result->fetch_assoc();

// ✅ Make sure phone is never null
$user['phone'] = $user['phone'] ?? '—';

echo json_encode($user);
?>