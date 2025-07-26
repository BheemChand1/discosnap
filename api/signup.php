<?php
header('Content-Type: application/json');

include '../connection.php';

// Read the request body
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

// Validate input
if (!isset($data['name'], $data['email'], $data['password'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Invalid input. Name, email, and password are required."]);
    exit;
}

$name = trim($data['name']);
$email = trim($data['email']);
$password = trim($data['password']);

// Input validations
if (empty($name) || empty($email) || empty($password)) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "All fields are required."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Invalid email format."]);
    exit;
}

if (strlen($password) < 6) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Password must be at least 6 characters long."]);
    exit;
}

// Escape inputs to prevent SQL injection
$name = mysqli_real_escape_string($conn, $name);
$email = mysqli_real_escape_string($conn, $email);

// Check if email already exists
$query = "SELECT id FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    http_response_code(409); // Conflict
    echo json_encode(["error" => "Email already exists."]);
    exit;
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insert new user
$query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

if (mysqli_query($conn, $query)) {
    // Get the last inserted user ID
    $user_id = mysqli_insert_id($conn);

    // Send the success response with the user ID
    http_response_code(201); // Created
    echo json_encode([
        "success" => "User registered successfully.",
        "user_id" => $user_id
    ]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database error: " . mysqli_error($conn)]);
}

// Close the database connection
mysqli_close($conn);
?>