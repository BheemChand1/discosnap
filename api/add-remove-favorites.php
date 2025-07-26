<?php
header('Content-Type: application/json');
include('../connection.php'); // Include your database connection file

// Get raw POST data
$data = json_decode(file_get_contents("php://input"));

// Check if required fields are provided
if (isset($data->user_id) && isset($data->client_id) && isset($data->action)) {
    $user_id = $data->user_id;
    $client_id = $data->client_id;
    $action = strtolower($data->action); // Normalize action to lowercase

    if ($action === "add") {
        // Check if favorite already exists
        $checkQuery = $conn->prepare("SELECT id FROM favorites WHERE user_id = ? AND club_id = ?");
        $checkQuery->bind_param("ii", $user_id, $client_id);
        $checkQuery->execute();
        $checkQuery->store_result();

        if ($checkQuery->num_rows > 0) {
            http_response_code(409); // Conflict
            echo json_encode(["message" => "This club is already in your favorites"]);
        } else {
            // Add favorite
            if ($stmt = $conn->prepare("INSERT INTO favorites (user_id, club_id) VALUES (?, ?)")) {
                $stmt->bind_param("ii", $user_id, $client_id);

                if ($stmt->execute()) {
                    http_response_code(201); // Created
                    echo json_encode(["message" => "Favorite added successfully"]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(["message" => "Failed to add favorite"]);
                }
                $stmt->close();
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Failed to prepare statement for adding"]);
            }
        }
        $checkQuery->close();
    } elseif ($action === "remove") {
        // Remove favorite
        if ($stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND club_id = ?")) {
            $stmt->bind_param("ii", $user_id, $client_id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    http_response_code(200); // OK
                    echo json_encode(["message" => "Favorite removed successfully"]);
                } else {
                    http_response_code(404); // Not Found
                    echo json_encode(["message" => "Favorite not found"]);
                }
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Failed to remove favorite"]);
            }
            $stmt->close();
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Failed to prepare statement for removal"]);
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(["message" => "Invalid action. Use 'add' or 'remove'"]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "user_id, client_id, and action are required"]);
}

// Close connection
$conn->close();
?>
