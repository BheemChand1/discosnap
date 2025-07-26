<?php
header('Content-Type: application/json');

include '../connection.php';

// Read the request body
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

// Validate input
if (!isset($data['email'], $data['password'])) {
    echo json_encode(["error" => "Invalid input. Email and password are required."]);
    exit;
}

$email = trim($data['email']);
$password = trim($data['password']);

// Input validations
if (empty($email) || empty($password)) {
    echo json_encode(["error" => "Email and password are required."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["error" => "Invalid email format."]);
    exit;
}

// Escape inputs to prevent SQL injection
$email = mysqli_real_escape_string($conn, $email);

// Check if the user exists
$query = "SELECT id, password FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    echo json_encode(["error" => "Invalid email or password."]);
    exit;
}

$user = mysqli_fetch_assoc($result);

// Verify the password
if (!password_verify($password, $user['password'])) {
    echo json_encode(["error" => "Invalid email or password."]);
    exit;
}

// Send the success response with the user ID and status code 200
echo json_encode([
    "success" => "Login successful.",
    "user_id" => $user['id']
]);
http_response_code(200); // Set the HTTP status code to 200 (OK)

// Close the database connection
mysqli_close($conn);
?>
