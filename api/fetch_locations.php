<?php
include '../connection.php';

// Get the JSON input
$request_body = file_get_contents("php://input");
$data = json_decode($request_body, true);

// Get the language parameter from the JSON request
$lang = isset($data['lang']) ? $data['lang'] : 'he'; // Default to 'en' if not provided

// Validate language parameter
if (!in_array($lang, ['en', 'he'])) {
    $response = [
        "status" => "error",
        "code" => 400,
        "message" => "Invalid language parameter. Use 'en' or 'he'."
    ];
    http_response_code(400);
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

// Determine the correct column based on the selected language
$location_column = ($lang === 'he') ? 'location_he' : 'location_en';

// Fetch unique locations
$query = "SELECT c1.$location_column AS location, c1.latitude, c1.longitude
          FROM clients c1
          JOIN (
              SELECT $location_column, MIN(id) AS min_id
              FROM clients
              GROUP BY $location_column
          ) c2 ON c1.id = c2.min_id";

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "location" => $row["location"],
            "coordinates" => [
                "latitude" => (float)$row["latitude"],
                "longitude" => (float)$row["longitude"]
            ]
        ];
    }

    // Structured success response
    $response = [
        "status" => "success",
        "code" => 200,
        "count" => count($data),
        "data" => $data
    ];
    
    http_response_code(200);
    echo json_encode($response, JSON_PRETTY_PRINT);
} else {
    // No data found
    $response = [
        "status" => "error",
        "code" => 404,
        "message" => "No data found"
    ];
    
    http_response_code(404);
    echo json_encode($response, JSON_PRETTY_PRINT);
}

$conn->close();
?>
