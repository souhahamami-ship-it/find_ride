<?php
ob_start();
header("Content-Type: application/json");

// 🔗 connect DB
include "connect.php";

// 📥 read JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    ob_clean();
    echo json_encode(["error" => "No data received"]);
    exit;
}

// 🧹 sanitize
$first = $conn->real_escape_string($data['first_name'] ?? '');
$last  = $conn->real_escape_string($data['last_name'] ?? '');
$email = $conn->real_escape_string($data['email'] ?? '');
$pass  = $data['password'] ?? '';
$user_type = $conn->real_escape_string($data['user_type'] ?? '');
$vehicle   = $conn->real_escape_string($data['vehicle'] ?? '');
$cin       = $conn->real_escape_string($data['cin'] ?? '');
$address   = $conn->real_escape_string($data['address'] ?? '');

// ✅ validation
if (!$first || !$last || !$email || !$pass) {
    ob_clean();
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}

// 🔐 hash password
$hashed = password_hash($pass, PASSWORD_DEFAULT);

// 🔎 check email
$check = $conn->query("SELECT id FROM users WHERE email='$email'");
if ($check && $check->num_rows > 0) {
    ob_clean();
    echo json_encode(["error" => "Email already exists"]);
    exit;
}

// 📝 insert
$sql = "INSERT INTO users 
(first_name, last_name, email, password, user_type, vehicle, cin, address)
VALUES 
('$first', '$last', '$email', '$hashed', '$user_type', '$vehicle', '$cin', '$address')";

if ($conn->query($sql)) {
    ob_clean();
    echo json_encode([
        "message" => "User registered successfully ✅"
    ]);
} else {
    ob_clean();
    echo json_encode([
        "error" => "Database error: " . $conn->error
    ]);
}
?>