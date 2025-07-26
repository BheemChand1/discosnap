<?php
// Enable CORS for local development if needed
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

include '../connection.php';

try {
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(["error" => "Database connection failed."]);
        exit;
    }

    // Get the incoming request data
    $inputData = json_decode(file_get_contents("php://input"), true);

    if (!isset($inputData['rating_id'])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing required parameter: rating_id"]);
        exit;
    }

    $rating_id = $conn->real_escape_string($inputData['rating_id']);

    // Delete the rating
    $query = "DELETE FROM ratings WHERE id = '$rating_id'";
    $result = $conn->query($query);

    if ($result && $conn->affected_rows > 0) {
        http_response_code(200);
        echo json_encode(["message" => "Rating deleted successfully."]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Rating not found or already deleted."]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal server error."]);
} finally {
    $conn->close();
}
