
<?php
header("Content-Type: application/json");
include "connect.php";

// check id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["error" => "Missing ID"]);
    exit;
}

$id = intval($_GET['id']); // 🔥 حماية

$sql = "SELECT id, first_name, last_name, email, user_type FROM users WHERE id=$id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    echo json_encode(["error" => "User not found"]);
    exit;
}

$user = $result->fetch_assoc();

echo json_encode($user);
?>