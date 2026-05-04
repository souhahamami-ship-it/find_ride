<?php
include "connect.php";
header("Content-Type: application/json");
error_reporting(0);

$data    = json_decode(file_get_contents("php://input"), true);
$user_id = intval($data['user_id'] ?? 0);
$field   = $data['field']   ?? '';
$value   = trim($data['value'] ?? '');

if (!$user_id || !$field || $value === '') {
    echo json_encode(["success" => false, "error" => "Missing data"]);
    exit;
}

if ($field === 'fullname') {
    $parts      = explode(' ', $value, 2);
    $first_name = $parts[0];
    $last_name  = $parts[1] ?? '';
    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=? WHERE id=?");
    $stmt->bind_param("ssi", $first_name, $last_name, $user_id);

} elseif ($field === 'email') {
    $stmt = $conn->prepare("UPDATE users SET email=? WHERE id=?");
    $stmt->bind_param("si", $value, $user_id);

} elseif ($field === 'phone') {
    $stmt = $conn->prepare("UPDATE users SET phone=? WHERE id=?");
    $stmt->bind_param("si", $value, $user_id);

} else {
    echo json_encode(["success" => false, "error" => "Field not allowed"]);
    exit;
}

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}
?>