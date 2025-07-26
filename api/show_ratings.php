<?php
header('Content-Type: application/json');

include '../connection.php';

// Check for connection errors
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Get the JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Check if the input is valid JSON and contains client_id
if (!isset($input['client_id']) || !is_numeric($input['client_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid client ID."]);
    exit;
}

$client_id = intval($input['client_id']);

// Query to fetch total rating, average rating, and all comments
$query = "
    SELECT r.id,r.rating,r.user_id, r.comment, r.created_at, u.name AS user_name
    FROM ratings r
    INNER JOIN users u ON r.user_id = u.id
    WHERE r.club_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $ratings = [];
    $totalRating = 0;
    $ratingCount = 0;

    while ($row = $result->fetch_assoc()) {
        $ratings[] = [
            'rating_id' => $row['id'],
            'rating' => $row['rating'],
            'comment' => $row['comment'],
            'user_id' => $row['user_id'],
            'user_name' => $row['user_name'],
            'created_at' => $row['created_at']
        ];
        $totalRating += $row['rating'];
        $ratingCount++;
    }

    $averageRating = $ratingCount > 0 ? $totalRating / $ratingCount : 0;

    http_response_code(200);
    echo json_encode([
        'client_id' => $client_id,
        'total_rating' => $totalRating,
        'average_rating' => round($averageRating, 2),
        'rating_count' => $ratingCount,
        'ratings' => $ratings
    ]);
} else {
    http_response_code(404);
    echo json_encode([
        'client_id' => $client_id,
        'message' => 'No ratings found for this client.'
    ]);
}

$stmt->close();
$conn->close();
?>