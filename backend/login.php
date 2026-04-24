<?php
ob_start();
header("Content-Type: application/json");

include "connect.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    ob_clean();
    echo json_encode(["error" => "No data received"]);
    exit;
}

$email = $conn->real_escape_string($data['email'] ?? '');
$password = $data['password'] ?? '';

if (!$email || !$password) {
    ob_clean();
    echo json_encode(["error" => "Missing fields"]);
    exit;
}

$result = $conn->query("SELECT * FROM users WHERE email='$email'");

if (!$result || $result->num_rows === 0) {
    ob_clean();
    echo json_encode(["error" => "User not found"]);
    exit;
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    ob_clean();
    echo json_encode(["error" => "Incorrect password"]);
    exit;
}

ob_clean();
echo json_encode([
    "user" => [
        "id" => $user['id'],
        "firstName" => $user['first_name'],
        "lastName" => $user['last_name'],
        "email" => $user['email']
    ]
]);