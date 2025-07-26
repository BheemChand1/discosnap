<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Database connection
include '../connection.php';

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check if user_id is provided
if (!isset($data['user_id']) || empty($data['user_id'])) {
    echo json_encode(["error" => "User ID is required"]);
    exit();
}

$user_id = mysqli_real_escape_string($conn, $data['user_id']);

// Fetch user details
$sql = "SELECT name, email FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "user" => [
            "name" => $user['name'],
            "email" => $user['email']
        ]
    ]);
} else {
    echo json_encode(["error" => "User not found"]);
}

$conn->close();