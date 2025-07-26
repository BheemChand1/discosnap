<?php
// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

include '../connection.php';

// Check connection
if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Invalid request method. Use POST."]);
    exit;
}

// Read the input data
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($input['user_id'], $input['club_id'], $input['rating']) || !is_numeric($input['rating']) || $input['rating'] < 1 || $input['rating'] > 5) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input. Ensure user_id, club_id, and rating (1-5) are provided."]);
    exit;
}

$user_id = (int) $input['user_id'];
$club_id = (int) $input['club_id'];
$rating = (int) $input['rating'];
$comment = isset($input['comment']) ? mysqli_real_escape_string($conn, trim($input['comment'])) : null;

// Insert query
$sql = "INSERT INTO ratings (user_id, club_id, rating, comment) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'iiis', $user_id, $club_id, $rating, $comment);

    if (mysqli_stmt_execute($stmt)) {
        http_response_code(201);
        echo json_encode(["message" => "Rating successfully inserted.", "rating_id" => mysqli_insert_id($conn)]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to insert rating."]);
    }

    mysqli_stmt_close($stmt);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to prepare the statement."]);
}

// Close the database connection
mysqli_close($conn);
