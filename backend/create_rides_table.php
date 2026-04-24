<?php
$conn = new mysqli("localhost", "root", "", "find_ride");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS rides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    departure VARCHAR(100),
    destination VARCHAR(100),
    date DATE,
    seats INT,
    price INT,
    vehicle VARCHAR(50),
    conditions TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Rides table created successfully ✅";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>